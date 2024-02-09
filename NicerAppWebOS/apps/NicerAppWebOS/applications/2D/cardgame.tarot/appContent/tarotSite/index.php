<?php
error_reporting (E_ALL);
require_once (dirname(__FILE__).'/functions.php');
require_once (realpath(dirname(__FILE__).'/../../../../../../../..').'/NicerAppWebOS/boot.php');

	/*
	global $saSiteHTTP; global $saSiteDomain; global $saSiteRootFolder; global $saFrameworkFolder;
	global $saSiteHD; global $saFrameworkHD; global $saSiteURL; global $saFrameworkURL;
	global $saIsLocalhost; global $saHTDOCShd;
	global $saServerOperatingSystem; global $saDeveloperMode;
	
	global $saUpstreamRootURL; global $locationbarInfo;
	global $saUIdefaults;
	//$viewParams = getLocationbarInfo($_SERVER['QUERY_STRING']);
	*/

	global $naWebOS;
	$view = $naWebOS->view;
	//echo '<pre>'; var_dump ($view); exit();
	foreach ($view as $viewPath => $viewRec) {
		$_GET['deck'] = $viewRec['deck'];
		$_GET['reading'] = $viewRec['reading'];
	}
	
	/*
	$url = $_SERVER['REQUEST_URI'];
	//var_dump ($url); 
	$deckp1 = strpos($url, 'deck\'');
	$deckp2 = strpos($url, '\'', $deckp1+strlen('deck\''));
	$deck = substr($url, $deckp1+strlen('deck\''), $deckp2-$deckp1-strlen('deck\''));
	$readingp1 = strpos($url, ',reading\'');
	$readingp2 = strpos($url, '\'', $readingp1+strlen(',reading\''));
	$readingName = substr($url, $readingp1+strlen(',reading\''), $readingp2-$readingp1-strlen(',reading\''));
	//var_dump ($readingName); exit();
	$_GET['deck'] = $deck;
	$_GET['reading'] = $readingName;
	*/
	//var_dump ($_GET); exit();
	$explanationID = 'tarot';
	
	//var_dump ($viewParams);
	$readingType = t2_get_readingType();
	//var_dump ($readingType); exit();
	$reading = t2_draw_cards($readingType, $explanationID);
	//echo '<pre>';var_dump ($reading); exit();
	$reading = t2_calculate_size_for_cards ($reading); 
	//var_dump ($reading); exit();
	$numberOfDecks = t2_getNumberOfDecks();
	$numberOfReadings = t2_getNumberOfReadings();
	

//	<!--<meta name="keywords" content="tarot, free, free tarot, free tarot reading, psychic, play, anation, consult, future, prediction, tarot consult, tarot reading, tarot game, tarot deck, tarot decks, tarot set, game, cards, card game, angel card">-->

?>
	<link type="text/css" rel="StyleSheet" media="screen" href="/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/cardgame.tarot/appContent/tarotSite/index.css?changed=<?php echo date('Ymd-His', filemtime(dirname(__FILE__).'/index.css'));?>">
	<script type="text/javascript">
