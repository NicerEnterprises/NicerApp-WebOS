<?php 

    global $useRememberMe;
    $useRememberMe = true;

    require_once(dirname(__FILE__).'/boot.php');
    
    global $naWebOS;
    //echo $naWebOS->getSite();
    
    //echo '<pre style="color:green;font-size:2.5rem">'.json_encode($naWebOS->about, JSON_PRETTY_PRINT).'</pre>';
    //echo '<pre style="color:blue;font-size:2.5rem">'.$naWebOS->basePath.'</pre>';
    //echo '<pre style="color:red;font-size:2.5rem">'.$naWebOS->domain.'</pre>';

    $r = $naWebOS->getSite();
    echo $r;
    
?>
