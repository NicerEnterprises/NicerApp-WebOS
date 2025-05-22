<?php
    global $naWebOS;
    global $naURLs;
    //echo $naWebOS->basePath.'/NicerAppWebOS/domainConfigs/'.$naWebOS->domainFolder.'/pageHeader.php'; exit();
    require_once ($naWebOS->basePath.'/NicerAppWebOS/domainConfigs/'.$naWebOS->domainFolder.'/pageHeader.php');
?>
    <script type="text/javascript">
        ///delete na.site.settings.current.app;
        /*setTimeout(function() {
            na.d.s.visibleDivs = arrayRemove (na.d.s.visibleDivs, '#siteToolbarLeft');
            na.d.s.visibleDivs = arrayRemove (na.d.s.visibleDivs, '#siteToolbarRight');
            na.d.s.visibleDivs = arrayRemove (na.d.s.visibleDivs, '#siteToolbarTop');
            na.desktop.resize();
        }, 100);*/
    </script>

    <h1 style="padding:8px;color:070707;text-shadow:2px 2px 3px rgba(0,0,0,0.75),0px 0px 4px rgba(0,0,0,0.85); background:rgba(0,0,0,0.45);border-radius:5px;">NicerApp-WebOS homepage</h1>
    <div style="width:40%;color:black;background:rgba(250, 233, 52,0.35);font-size:120%;margin:10px;font-weight:bold;padding:8px;border-radius:10px;text-shadow:0px 0px 3px rgba(255,0,0,0.7);box-shadow:0px 0px 8px 4px rgba(0,0,0,0.666), 2px 2px 2px rgba(0,0,0,0.7);">
    Take a video or (tiled) background of any resolution, and project information onto that using any weblanguage you want.<br/>
    Written in a style simple enough for children to learn from.<br/>
    This is the <a href="https://github.com/NicerEnterprises/NicerApp-WebOS" class="contentSectionTitle3_a1 nomod noPushState" target="NicerEnterprises---NicerApp-WebOS---on---GitHub-dot-com"><span class="contentSectionTitle3_a1" style="box-shadow:none; padding:0px;margin:0px;">5th major version (5.8.0 to be exact)</span></a> of this software.<br/>
    </div>

    <h2 class="contentSectionTitle1"><span class="contentSectionTitle1_span">Stable Apps offered (but not right now) on the NicerApp-WebOS homepage :</span></h2>
    <?php
        /* REQUIRED ACCORDING TO 2025 LAWS THAT GOVERN HTTPS://nicer.app/music */
        global $naLAN;
        global $naSettings_app2D_musicPlayer_respectDutchCopyright;
        if (!$naSettings_app2D_musicPlayer_respectDutchCopyright || $naLAN) {
    ?>
        <a href="<?php echo $naURLs['music'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">Music</span></h3></a>
        <p style="padding:8px;color:070707;text-shadow:2px 2px 4px 3px rgba(0,0,0,0.75),0px 0px 5px 4px rgba(0,0,0,0.85);background:rgba(0,0,0,0.45);border-radius:5px;">If I don't respect Dutch Copyright Law for a while, or don't indefinitely until a fear generating situation somewhere, -anywhere-, in the world changes for the betterment of all in that region/locality or those regions/localities, then I'll explain myself as best I can right here (and visibly on the website as well, in future (post-2025-05-21) versions of this text.</p>
    <?php } ?>
    
    <h3 id="h3_news" class="contentSectionTitle3 contentSectionTitle3_darker"><span class="contentSectionTitle3_span_darker">News</span></h3>
    <ul class="index" style="margin-block-end:33px;">
        <li><div class="contentSectionTitle3"><a href="<?php echo $naURLs['newsHeadlines_englishNews'];?>" class="contentSectionTitle3_a"><span class="contentSectionTitle3_span backdropped">English News</span></a></div></li>
        <li><div class="contentSectionTitle3"><a href="<?php echo $naURLs['newsHeadlines_englishNews_worldHeadlines'];?>" class="contentSectionTitle3_a"><span class="contentSectionTitle3_span backdropped">English News : World Headlines only</span></a></div></li>
        <li><div class="contentSectionTitle3"><a href="/business-news" class="contentSectionTitle3_a"><span class="contentSectionTitle3_span backdropped">English Business News</span></a></div></li>
        <li><div class="contentSectionTitle3"><a href="<?php echo $naURLs['newsHeadlines_nederlandsNieuws'];?>" class="contentSectionTitle3_a"><span class="contentSectionTitle3_span backdropped">Nederlands Nieuws</span></a></div></li>
        <li><div class="contentSectionTitle3"><a href="<?php echo $naURLs['newsHeadlines_nederlandsNieuws_wereldNieuws'];?>" class="contentSectionTitle3_a"><span class="contentSectionTitle3_span backdropped">Nederlands Nieuws : Internationale Headlines</span></a></div></li>
        <li><div class="contentSectionTitle3"><a href="<?php echo $naURLs['newsHeadlines_deutscheNachrichten'];?>" class="contentSectionTitle3_a"><span class="contentSectionTitle3_span backdropped">Deutsche Nachrichten</span></a></div></li>
        <li><div class="contentSectionTitle3"><a href="<?php echo $naURLs['newsHeadlines_arabic'];?>" class="contentSectionTitle3_a"><span class="contentSectionTitle3_span backdropped">Arabic Business News (in English)</span></a></div></li>
    </ul>
    
    <a href="<?php echo $naURLs['tarot'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">Tarot cardgame</span></h3></a>

    <a href="https://said.by" class="contentSectionTitle3_a" target="saidBy"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">Blogging features (on https://said.by)</span></h3></a>
    
    <a href="https://zoned.at" target="zonedAt" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">URL redirection (on https://zoned.at)</span></h3></a>

    <h2 class="contentSectionTitle1" ><span class="contentSectionTitle1_span">Alpha</span></h2>
    <a href="/wiki/frontpage" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">Wikipedia.org view</span></h3></a>

    <h2 class="contentSectionTitle1" ><span class="contentSectionTitle1_span">Demos</span></h2>
    <a href="<?php echo $naURLs['3Dcube'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">3D demo : cube</span></h3></a>
    <a href="<?php echo $naURLs['3Dmodels'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">3D demo : loading of models (slow to start up)</span></h3></a>
    <a href="<?php echo $naURLs['backgroundsBrowser'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">3D file explorer</span></h3></a>

    