//		jQuery(document).ready(function() {
			//debugger;
            //na.analytics.logMetaEvent ('tarot : init-stage-0');

			delete na.apps.loaded['app.2D.cardgame.tarot'];
			na.m.waitForCondition (
				'na.apps.loaded["/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/cardgame.tarot"]',
				function () {
                    ///debugger;
					return (
						typeof na === 'object'
						&& typeof na.apps === 'object'
						&& typeof na.apps.loaded === 'object'
						&& typeof na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/cardgame.tarot'] === 'object'
					);
				},
				function () {
                    //debugger;
                    na.analytics.logMetaEvent ('tarot : init-stage-1');
					na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/cardgame.tarot'].globals.rootURL = 'http://nicer.app/';
					na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/cardgame.tarot'].globals.request_uri = "<?php echo $_SERVER['REQUEST_URI']?>";
					na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/cardgame.tarot'].globals.url = "<?php echo str_replace('content/app.2D.cardgame.tarot/','', $_SERVER['REQUEST_URI'])?>";
					na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/cardgame.tarot'].settings.reading = <?php echo json_encode($reading); ?>;
					//na.apps.loaded['app.2D.cardgame.tarot'].settings.ready = true;
					na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/cardgame.tarot'].settings.loadedIn['#siteContent'].settings.ready = true;
					na.site.settings.current.startingApps = false;
				},
				100
			);
		//});
	</script>
	<script type="text/javascript" src="/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/cardgame.tarot/appContent/tarotSite/app.2D.cardgame.tarot_siteContent.source.js?changed=<?php echo date('Ymd-His', filemtime(dirname(__FILE__).'/app.2D.cardgame.tarot_siteContent.source.js'));?>"></script>

	<div id="saZoomCard" style="display:none;z-index:10000000;text-align:center;"></div>
	
	<div id="app_mainmenu" class="vividMenu vividTheme__menu_006 saAppMenu saAppMenu_defaultDiv__siteContent" style="position:absolute; visibility:hidden; left:-420px; top:10px; width:400px; height:37px; z-index:990000">
		<ul style="display:none">
            <li><a class="menu__dontKeepSelected" href="#">Tarot</a>
                <ul>
                    <li><a class="menu__dontKeepSelected" href="#">Card Decks</a>
                        <ul>
                        <?php echo t2_html_menu_decks(); ?>
                        </ul>
                    </li>
                    <li><a class="menu__dontKeepSelected" href="#">Readings</a>
                        <ul>
                            <?php echo t2_html_menu_readings(); ?>
                        </ul>
                    </li>
                    <li><a href="#">Misc</a>
                        <ul>
                            <li><a href="javascript:na.apps.loaded['app.2D.cardgame.tarot'].setOptions('majors',true);">Major cards only</a></li>
                            <li><a href="javascript:na.apps.loaded['app.2D.cardgame.tarot'].setOptions('majors',false);">All cards</a></li>
                            <li><a href="javascript:na.apps.loaded['app.2D.cardgame.tarot'].getNewReading();">New Reading</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
		</ul>
	</div>
	
	<div id="appGame" style="display:none;width:100%;height:100%;overflow:hidden;">
		<?php //getBadDecks(); ?>
		<div id="card" style="position:relative;float:right;display:none;"></div>
		<div id="cards" style="position:relative;float:right;display:none;overflow:hidden;height:<?php echo $reading['theme']['size']['y']?>px;width:<?php echo $reading['theme']['size']['x']?>px;">
			<?php echo t2_html_draw_cards($reading); ?>
		</div>
		<div id="intro" class="text" style="display:none;">
			<h1 class="nicerEnterprises_tarot_cardExplanation" id="pageTitle" style="text-shadow:2px 2px 1px rgba(0,0,0,0.7)">Free Tarot Reading (191 decks, 9 reading types)</h1>
			<script type="text/javascript">
			/*
                setTimeout(function() {
                    var vividTextCmd = {
                        el : jQuery('#pageTitle')[0],
                        theme : na.cg.themes.naColorgradientSchemeMagicalBlue, 
                        animationType : na.vividText.globals.animationTypes[0],
                        animationSpeed : 10 * 1000
                    };
                    na.vividText.initElement (vividTextCmd);	   
                }, 1000);
			*/
			</script>

			
			<p>
			Here you can select any of <?php echo $numberOfDecks;?> tarot decks  and <?php echo $numberOfReadings?> types of readings, to play a game of tarot with for free.<br/>
			Use the menu at the top of this web game to select a different deck or reading type.
			</p>
			
			<p>
			If a card is upside down, that is the common notation for the opposite meaning of the card, also known as the "negative" or "reversed" meaning of the card.
			</p>
			
			<p>The card decks for this game app, i found on a torrent site one day (a lucky day for me), and of course, as with any "stolen" copyrighted material, i will list the DMCA complaint filing address as part of my compliance with copyright laws that govern my country, right here and now :<br/>
			<a href="mailto:rene.veerman.netherlands@gmail.com">E-mail rene.veerman.netherlands@gmail.com</a>
			</p>
		</div>
		<div id="deckExplanation" class="text" style="display:none;">
			<?php echo t2_html_deck_info()?>
		</div>
		<div id="cardSpotInReadingTitle" class="text" style="display:none;"></div>
		<div id="cardSpotExplanation" class="text" style="display:none;">
		</div>
		<div id="cardExplanation" class="text" style="display:none;">
			<?php 
			foreach ($reading['cards'] as $idx => $card) {
				//echo '<p>'.$card['readingSpotExplanation'].'</p>'."\n\r";
				echo $card['explanation'];
			}
			?>
		</div>
		<div id="readingExplanation" class="text" style="display:none;">
			<?php echo $reading['heading']; ?>
		</div>
	</div>
</body>
</html>
