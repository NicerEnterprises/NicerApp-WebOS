<?php
    $naRoot = realpath(dirname(__FILE__).'/../../../../../..');
    require_once($naRoot.'/NicerAppWebOS/boot.php');
    global $naWebOS;
    $debug = false;
    global $debug;

    $fp = $naRoot.'/NicerAppWebOS/siteCache/app.3D.fileBrowser.json';
    if (file_exists($fp)) echo file_get_contents($fp);
    else {
        $mi = [];

        $root = $naRoot.'/NicerAppWebOS/siteMedia/backgrounds';
        //var_dump (file_exists($root)); die();
        $fileFormats = '/.*/';
        global $fileFormats;
        $excl = '/.*thumbs.*/';
        global $excl;
        $f = getFilePathList ($root, true, $fileFormats, $excl, array('dir'), null, 1, true);
        //echo '<pre style="color:blue;">'; var_dump ($root); var_dump ($f); echo '</pre>';
        $f = getFileDetails ($f);
        //echo '<pre style="color:red;">'; var_dump ($root); var_dump ($f); echo '</pre>';
        $mi[] = [
            'root' => str_replace($rootPath_na, '', $root),
            'thumbnails' => './thumbs',
            'filesAtRoot' => $f
        ];


        if ($debug) {
            $c = [
                'siteContent' => hmJSON($mi, '$mi')
            ];
            echo $naWebOS->getSite($c);
            echo '<script type="text/javascript">setTimeout (function() {na.site.settings.current.running_loadTheme = false; na.site.settings.current.loadingApps = false; na.hms.startProcessing()}, 1500); na.site.transformLinks()</script>';
        } else {
            $smi = json_encode($mi);
            file_put_contents ($fp, $smi);
            echo $smi;
        }
    }

    function getFileDetails (&$f) {
        $x = walkArray ($f, 'getFileDetails_walkKey', 'getFileDetails_walkValue');
        return $f;
    }

    function getFileDetails_walkKey ($cd) {
        global $excl;
        global $fileFormats;
        global $debug;
        $k = &$cd['k'];
        $v = &$cd['v'];
        //if ($k=='files') {echo '<pre style="color:blue">'; var_dump ($cd); echo '</pre>';}
        if ($k=='files') $v = array_keys ($v);
    }

    function getFileDetails_walkValue ($cd) {
        return $cd;
        /*
        global $excl;
        global $fileFormats;
        global $debug;
        $k = &$cd['k'];
        $v = &$cd['v'];
        //if ($k=='files') { echo '<pre style="color:green">'; var_dump ($cd); echo '</pre>'; }
        if ($k=='files') $v = array_keys ($v);
        return $cd;
        */
    }

?>