<?php 
    global $naLAN; 
    if ($naLAN) { 
?>
    <h2 class="contentSectionTitle1"><span class="contentSectionTitle1_span">Administrative features</span></h2>

    <a href="<?php echo $naURLs['analytics'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">Analytics</span></h3></a>

    <a href="/view/logs" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">Logs</span></h3></a>

    <!--
    <a href="<?php echo $naURLs['tasks'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">Tasks</span></h3></a>
    -->
<?php } ?>

    <h1 class="contentSectionTitle1"><p class="contentSectionTitle1_span">NicerEnterprises Company Profile</p></h1>
    <div style="width:40%;color:black;background:rgba(250, 233, 52,0.35);font-size:120%;margin:10px;font-weight:bold;padding:8px;border-radius:10px;text-shadow:0px 0px 3px rgba(255,0,0,0.7);box-shadow:0px 0px 8px 4px rgba(0,0,0,0.666), 2px 2px 2px rgba(0,0,0,0.7);">
        <p style="background:none;">
        <a href="https://nicer.app" target="naHP">https://nicer.app</a>, <a href="https://said.by" target="sbHP">https://said.by</a>, <a href="https://zoned.at" target="zAt">https://zoned.at</a>, <a href="https://github.com/NicerEnterprises" target="githubNicerEnterprises">https://github.com/NicerEnterprises</a>, in addition to ALL of the content listed on and/or hosted by the cloudhosting service companies, online forums and social media accounts that I use (or have ever used), are ENTIRELY
        Copyrighted (C) and All Rights Reserved (R) 2002-2025 and owned by <a href="mailto:rene.veerman.netherlands@gmail.com" target="_new" class="nomod noPushState">Rene A.J.M. Veerman &lt;rene.veerman.netherlands@gmail.com&gt;</a>.<br/>
        </p>

        <!-- proposed NicerAppWebOS/LICENSE.html revenue sharing suggestions, SUGGESTIONS at this time only according to me, Rene AJM Veerman, The Owner of this Software :
        <h2 class="contentSectionTitle1"><p class="contentSectionTitle1_span">NicerEnterprises Contractor Revenue Sharing Promises</p></h2>
        <p><a class="noPushState" href="https://jQuery.com" target="naJQueryContractorDeal">jQuery.com</a> : 1% of my total yearly revenue, whatever size my (x.com/ReneVeerma4021) companies reach.</p>
        <p><a class="noPushState" href="https://TinyMCE.com" target="naJTinyMCEContractorDeal">TinyMCE.com</a> : 1% of my total yearly revenue, whatever size my (x.com/ReneVeerma4021) companies reach.</p>
        <p><a class="noPushState" href="https://YouTube.com" target="naJQueryContractorDeal">YouTube.com</a> : 3% of my total yearly revenue, whatever size my (x.com/ReneVeerma4021) companies reach.</p>
        <p><a class="noPushState" href="https://GitHub.com" target="naGitHubContractorDeal">GitHub.com</a> : 3% of my total yearly revenue, whatever size my (x.com/ReneVeerma4021) companies reach.</p>
        -->

        <p style="background:none;"><a href="https:/facebook.com/rene.veerman.90">https://facebook.com/rene.veerman.90</a></p>
        <p style="background:none;"><a href="https://x.com/ReneVeerma64021">https://x.com/ReneVeerma64021</a>.</p>
        <p style="background:none;"><a href="https://youtube.com/@cheetahKungFu">https://youtube.com/@cheetahKungFu</a> a free video Youtube address where a free video tutorial can be found on the latest top-notch martial-arts training methods and techniques, with excellent music as backdrop for "the self-defense moves".</p>

        <p style="background:none;">
            <h2>Home Addresses and Telephone number for NicerEnterprises:</h2>
            <ul>
                <li>
                "Rene 'Peacefan' A.J.M. Veerman" &lt;rene.veerman.netherlands@gmail.com&gt;<br/>
                Marnixkade 23-2, 1015XP Amsterdam, Netherlands<br/>
                +31 6 23 99 16 59<br/>
                </li>
            </ul>
        </p>

    </div>


    <h1 class="contentSectionTitle1"><p class="contentSectionTitle1_span">Cyberwar Violence Events done against NicerEnterprises</p></h1>
    <div style="width:40%;color:black;background:rgba(250, 233, 52,0.35);font-size:120%;margin:10px;font-weight:bold;padding:8px;border-radius:10px;text-shadow:0px 0px 3px rgba(255,0,0,0.7);box-shadow:0px 0px 8px 4px rgba(0,0,0,0.666), 2px 2px 2px rgba(0,0,0,0.7);">
        <p style="background:none;">
            <ul>
                <li>2025-01-22(Thursday), 02:00CEST until now : Cyberwar problems seem to be behind me for now, in part no doubt to adjustments I made in my <a  class="nomod noPushState" target="gp1b" style="color:yellow;" href="https://x.com/ReneVeerma64021/status/1925345469883953408">geopolitical</a> <a class="nomod noPushState" target="gp1b" style="color:yellow;" href="https://www.usmessageboard.com/threads/the-dems-and-republicans-in-league-with-eachother-to-destroy-the-world-on-behalf-of-us-interests-i-think.1161506/post-36742697">"ramblings"</a> ;-)</li>
                </li>
                <li>2025-01-20(Tuesday) : Someone is preventing me from re-installing my fastest-hardware machine (parakeet) back home, AND from displaying the 11 to 12-thousand background wallpapers that I can run on / for this website!<br/>
                I suspect the CIA.GOV or AIVD.NL to be behind this!
                </li>
            </ul>
        </p>
    </div>



