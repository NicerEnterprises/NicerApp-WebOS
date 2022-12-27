<?php 
$rootPathNA = realpath(dirname(__FILE__).'/../..').'/NicerAppWebOS';
require_once ($rootPathNA.'/boot.php');
global $naIP;

$debug = false;
if ($debug) {
    echo 'info : '.__FILE__.' : $debug = true.<br/>'.PHP_EOL;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    echo '<pre>';
}

$date = new DateTime();
$ip = (array_key_exists('X-Forwarded-For',apache_request_headers())?apache_request_headers()['X-Forwarded-For'] : $_SERVER['REMOTE_ADDR']);
/*if (
    $ip !== '::1'
    && $ip !== '127.0.0.1'
    && $ip !== '80.101.238.137'
) {
    header('HTTP/1.0 403 Forbidden');
    echo '403 - Access forbidden.';
    exit();
}*/

global $naWebOS;
$cdbDomain = $naWebOS->domainForDB;//str_replace('.','_',$naWebOS->domain);

$cdb = $naWebOS->dbs->findConnection('couchdb')->cdb;

$dbName = $cdbDomain.'___data_themes';
$cdb->setDatabase($dbName, false);


$findCommand = array (
    'selector' => array(
        'theme' => $_POST['theme']
    ),
    'fields' => array(
        '_id', '_rev'
    )
);
if ($debug) { echo 't1 $findCommand='; var_dump ($findCommand); echo PHP_EOL.PHP_EOL; }

if (array_key_exists('specificityName',$_POST) && !is_null($_POST['specificityName'])) $findCommand['selector']['specificityName'] = $_POST['specificityName'];
if (array_key_exists('view',$_POST) && !is_null($_POST['view'])) $findCommand['selector']['view'] = $_POST['view'];
if (array_key_exists('url',$_POST) && !is_null($_POST['url'])) $findCommand['selector']['url'] = $_POST['url'];
if (array_key_exists('role',$_POST) && !is_null($_POST['role'])) $findCommand['selector']['role'] = $_POST['role'];
if (array_key_exists('user',$_POST) && !is_null($_POST['user'])) $findCommand['selector']['user'] = $_POST['user'];


$call = $cdb->find ($findCommand);
if ($debug) { echo '$call='; var_dump ($call); echo PHP_EOL.PHP_EOL; }

if (!$call->headers->_HTTP->status===200) { 
    $id = cdb_randomString(20); 
    $rec = array('id'=>$id);
} else {
    //echo '<pre>'; var_dump ($call->body); die();
    if (array_key_exists(0, $call->body->docs)) {
        $id = $call->body->docs[0]->_id;
        $call = $cdb->get($id);
        //echo json_encode($call, JSON_PRETTY_PRINT).'<br/>'.PHP_EOL; exit();
        $rec = (array)$call->body;
    } else {
        $id = cdb_randomString(20); 
        $rec = array('id'=>$id);
    }
}

$rec2 = array (
    'theme' => $_POST['theme'],
    'textBackgroundOpacity' => floatval($_POST['textBackgroundOpacity']),
    'dialogs' => json_decode($_POST['dialogs'], true),
    'backgroundSearchKey' => $_POST['backgroundSearchKey'],
    'background' => $_POST['background'],
    'backgroundChange_hours' => $_POST['backgroundChange_hours'],
    'backgroundChange_minutes' => $_POST['backgroundChange_minutes'],
    'changeBackgroundsAutomatically' => $_POST['changeBackgroundsAutomatically'],
    'menusFadingSpeed' => $_POST['menusFadingSpeed'],
    'menusUseRainbowPanels' => $_POST['menusUseRainbowPanels'],
    'ip' => $naIP,
    'ua' => $_SERVER['HTTP_USER_AGENT'],
    'lastUsed' => date('U')
);
if (array_key_exists('specificityName',$_POST) && !is_null($_POST['specificityName'])) $rec2['specificityName'] = $_POST['specificityName'];
if (array_key_exists('view',$_POST) && !is_null($_POST['view'])) $rec2['view'] = $_POST['view'];
if (array_key_exists('url',$_POST) && !is_null($_POST['url'])) $rec2['url'] = $_POST['url'];
if (array_key_exists('role',$_POST) && !is_null($_POST['role'])) $rec2['role'] = $_POST['role'];
if (array_key_exists('user',$_POST) && !is_null($_POST['user'])) $rec2['user'] = $_POST['user'];

