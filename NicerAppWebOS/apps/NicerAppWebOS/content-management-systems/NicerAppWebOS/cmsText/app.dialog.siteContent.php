<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    

$rootPath = realpath(dirname(__FILE__).'/../../../../../..');
//var_dump ($rootPath); die();

require_once ($rootPath.'/NicerAppWebOS/boot.php');
global $naWebOS;
require_once ($rootPath.'/NicerAppWebOS/logic.userInterface/photoAlbum/4.0.0/functions.php');
$view = $naWebOS->view['/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS/cmsText'];//json_decode (base64_decode_url($_GET['apps']), true);

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


?>
<!--<div class="lds-facebook"><!-- thanks for allowing CC0 license usage : https://loading.io/css/ -- ><div></div><div></div><div></div></div> -->
<!--<pre><?php //echo json_encode($view, JSON_PRETTY_PRINT);?></pre>-->

<?php
global $naWebOS;
$cdb = $naWebOS->dbsAdmin->findConnection('couchdb')->cdb;

$cdb->setDatabase(str_replace('_tree', '_documents', $view['database']),false);
try { $call = $cdb->get ($view['id']); } catch (Exception $e) { echo $e->getMessage(); exit(); };

$doc = $call->body->document;
$p = preg_match_all ('/:{.*}:/', $doc, $matches, PREG_OFFSET_CAPTURE);
//echo '<pre style="color:yellow;background:black;">'; var_dump ($matches); echo '</pre><br/>'; //exit();
foreach ($matches[0] as $idx => $match) {
    $cmd = json_decode (substr($match[0],1,strlen($match[0])-2), true);
    if (array_key_exists('mediaFolder',$cmd)) {
        $doc = str_replace ('<p>'.$match[0].'</p>', naPhotoAlbum($cmd['mediaFolder']), $doc);
    }
}

echo $doc;

?>
