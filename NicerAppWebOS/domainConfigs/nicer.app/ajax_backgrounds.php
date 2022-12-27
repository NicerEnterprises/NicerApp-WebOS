<?php
$rootPath_na = realpath(dirname(__FILE__).'/../../..');
require_once ($rootPath_na.'/NicerAppWebOS/boot.php');

$cacheFilePath = realpath(dirname(__FILE__).'/../../..').'/NicerAppWebOS/siteCache';

$cacheFile = $cacheFilePath.'/backgrounds.json';
//unlink ($cacheFile);//echo '<pre>';

if (!file_exists($cacheFile)) {
    $mi = [];

    $root = realpath(dirname(__FILE__).'/../../..').'/NicerAppWebOS/siteMedia/backgrounds';
    $f = getBackgrounds ($root, $rootPath_na, false); // from .../NicerAppWebOS/function.php
    $mi[] = [
        'root' => str_replace($rootPath_na, '', $root),
        'thumbnails' => './thumbs',
        'files' => $f
    ];

    $root = realpath(dirname(__FILE__).'/../../..').'/NicerAppWebOS/apps/NicerAppWebOS/application-programmer-interfaces/technology/crawlers/imageSearch/output';
    $f = getBackgrounds ($root, $rootPath_na, false); // from .../NicerAppWebOS/function.php
    $mi[] = [
        'root' => str_replace($rootPath_na, '', $root),
        'thumbnails' => './thumbs',
        'files' => $f
    ];

    $smi = json_encode($mi);
    file_put_contents ($cacheFile, $smi);
    echo $smi;
} else {
    echo file_get_contents($cacheFile);
}
?>
