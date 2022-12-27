<?php 
$root = realpath (dirname(__FILE__).'/../../../../../..');
require_once ($root.'/NicerAppWebOS/boot.php');
global $naWebOS;
$view = $naWebOS->view;


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

/*
$couchdbConfigFilepath = realpath(dirname(__FILE__).'/../../../').'/domainConfigs/'.$naWebOS->domain.'/couchdb.json';
//var_dump ($couchdbConfigFilepath); exit();
$cdbConfig = json_decode(file_get_contents($couchdbConfigFilepath), true);

$cdb = new Sag($cdbConfig['domain'], $cdbConfig['port']);
$cdb->setHTTPAdapter($cdbConfig['httpAdapter']);
$cdb->useSSL($cdbConfig['useSSL']);
$cdb->login($cdbConfig['adminUsername'], $cdbConfig['adminPassword']);

$cdb->setDatabase(str_replace('_tree', '_documents', $view['cmsText']['database']),false);
try { $call = $cdb->get ($view['cmsText']['id']); } catch (Exception $e) { echo $e->getMessage(); exit(); };

echo $call->body->document;
*/

$baseURL = '/NicerAppWebOS/siteData/'.$naWebOS->domain.'/';
$baseDir = $root.'/NicerAppWebOS/siteData/'.$naWebOS->domain.'/';
$targetDir = $baseDir.$view['cmsViewMedia']['basePath'].'/';
$targetURL = $baseURL.$view['cmsViewMedia']['basePath'].'/';
$fn = $view['cmsViewMedia']['filename'];

$dbg = array (
    'baseURL' => $baseURL,
    'baseDir' => $baseDir,
    'targetDir' => $targetDir,
    'targetURL' => $targetURL,
    'fn' => $fn
);
//echo '<pre>'.json_encode($dbg,JSON_PRETTY_PRINT).'</pre>';

$files = getFilePathList ($targetDir, false, FILE_FORMATS_photos, null, array('file'));

foreach ($files as $idx => $file) {
    $prev = '';
    $next = '';
    if (basename($file)===$fn) {
        $prev = $idx > 1 ? $files[$idx-1] : $files[count($files)-1];
        $next = $idx < count($files) - 1 ? $files[$idx+1] : $files[0];
    }
    $dbg = [
        'prev' => $prev,
        'next' => $next
    ];
    //echo '<pre>'; var_dump ($dbg); echo '</pre>';
    $prevArr = array (
        "misc" => [ "folder" => "/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS" ],
        'cmsViewMedia' => array (
            'basePath' => $view['cmsViewMedia']['basePath'],
            'filename' => (is_string($prev) && $prev!=='' ? basename($prev) : '')
        )
    );
    $prevJSON = base64_encode_url (json_encode($prevArr));
    $nextArr = array (
        "misc" => [ "folder" => "/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS" ],
        'cmsViewMedia' => array (
            'basePath' => $view['cmsViewMedia']['basePath'],
            'filename' => (is_string($next) && $next!=='' ? basename($next) : '' )
        )
    );
    $nextJSON = base64_encode_url (json_encode($nextArr));
}

//echo '<pre>'.json_encode($files,JSON_PRETTY_PRINT).'</pre>';
?>
<script type="text/javascript" src="/NicerAppWebOS/logic.userInterface/photoAlbum/4.0.0/photoAlbum-4.0.0.source.js?c=<?php echo date('Ymd_His',filemtime($naWebOS->basePath.'/NicerAppWebOS/logic.userInterface/photoAlbum/4.0.0/photoAlbum-4.0.0.source.js'));?>"></script>
<span class="helper"></span>
    <img id="viewMedia" src="<?php echo $targetURL.$fn;?>"/>
<img id="btnSetBackground" class="tooltip" tooltipTheme="mainTooltipTheme" title="Set as site background" src="/NicerAppWebOS/siteMedia/btnBackground.png" onclick="na.backgrounds.next ('#siteBackground', na.site.globals.backgroundSearchKey, '<?php echo $targetURL.$fn;?>');"/>
<img id="btnBack_fromMediaView" class="tooltip" tooltipTheme="mainTooltipTheme" title="Set as site background" src="/NicerAppWebOS/siteMedia/btnBack.png" onclick="window.history.back();"/>
<img id="btnPrevious" src="/NicerAppWebOS/siteMedia/btnPrevious.png" onclick="na.site.loadContent(event,'<?php echo $prevJSON?>');"/>
<img id="btnNext" src="/NicerAppWebOS/siteMedia/btnNext.png" onclick="na.site.loadContent(event,'<?php echo $nextJSON?>');"/>
<div id="naPhotoAlbum__control" style="position:absolute;top:5%;width:200px;height:100px;right:1%;z-index:3200;">
    <div class="naPhotoAlbum_control__background" style="position:absolute;width:100%;height:100%;">&nbsp;</div>
	<div id="naPhotoAlbum__control__naturalWidth" class="naPhotoAlbum_control_element" style="position:absolute;top:1em;"></div>
    <div id="naPhotoAlbum__control__naturalHeight" class="naPhotoAlbum_control_element" style="position:absolute;top:2em;"></div>
	<div id="naPhotoAlbum__control__width" class="naPhotoAlbum_control_element" style="position:absolute;top:3em;"></div>
    <div id="naPhotoAlbum__control__height" class="naPhotoAlbum_control_element" style="position:absolute;top:4em;"></div>
	<div id="naPhotoAlbum__control__zoomPercentage" class="naPhotoAlbum_control_element" style="position:absolute;top:0em;"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    na.m.waitForCondition ('image load',
        function () {
            var
            nw = $('#viewMedia')[0].naturalWidth;
            //debugger;
            return nw > 0 && na.m.desktopIdle();
        },
        function () {
            na.photoAlbum.onload();
        },
        100
    );
    });
</script>
