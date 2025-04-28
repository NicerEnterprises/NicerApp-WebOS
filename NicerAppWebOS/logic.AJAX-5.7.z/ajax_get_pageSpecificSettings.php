<?php 
$rootPathNA = realpath(dirname(__FILE__).'/../..').'/NicerAppWebOS';
require_once ($rootPathNA.'/boot.php');
//echo '<!--'; var_dump ($_GET); echo '-->';
    global $naWebOS;
    $r = $naWebOS->getPageCSS(true, true, $_GET['includeClientOnlyThemes']==='true'?true:false, $_GET['stickToCurrentSpecificity']==='false'?false:true, $_GET['specificityName']);
    if ($r && $r!=='')
        $r = $naWebOS->getPageCSS(
            true, true,
            $_GET['includeClientOnlyThemes']==='true'?true:false, $_GET['stickToCurrentSpecificity']==='true'?true:false
        );
    echo $r;
?>
