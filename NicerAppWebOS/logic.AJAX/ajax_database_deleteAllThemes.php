<?php
$rootPathNA = realpath(dirname(__FILE__).'/../..').'/NicerAppWebOS';
require_once ($rootPathNA.'/boot.php');

    global $naWebOS;
    $naWebOS->dbsAdmin->findConnection('couchdb')->createDataSet_data_themes();
?>
status : Success.
