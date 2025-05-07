<?php
    $appFolder = '/NicerAppWebOS/apps/nicer.app/applications/2D/musicPlayer';
    $rf = dirname(__FILE__).'/music/';
    $folders = getFilePathList ($rf,true,'*.*',null,['dir']);
    $views = [];
    foreach ($folders as $idx => $folder) {
        $k1 = 'music__index__';
        $k2a = str_replace(' ','_',$folder);
        $k2a1 = str_replace(' ','-',$folder);
        $k3 = $k1.$k2a;
        $views[] = [ $k3 => [ $appFolder => [ 'folder' => $folder, 'set' => $k2a, 'seoValue' => 'music-'.$k2a1 ] ] ] ;
    }
    $json = array();
    $urls = array();
    foreach ($views as $viewName => $viewSettings) {
        $json[$viewName] = json_encode($viewSettings);
        $urls[$viewName] = '/apps/'.base64_encode_url($json[$viewName]);
    };
    $rootPath_vkdmd = realpath(dirname(__FILE__).'/../../../../../..');
    require_once ($rootPath_vkdmd.'/NicerAppWebOS/boot.php');
    require_once ($rootPath_vkdmd.'/NicerAppWebOS/domainConfigs/'.$naWebOS->domainFolder.'/mainmenu.items.php');
    global $naURLs;
    //var_dump ($naURLs);
?>
    <link href="https://fonts.googleapis.com/css?family=Krona+One&display=swap" rel="stylesheet"> 
	<script type="text/javascript">
        delete na.site.settings.current.loadingApps;
	</script>
    <style>
        p {
            color : white;
            background : rgba(0,0,0,0.4);
            border-radius : 14px;
        }

        #pageTitle {
            display : inline-block;
        }

        .container {
            display : flex;
            justify-items : center;
            align-items : start;
            justify-content : center;
            align-content : start;
            width : 100%;
            height : 100%;
        }

        .bg {
            display : inline-block;
            background : rgba(0,0,0,0.4);
            border-radius : 14px;
            height : fit-content;
            text-align : center;
        }
        
    </style>
    <div class="container">
    <div class="bg">
        <h1 id="pageTitle" class="naVividTextCSS" style="font-size:200%;">nicer.app music collections</h1>
        <p style="width:350px">
        <!--<a class="contentSectionTitle3_a naVividTextCSS" href="<?php echo $naURLs['music_index__Beautiful_Chill_Mixes']?>"><span class="contentSectionTitle3_span">Beautiful Chill Mixes</span></a>-->
        <?php
            $di = [
                'views' => 'naWebOS_desktopos_info'
            ];
            $metaInfo = [
                '$appFolder' => $appFolder
            ];
            naWebOS_output_debug_info ($di, $metaInfo);

            foreach ($views as $k1 => $v1) {
                foreach ($v1 as $k2 => $v2) {
                    ?>
                        <a class="contentSectionTitle3_a naVividTextCSS" href="<?php echo $views[$v2['set']]?>"><span class="contentSectionTitle3_span"><?php echo $views[$v2['folder']]?></span></a>
                    <?php
                }
            }
        ?>
        </p>
        <p style="width:350px;">
        Copyright Disclaimer: - Under section 107 of the copyright Act 1976, <a href="https://en.wikipedia.org/wiki/Fair_use" class="contentSectionTitle2_a" target="fairUse">which was reaffirmed in a 2021 court decision</a>, allowance is made for FAIR USE for purpose such a as criticism, comment, news reporting, teaching, scholarship and research. Fair use is a use permitted by copyright statues that might otherwise be infringing. Non- Profit, educational or personal use tips the balance in favor of FAIR USE.
        </p>
    </div>
    </div>
