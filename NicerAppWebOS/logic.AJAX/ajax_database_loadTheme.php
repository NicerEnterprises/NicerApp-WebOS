<?php 
$rootPathNA = realpath(dirname(__FILE__).'/../..').'/NicerAppWebOS';
require_once ($rootPathNA.'/boot.php');

global $naDebugAll;
global $naIP;
$debug = false;
if ($debug) {
    echo 'info : '.__FILE__.' : $debug = true.<br/>'.PHP_EOL;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

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
$cdbDomain = $naWebOS->domainForDB; //str_replace('.','_',$naWebOS->domain);
$cdb = $naWebOS->dbs->findConnection('couchdb')->cdb;
$dbName = $cdbDomain.'___data_themes';
$cdb->setDatabase($dbName, false);
try {
    $call = $cdb->getAllDocs();
    //var_dump ($call); exit();
    $callOK = $call->status === '200';
} catch (Exception $e) {
    if ($debug) {
        echo 'info : database does not yet exist ('.$dbName.').<br/>'.PHP_EOL;
        echo '<pre style="color:red">'.PHP_EOL; var_dump ($e); echo PHP_EOL.'</pre>'.PHP_EOL; 
       // exit();
    }
}

//var_dump ($cdb->getAllDocs());
if ($callOK) {
    $findCommand = array (
        'selector' => array(
            'theme' => $_POST['theme']
        ),
        'fields' => array( '_id' ),
        'use_index' => 'primaryIndex'
    );
    if (array_key_exists('specificityName',$_POST) && !is_null($_POST['specificityName'])) $findCommand['selector']['specificityName'] = $_POST['specificityName'];
    if (array_key_exists('view',$_POST) && !is_null($_POST['view'])) $findCommand['selector']['view'] = $_POST['view'];
    if (array_key_exists('url',$_POST) && !is_null($_POST['url'])) $findCommand['selector']['url'] = $_POST['url'];
    if (array_key_exists('role',$_POST) && !is_null($_POST['role'])) $findCommand['selector']['role'] = $_POST['role'];
    if (array_key_exists('user',$_POST) && !is_null($_POST['user'])) $findCommand['selector']['user'] = $_POST['user'];
    $findCommand['selector']['ip'] = $naIP;
    $findCommand['selector']['ua'] = $_SERVER['HTTP_USER_AGENT'];
    
    try { 
        $call = $cdb->find ($findCommand);
    } catch (Exception $e) {
        echo 'Error while accessing $dbName='.$dbName.'<br/><pre>'.PHP_EOL;
        echo $e->getMessage().PHP_EOL;
        echo 'status : Failed';
        exit();
    };
    if ($debug) {
        echo 'info : $findCommand='; var_dump ($findCommand); echo '.<br/>'.PHP_EOL;
        echo 'info : $call='; var_dump ($call); echo '.<br/>'.PHP_EOL;
        //exit();
    }
    
    $hasRecord = false;
    $rets = [];
    if ($call->headers->_HTTP->status==='200') {
        foreach ($call->body->docs as $idx => $d) {
            $hasRecord = true;
            $call2 = $cdb->get($d->_id);
            $rets = array_merge ($rets, [
                $call2->body->theme => json_decode(json_encode($call2->body),true)
            ]);

            //echo json_encode($call2->body, JSON_PRETTY_PRINT);//.'<br/>'.PHP_EOL;
            //exit();
        }
        if (count($rets)>0) {
            echo json_encode($rets);
            exit();
        }
    }

    if (!$hasRecord) {
        $rec = array (
            '_id' => cdb_randomString(20),
            'theme' => $_POST['theme'],
            'ip' => $naIP,
            'ua' => $_SERVER['HTTP_USER_AGENT'],
            'url' => $_POST['url'],
            'dialogs' => json_decode($_POST['dialogs'], true)
        );
        if (array_key_exists('specificityName',$_POST) && !is_null($_POST['specificityName'])) $rec['specificityName'] = $_POST['specificityName'];
        if (array_key_exists('view',$_POST) && !is_null($_POST['view'])) $rec['view'] = $_POST['view'];
        if (array_key_exists('url',$_POST) && !is_null($_POST['url'])) $rec['url'] = $_POST['url'];
        if (array_key_exists('role',$_POST) && !is_null($_POST['role'])) $rec['role'] = $_POST['role'];
        if (array_key_exists('user',$_POST) && !is_null($_POST['user'])) $rec['user'] = $_POST['user'];
        $fail = false;
        try {
            $call2 = $cdb->post($rec);
        } catch (Exception $e) {
            if ($debug) {
                echo 'status : Failed : could not add record to database ('.$dbName.').<br/>'.PHP_EOL;
                echo '$rec = <pre style="color:blue">'.PHP_EOL; var_dump ($rec); echo PHP_EOL.'</pre>'.PHP_EOL;
                echo '$call2 = <pre style="color:red">'.PHP_EOL; var_dump ($call2); echo PHP_EOL.'</pre>'.PHP_EOL;
                echo '$e = <pre style="color:red">'.PHP_EOL; var_dump ($e); echo PHP_EOL.'</pre>'.PHP_EOL; 
                exit();
            }
            $failed = true;
            echo 'status : Failed';
        }
        if (!$fail) echo json_encode($rec, JSON_PRETTY_PRINT);
    }

    if ($debug) {
        echo 'ERROR : Failed to get database access.<br/>'.PHP_EOL;
        echo 'info : $call='; var_dump ($call); echo '.<br/>'.PHP_EOL;
    } 
    //echo 'status : Failed.';
}
?>
