<?php
$rootPathNA = realpath(dirname(__FILE__).'/../..').'/NicerAppWebOS';
require_once ($rootPathNA.'/boot.php');

$debug = true;
if ($debug) {
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
$cdbDomain = $naWebOS->domainForDB;

$cdb = $naWebOS->dbsAdmin->findConnection('couchdb')->cdb;

// create users
$username = $_POST['loginName'];
$username = str_replace(' ', '_', $username);
$username = str_replace('.', '__', $username);

$security_role = '{ "admins": { "names": [], "roles": ["guests"] }, "members": { "names": [], "roles": [] } }';
$security_user = '{ "admins": { "names": ["'.$cdbDomain.'___'.$username.'"], "roles": ["'.$cdbDomain.'___Guests", "'.$cdbDomain.'___Users"] }, "members": { "names": ["'.$cdbDomain.'___'.$username.'"], "roles": ["'.$cdbDomain.'___Guests", "'.$cdbDomain.'___Users"] } }';

$uid = 'org.couchdb.user:'.$cdbDomain.'___'.$username;
$got = true;
$cdb->setDatabase('_users',false);
try { $call = $cdb->get($uid); } catch (Exception $e) { $got = false; }
if (!$got) {
    try {
        $rec = array (
            '_id' => $uid,
            'name' => $cdbDomain.'___'.$username,
            'password' => $_POST['pw'],
            'realname' => $username,
            'email' => $_POST['email'],
            'roles' => [
                $cdbDomain.'___Guests',
                $cdbDomain.'___Users'
            ],
            'type' => "user"
        );
        //echo '<pre style="color:blue;">'; var_dump ($rec); echo '</pre>';
        $call = $cdb->post ($rec);
        if ($call->body->ok) echo 'Created user record.<br/>'; else echo '<span style="color:red">Could not create user record.</span><br/>';
    } catch (Exception $e) {
        echo '<pre style="color:red">Could not create user record : $e->getMessage()='.$e->getMessage().'</pre>';
    }
} else {
    if ($debug) echo 'Already have this user record.<br/>'.PHP_EOL;
}

$dbName = $cdbDomain.'___cms_tree___user___'.strtolower($username);
try { $cdb->deleteDatabase ($dbName); } catch (Exception $e) { };
$cdb->setDatabase($dbName, true);
try {
    $call = $cdb->setSecurity ($security_user);
} catch (Exception $e) {
    if ($debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
}
if ($debug) echo '<pre style="color:green">'; var_dump($call); echo '</pre>'.PHP_EOL;

$rec1_id = cdb_randomString(20);
$do = false; try { $doc = $cdb->get($rec1_id); } catch (Exception $e) { $do = true; };
$data = '{ "database" : "'.$dbName.'", "_id" : "'.$rec1_id.'", "id" : "'.$rec1_id.'", "parent" : "baa", "text" : "'.$_POST['loginName'].'", "state" : { "opened" : true }, "type" : "naUserRootFolder" }';
if ($do) try { $cdb->post($data); } catch (Exception $e) { if ($debug) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; }};

$rec2_id = cdb_randomString(20);
$do = false; try { $doc = $cdb->get($rec2_id); } catch (Exception $e) { $do = true; };
$data = '{ "database" : "'.$dbName.'", "_id" : "'.$rec2_id.'", "id" : "'.$rec2_id.'", "parent" : "'.$rec1_id.'", "text" : "Blog", "state" : { "opened" : true, "selected" : true }, "type" : "naFolder" }';
if ($do) try { $cdb->post($data); } catch (Exception $e) { if ($debug) {echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; }};

$rec3_id = cdb_randomString(20);
$do = false; try { $doc = $cdb->get($rec3_id); } catch (Exception $e) { $do = true; };
$data = '{ "database" : "'.$dbName.'", "_id" : "'.$rec3_id.'", "id" : "'.$rec3_id.'", "parent" : "'.$rec1_id.'", "text" : "Media Albums", "state" : { "opened" : true }, "type" : "naFolder" }';
if ($do) try { $cdb->post($data); } catch (Exception $e) { if ($debug) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; }};


//$dbName = $cdbDomain.'___cms_tree';




echo 'Created database '.$dbName.'<br/>'.PHP_EOL;

$dbName = $cdbDomain.'___cms_documents___user___'.strtolower($username);
try { $cdb->deleteDatabase ($dbName); } catch (Exception $e) { };
$cdb->setDatabase($dbName, true);
try {
    $call = $cdb->setSecurity ($security_user);
} catch (Exception $e) {
    if ($debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
}
echo 'Created database '.$dbName.'<br/>'.PHP_EOL;

//$dbName = $cdbDomain.'___themeData__user___'.strtolower($username);
$dbName = $cdbDomain.'___data_themes';
//try { $cdb->deleteDatabase ($dbName); } catch (Exception $e) { };
$cdb->setDatabase($dbName, true);
try {
    $call = $cdb->setSecurity ($security_role);
} catch (Exception $e) {
    if ($debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
}

$rec = array(
    'url' => '[default]',
    'user' => $username,
    '_id' => cdb_randomString(20),
    'dialogs' => array_merge_recursive(
                            css_to_array (file_get_contents(
                                realpath(dirname(__FILE__).'/../../')
                                .'/NicerAppWebOS/themes/nicerapp_default_siteContent-almost-transparent.css'
                            )),
                            css_to_array (file_get_contents(
                                realpath(dirname(__FILE__).'/../../')
                                .'/NicerAppWebOS/themes/nicerapp_app.2D.musicPlayer.css'
                            ))
            )

);
try {
    $cdb->post($rec);
} catch (Exception $e) {
    if ($debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
}

echo 'Created and populated database '.$dbName.'<br/>'.PHP_EOL;

$dbName = $cdbDomain.'___themes';
try {
    //$call = $cdb->getSecurity();
    $sec = [
        'admins' => [ 'names' => [], 'roles' => [
            $cdbDomain.'___Guests',
            $cdbDomain.'___Users'
        ] ],
        'members' => [ 'names' => [], 'roles' => [] ]
    ];
    $call = $cdb->setSecurity($sec);
    echo '<pre>'; var_dump ($call);
} catch (Exception $e) {
    echo '<pre>'; var_dump ($call);
}

?>
