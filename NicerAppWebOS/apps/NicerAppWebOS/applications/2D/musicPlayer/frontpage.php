<?php
    /*
    $views = array(
        'music_index__DJ_Firesnake' => array (
            '/NicerAppWebOS/apps/nicer.app/applications/2D/musicPlayer' => array (
                'set' => 'DJ_FireSnake',
                'SEO_value' => 'music-2015-DJ_FireSnake'
            )
        ),
        'music_index__Deep_House' => array (
            '/NicerAppWebOS/apps/nicer.app/applications/2D/musicPlayer' => array (
                'set' => 'Deep_House',
                'SEO_value' => 'music-2021-Deep_House'
            )
        ),
        'music_index__Beautiful_Chill_Mixes' => array (
            '/NicerAppWebOS/apps/nicer.app/applications/2D/musicPlayer' => array (
                'set' => 'Beautiful_Chill_Mixes',
                'SEO_value' => 'music-Beautiful_Chill_Mixes'
            )
        ),
        'music_index__Black_Horse__Mongolian_Traditional_Classical_Music_Art' => array (
            '/NicerAppWebOS/apps/nicer.app/applications/2D/musicPlayer' => array (
                'set' => 'Black_Horse__Mongolian_Traditional_Classical_Music_Art',
                'SEO_value' => 'music-Black_Horse-Mongolian-Traditional-Classical-Music-Art'
            )
        )
    );
    $json = array();
    $urls = array();
    foreach ($views as $viewName => $viewSettings) {
        $json[$viewName] = json_encode($viewSettings);
        $urls[$viewName] = '/apps/'.base64_encode_url($json[$viewName]);
    };
    */
    $rootPath_vkdmd = realpath(dirname(__FILE__).'/../../../../../..');
    require_once ($rootPath_vkdmd.'/NicerAppWebOS/boot.php');
    require_once ($rootPath_vkdmd.'/NicerAppWebOS/domainConfigs/'.$naWebOS->domain.'/mainmenu.items.php');
    global $naURLs;
    //var_dump ($naURLs);
?>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Krona+One&display=swap" rel="stylesheet"> 
</head>
<body>
    <style>
        p {
            color : white;
        }
        
        p a {
            color : white;
            font-size : 180%;
            font-weight : bold;
        }
        
        p a:hover {
            color : cyan;
            font-size : 180%;
            font-weight : bold;
        }
        
        p a:visited {
            color : #CCC;
            font-size : 180%;
            font-weight : bold;
        }
    </style>
    <center>
    <h1 id="pageTitle" style="font-size:145.67%;">nicer.app music collections</h1><br/>
    <br/>
    <p>
    <a href="<?php echo $naURLs['music_index__Sabaton']?>">Sabaton - 2022 recent hits</a><br/>hosted here both as a tribute to enormously good rock music, falling, wounded and surviving soldiers and commanders, <b>and</b> as a protest against war (because of all the innocent victims that such events create).<br/>
    <br/>
    <a href="<?php echo $naURLs['music_index__DJ_Firesnake']?>">DJ FireSnake</a><br/>aka Rene AJM Veerman's DJ career spanning around 2003-2012. Please pardon the DMCA violations, i claim no copyright or rights to this music at all, but found it worthy to be mixed into mp3s for humanity's legacy.<br/>
    <br/>
    <a href="<?php echo $naURLs['music_index__Deep_House']?>">Deep House</a><br/>a collection of very good 'Deep House' mixes originally downloaded from youtube using a legal-to-use but very covert app. Please pardon the DMCA violations, these are free mixes to begin with and i merely wanted to include them in a music player that's as cool as mine is.<br/>
    <br/>
    <a href="<?php echo $naURLs['music_index__Black_Horse__Mongolian_Traditional_Classical_Music_Art']?>">Black Horse - Mongolian Traditional Classical Music Art</a><br/>(Tribute to the street art band 'Black Horse' and the movie Dune 2021, in which i support the good guys of course and wish them well in the sequels!)<br/>
    <a href="<?php echo $naURLs['music_index__Beautiful_Chill_Mixes']?>">Beautiful Chill Mixes</a><br/>a collection of very good western classical piano and other musical instrument mixes originally downloaded from youtube using a legal-to-use but very covert app. Please pardon the DMCA violations, these are free mixes to begin with and i merely wanted to include them in a music player that's as cool as mine is.<br/>
    <br/>
    </p>
    </center>
</body>
</html>
