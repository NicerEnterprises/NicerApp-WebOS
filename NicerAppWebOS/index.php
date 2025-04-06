<?php 
    global $useRememberMe;
    $useRememberMe = true;

    require_once(dirname(__FILE__).'/boot.php');
    
    global $naWebOS;
    //echo $naWebOS->getSite();
    
    $debugMe = false;
    if ($debugMe) {
        echo '<pre style="color:green;font-size:2.5rem">'.json_encode($naWebOS->about, JSON_PRETTY_PRINT).'</pre>';
        echo '<pre style="color:blue;font-size:2.5rem">'.$naWebOS->basePath.'</pre>';
        echo '<pre style="color:red;font-size:2.5rem">'.$naWebOS->domain.'</pre>';
        exit();
    }

    $r = $naWebOS->getSite();
    echo $r;
?>
<!--
<h1>Site currently down for maintenance.</h1>
<p>it will take maybe a few days to make some structural changes to the code on nicer.app, new.nicer.app and said.by<p>
-->
