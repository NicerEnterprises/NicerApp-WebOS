<?php
$rootPath = realpath(dirname(__FILE__).'/../../../../../..');
require_once ($rootPath.'/NicerAppWebOS/boot.php');
$debug = false;

global $naWebOS;
$cdb = $naWebOS->dbs->findConnection('couchdb')->cdb;

$cdb->setDatabase($_POST['database'],false);
$call = $cdb->get ($_POST['id']);
$oldFoldername = $call->body->text;
$call->body->text = $_POST['node_title_new']; // newFolderName = tadaa

//echo '<pre>'; var_dump ($call->body); var_dump ($oldFoldername); echo '</pre>';

try { $call = $cdb->post($call->body); } catch (Exception $e) {
    cdb_error (500, $e, 'Could not add record'); exit();
}
if ($debug) { echo '$call='; var_dump ($call); echo PHP_EOL.PHP_EOL; }


$oldPath = $rootPath.'/NicerAppWebOS/siteData/'.$naWebOS->domain.'/'.$_POST['oldPath'];
$newPath = $rootPath.'/NicerAppWebOS/siteData/'.$naWebOS->domain.'/'.$_POST['newPath'];
$xec = 'mv "'.$oldPath.'" "'.$newPath.'"';
exec ($xec, $output, $result);
$dbg = array (
    'xec' => $xec,
    'output' => $output,
    'result' => $result
);
if ($debug) { echo '<pre style="color:green">'; var_dump ($dbg); echo '</pre>'; }



echo 'status : Success'; 
?>