/*if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', 3600);
    session_start();
};*/

if (!isset($_SESSION) || !is_array($_SESSION) || !array_key_exists('selectors',$_SESSION)) {
    echo 'Session does not contain required "selectors" data.'; exit();
} else {
    $selectors = json_decode ($_SESSION['selectors'],true);
    $selectorNames = json_decode ($_SESSION['selectorNames'],true);
    $selectorName = $_SESSION['selectorName'];
    $preferredSelectorName = $_SESSION['preferredSelectorName'];
    foreach ($selectorNames as $idx => $sn) if ($sn == $preferredSelectorName) break;
    $sel = $selectors[$idx];
    if ($debug) { echo '$sel='; var_dump ($sel); }
    if (!array_key_exists('permissions',$sel)) {
        echo 'SESSION selector does not contain a "permissions" entry.'; exit();
    } else {
        if (!array_key_exists('write', $sel['permissions'])) {
            echo 'SESSION selector does not contain a "write" entry under "permissions".'; exit();
        }
    }
    foreach ($sel['permissions']['write'] as $pur => $urName) { // pur = permissionsUserRole, urName = userOrRoleName

        $permissions = $sel['permissions'];
        
        global $naWebOS;
        
        // check permissions
        $hasPermission = false;
        $roles = $naWebOS->dbs->findConnection('couchdb')->roles;
        if ($debug) { echo '<pre>$permissions='; var_dump ($permissions); echo '</pre>'.PHP_EOL.PHP_EOL; };
        foreach ($permissions as $permissionType => $accounts) {
            if ($debug) { echo '<pre>$accounts='; var_dump ($accounts); echo '</pre>'.PHP_EOL.PHP_EOL; };
            if ($permissionType=='write') {
                foreach ($accounts as $accountType => $userOrGroupID) {
                    if ($accountType == 'role') {
                        foreach ($roles as $roleIdx => $groupID) {
                            if ($userOrGroupID==$groupID) {
                                $hasPermission = true;
                            }
                        }
                    }
                    if ($accountType == 'user' && $_COOKIE['cdb_loginName'] == $userOrGroupID) {
                        $hasPermission = true;
                    }
                }
            }
        }
        if (!$hasPermission) {
            if ($debug) echo 'User '.$username.' has no permission to write this data into the database.'.PHP_EOL;
            echo 'status : Failed.';
            exit();
        }        
    }    
}

$cdb->setDatabase($dbName, false);

$rec = array_merge ($rec, $rec2);
if ($debug) { echo '<pre>'; var_dump ($rec); var_dump($_POST); var_dump(json_last_error()); echo '</pre>'.PHP_EOL.PHP_EOL; }
try {
    $call3 = $cdb->post($rec);
} catch (Exception $e) {
    if ($debug) {
        echo 'status : Failed : could not update record in database ('.$dbName.').<br/>'.PHP_EOL;
        echo '$rec = <pre style="color:blue">'.PHP_EOL; var_dump ($rec); echo PHP_EOL.'</pre>'.PHP_EOL;
        echo '$call3 = <pre style="color:red">'.PHP_EOL; var_dump ($call3); echo PHP_EOL.'</pre>'.PHP_EOL;
        echo '$e = <pre style="color:red">'.PHP_EOL; var_dump ($e); echo PHP_EOL.'</pre>'.PHP_EOL; 
        exit();
    
    } else {
        echo 'status : Failed.'; exit();
    }
}
if ($debug) { echo '<pre>$call3='; var_dump ($call3); var_dump($_POST); var_dump(json_last_error()); echo '</pre>'.PHP_EOL.PHP_EOL; }
        
if ($call3->headers->_HTTP->status=='201' || $call3->headers->_HTTP->status=='200') {
    echo 'status : Success';
} else {
    echo 'status : Failed';
}
?>
