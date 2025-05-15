<?php
$rootPath_na = realpath(dirname(__FILE__).'/../../..');
require_once ($rootPath_na.'/NicerAppWebOS/boot.php');
set_time_limit (60 * 60); // 60 minutes max_execution_time for this script

$cacheFilePath = realpath(dirname(__FILE__).'/../../..').'/NicerAppWebOS/siteCache';

$cacheFile = $cacheFilePath.'/backgrounds.json';
$lockFile = $cacheFilePath.'/backgrounds.LOCK.txt';
global $naLAN;
if ($naLAN) unlink ($cacheFile);//echo '<pre>';

if (!file_exists($cacheFile)) {
    $mi = [];

    $root = realpath(dirname(__FILE__).'/../../..').'/NicerAppWebOS/siteMedia/backgrounds';
    global $naThisServer;
    if (!file_exists($lockFile) && !file_exists($cacheFile) && $naLAN) {
        file_put_contents($lockFile, 'LOCKED');
        $f = getBackgrounds ($root, $rootPath_na, false, $naThisServer['phpServers'][0]['debug']['ajax_backgrounds.php']); // from .../NicerAppWebOS/function.php
    }
    $mi[] = [
        'root' => str_replace($rootPath_na, '', $root),
        'thumbnails' => './thumbs',
        'files' => $f
    ];

    /*
    $root = realpath(dirname(__FILE__).'/../../..').'/NicerAppWebOS/apps/NicerAppWebOS/application-programmer-interfaces/technology/crawlers/imageSearch/output';
    $f = getBackgrounds ($root, $rootPath_na, false); // from .../NicerAppWebOS/function.php
    $mi[] = [
        'root' => str_replace($rootPath_na, '', $root),
        'thumbnails' => './thumbs',
        'files' => $f
    ];*/

    $smi = json_encode($mi);
    file_put_contents ($cacheFile, $smi);
    unlink ($lockFile);
    echo $smi;
} else {
    echo file_get_contents($cacheFile);
}
?>
