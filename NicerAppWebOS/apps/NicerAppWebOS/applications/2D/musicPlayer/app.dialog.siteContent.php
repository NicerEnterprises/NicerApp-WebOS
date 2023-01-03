<?php
//define ('SA_SHOW_CONSTANTS', true); //un-comment this to only show the define()s that my nicerapp framework exposes
//require_once ('nicerapp-2012/boot.php');
//require_once ('nicerapp-2012/com/userInterface/comments/saComments-1.0.0.php');

//echo realpath(dirname(__FILE__).'/../../../../../..').'/NicerAppWebOS/boot.php';die();
require_once (realpath(dirname(__FILE__).'/../../../../../..').'/NicerAppWebOS/boot.php');
global $naWebOS;
//var_dump ($naWebOS->view); //exit();
$view = $naWebOS->view["/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer"];
//var_dump ($view); //exit();


if ($view['set']==='index') {
    require_once(dirname(__FILE__).'/frontpage.php');
} else {
    $setPath = dirname(__FILE__).'/music/'.$view['set'];

    /*
    if (file_exists($setPath.'/regex_filenameFilter.js-regexps.json')) {
        $res = json_decode(file_get_contents($setPath.'/regex_filenameFilter.js-regexps.json'),true);
        //var_dump(file_get_contents($setPath.'/regex_filenameFilter.js-regexps.json'));        var_dump($res);die();
    } else {
        $res = [];
    }
    */
    //var_dump ($setPath); //exit();
    //var_dump (FILE_FORMATS_mp3s); exit();
    $files = getFilePathList ($setPath.'/', true, FILE_FORMATS_mp3s, null, array('file'));
    //var_dump ($files); exit();
    foreach ($files as $idx => $filepath) {
        $files[$idx] = str_replace(realpath(dirname(__FILE__.'/../..')), '', $files[$idx]);
        $files[$idx] = str_replace('\\\\', '/', $files[$idx]);
        $files[$idx] = str_replace('\\', '/', $files[$idx]);
        /*
        for ($i=0; $i < count($res); $i++) {
            //for ($j=0; $j < count($res[$i]); $j++) {
                $it = $res[$i];//[$j];
                $itRegExps = $it[0];
                $itReplaceString = $it[1];
                for ($k=0; $k < count($itRegExps); $k++) {
                    $files[$idx] = preg_replace($itRegExps[$k], $itReplaceString, $files[$idx]);
                }
            //}
        }
        */
    }
    //var_dump ($files); exit();

$authorEmail = 'rene.veerman.netherlands@gmail.com';
$spacer = "\n\t\t\t\t";
//$htmlIntro = file_get_contents ($setPath.'/index.html');
//$htmlTitleMeta = file_get_contents ($setPath.'/index.title_meta.html');

	global $saFrameworkFolder;
?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en">
	<meta http-equiv="content-language" content="english">
	<link type="text/css" rel="StyleSheet" media="screen" href="/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer/index.css?changed=<?php echo date('Ymd-His', filectime(dirname(__FILE__).'/index.css'));?>"/>
	<link type="text/css" rel="StyleSheet" media="screen" href="/NicerAppWebOS/3rd-party/jQuery/jPlayer-2.9.1/jplayer.vivid.css"/>

	<script type="text/javascript">
        
        //na.desktop.registerCallback ('na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer']', function () {
            na.m.waitForCondition ('DOM ready', function() {
                return na && na.apps && typeof na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'] =='object' && $.ui && $.ui.draggable && $('#mp3s')[0] && $('#player')[0];
            }, function() {

                jQuery('#horizontalMover').draggable ({
                    containment : '#horizontalMover__containmentBox1',
                    axis : 'x',
                    drag : function () {
                        na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.masterLeftOffset = jQuery('#horizontalMover')[0].offsetLeft;
                        na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].onWindowResize();
                    }
                });
                $('#titlebar .vividDialogContent').fadeIn('fast');
                na.desktop.globals.divs.push ('#titlebar');
                na.desktop.globals.divs.push ('#mp3s');
                na.desktop.globals.divs.push ('#player');
                na.desktop.globals.divs.push ('#playlist_wrapper');
                na.desktop.globals.divs.push ('#infoWindow_mp3desc');
                na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.loadedIn['#siteContent'].onload( {} );
                na.desktop.resize();
            }, 100);
        //});
	</script>
	
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="/NicerAppWebOS/3rd-party/jQuery/jquery-ui-1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer/app.2D.musicPlayer_siteContent.source.js?changed=<?php echo date('Ymd-His', filemtime(dirname(__FILE__).'/app.2D.musicPlayer_siteContent.source.js'));?>"></script>

	<div id="horizontalMover__containmentBox2" style="display:none;position:absolute;height:20px;border-radius:8px;background:black;opacity:0.2"></div>
	<div id="horizontalMover__containmentBox1" style="display:none;position:absolute;height:16px;top:2px;border-radius:4px;background:black;opacity:0.0"></div>
	<div id="horizontalMover" class="draggable ui-widget-content" style="display:none;position:absolute;top:4px;height:10px;width:730px;border-radius:4px;background:navy;border : 1px solid white;opacity:0.7"></div>
	
	<div id="titlebar" class="vividDialog" style="opacity:0.0001;position:absolute;display:flex;background:rgba(0,0,0,0.4);border:1px solid white;border-radius:15px;font-weight:bold;justify-content:center;vertical-align:middle;align-content: center;align-items : center;padding:5px;margin-bottom:10px;">
        <div class="vividDialogContent" style="text-align:center;margin:2px;">
        <span id="folderName"><?php echo str_replace('_', ' ', $view['set']) ?></span>&nbsp;
        on&nbsp;<a href="/music">https://nicer.app/music</a>.
        </div>
    </div>

	<div id="mp3s" class="vividMenu vividScrollpane" type="vertical" theme="dark" style="overflow:hidden;overflow-y:auto;opacity:0.001;position:absolute;text-align:center;width:100%;">
