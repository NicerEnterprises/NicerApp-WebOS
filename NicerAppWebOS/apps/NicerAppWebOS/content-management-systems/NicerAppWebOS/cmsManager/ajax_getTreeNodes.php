<?php 
require_once (realpath(dirname(__FILE__).'/../../../../..').'/boot.php');
$debug = false;

global $naWebOS;
$cdb = $naWebOS->dbs->findConnection('couchdb')->cdb;
$username = array_key_exists('cdb_loginName',$_SESSION) ? $_SESSION['cdb_loginName'] : $cdbConfig['username'];
//echo '<pre>t342:';var_dump ($_SESSION);echo '</pre>';die();
$username = preg_replace ('/.*___/', '', $username);
$username = str_replace(' ', '__', $username);
$username = str_replace('.', '_', $username);

$cdb_domain = $naWebOS->domainForDB;
$tables = array (
    $cdb_domain.'___cms_tree',
    $cdb_domain.'___cms_tree___role___guests',
    $cdb_domain.'___cms_tree___user___'.strtolower($username)
    //$naWebOS->domain.'___cms_tree__user__administrator',
    //$naWebOS->domain.'___cms_tree__user__guest'
);

$data = array();
$ret = array();
foreach ($tables as $idx=>$dbName) {
    $msg = 'ajax_getTreeNodes.php : $dbName='.$dbName;
    //trigger_error ($msg, E_USER_NOTICE);
    //echo $msg.'<br/>';
    $r = $cdb->setDatabase ($dbName, false);
    //var_dump ($r);
        //catch (Throwable $e) { echo '$dbName='.$dbName.'</br>'.PHP_EOL; echo $e->getMessage(); }
        //catch (Exception $e) { echo '$dbName='.$dbName.'</br>'.PHP_EOL; echo $e->getMessage(); };

    //echo '$dbName='.$dbName.'</br>'.PHP_EOL;

    //try { $docs = $cdb->getAllDocs(true); } catch (Exception $e) { echo $e->getMessage(); };
    //$data = $docs->body->rows;

    try {
        $findCommand = [
            'selector' => [
                '$or' => [
                    [ 'database' => $dbName ],
                    [ 'database' => str_replace('_tree_','_documents_',$dbName) ]
                ]
            ]/* TODO : FIX INTRUSION INTO COUCHDB?..,
            'sort' => [
                ['parent' => 'asc'],
                ['order' => 'asc']
            ],
            'use_index' => '_design/c1b49fc16a4b40c3e3cb2a894bd5aef317a3253f'
            */
        ];
        $call2 = $cdb->find($findCommand);
        if ($debug) { echo 't333:'; var_dump ($call2); };
        $data = $call2->body->docs;
    } catch (Exception $e) { echo $e->getMessage(); }

    //var_dump ($data);
    foreach ($data as $idx2=>$recordSummary) {
        $ret = array_merge ($ret, array(json_decode(json_encode($recordSummary),true)));
    }
}

echo json_encode($ret, JSON_PRETTY_PRINT);
?>