<?php

			$filez = array();
            if (file_exists($setPath.'/regex_filenameFilter.js-regexps.json'))
                $ff = safeLoadJSONfile($setPath.'/regex_filenameFilter.js-regexps.json');
            else $ff = [];

			foreach ($files as $idx=>$file) {
				$fn = basename($file);

                $fileLabel = $fn;//$filez[$idx];
                foreach ($ff as $i => $it) {
                    //foreach ($ffIt as $j => $it) {
                        //note: $it === $ff[$i][$j];
                        $itRegExps = $it[0];
                        //echo '<pre>';var_dump ($itRegExps); die();
                        $itReplaceString = $it[1];
                        foreach ($itRegExps as $k => $regExp) {
                            $fileLabel = preg_replace ($regExp, $itReplaceString, $fileLabel);
                        }
                    //}
                }
                $fileLabel = preg_replace('/\.mp3$/','',$fileLabel);
                $filez[$idx] = $fileLabel;
			}
			asort ($filez);
			foreach ($filez as $idx=>$fn) {
				$id = 'mp3_'.$idx;
				echo "\t\t".'<div id="'.$id.'" file="'.basename($files[$idx]).'" class="mp3 vividButton" theme="dark" style="" onclick="na.apps.loaded[\'/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer\'].selectMP3(\''.$id.'\', \''.basename($files[$idx]).'\');">'.$fn.'</div>'."\n";
			}
?> 
	</div>
		
	<div id="player" class="vividDialog" style="overflow:visible;position:absolute;width:320px;height:120px;">
        <audio id="audioTag">
            <?php 
            foreach ($filez as $idx=>$fn) {
                $id = 'mp3Source_'.$idx;
                echo PHP_EOL;
                echo "\t\t\t".'<source id="'.$id.'" src="/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer/music/'.$view['set'].'/'.basename($files[$idx]).'" type="audio/mpeg">'.PHP_EOL;
            }
            ?>
        </audio>
        
		<div class="audioPlayerUI">
            <div class="audioPlayerButtons">
                <div id="btnPlayPause" class="vividButton4" buttonType="btn_audioVideo_playPause" onclick="na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].playpause()"></div>
                <div id="btnMuteUnmute" class="vividButton4" buttonType="btn_audioVideo_muteUnmute" onclick="na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].mute()"></div>
                <div id="btnShuffle" class="vividButton4" buttonType="btn_audioVideo_shuffle" onclick="na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].toggleShuffle()"></div>
                <div id="btnRepeat" class="vividButton4" buttonType="btn_audioVideo_repeat" onclick="na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].toggleRepeat()"></div>
            </div>
            <div class="flexBreak"></div>
            <div class="audioPlayerControls">
                <div class="audioVolumeBar" onclick="na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].setVolume(event);">
                    <div class="audioVolumeBar_setting" style="width:calc(100% - 4px);"></div>
                </div>
                <div class="audioSeekBar" onclick="na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].seek(event);">
                    <div class="audioSeekBar_setting" style="width:0px;"></div>
                </div>
            </div>
            <div class="audioPlayerControlsLabels">
                <div class="audioVolumeBarLabel" style="text-align:center">Volume : 100</div>
                <div class="audioSeekBarLabel">
                    <div class="audioSeekBarLabel_currentTime">0:00</div>
                    <div class="audioSeekBarLabel_length">1:15:00</div>
                </div>
            </div>
		</div>
	</div>

	<div id="playlist_wrapper" class="vividDialog vividScrollpane" theme="dark" style="text-align:center;opacity:0.001;overflow-y:auto;overflow-x:hidden;position:absolute; width:300px;height:300px;">
        <h2 style="padding:0px !important; display:flex;justify-content:center;align-items:center;height:50px;font-size:10px;background:rgba(0,0,255,0.25);color:white;border-radius:10px;box-shadow:2px 2px 3px 2px rgba(0,0,0,0.7);">Playlist<br/>(drag and drop items onto this window)</h2>
		<ul id="playlist" style="width:100%;height:100%;"></ul>
	</div>
	
	<div id="infoWindow_mp3desc" class="vividDialog" theme="dark" style="opacity:0.001;overflow:visible;position:absolute;width:320px;height:300px;">
        <div class="vividDialogContent">
            <div id="mp3descText"></div>
            <div id="siteIntroText">
                
                <?php //echo $htmlIntro?>
            </div>
		</div>
	</div>
<?php
}
?>
