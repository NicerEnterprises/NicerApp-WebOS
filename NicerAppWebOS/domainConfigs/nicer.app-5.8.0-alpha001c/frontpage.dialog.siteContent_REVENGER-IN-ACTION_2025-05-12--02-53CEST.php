<?php
    global $naWebOS;
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

    <div style="width:40%;color:black;background:rgba(250, 233, 52,0.35);font-size:120%;margin:10px;font-weight:bold;padding:8px;border-radius:10px;text-shadow:0px 0px 3px rgba(255,0,0,0.7);box-shadow:0px 0px 8px 4px rgba(0,0,0,0.666), 2px 2px 2px rgba(0,0,0,0.7);">
    Take a video or (tiled) background of any resolution, and project information onto that using any weblanguage you want.<br/>
    Written in a style simple enough for children to learn from.<br/>
    This is the <a href="https://github.com/NicerEnterprises/NicerApp-WebOS" class="contentSectionTitle3_a1 nomod noPushState" target="v5"><span class="contentSectionTitle3_a1" style="box-shadow:none; padding:0px;margin:0px;">5th major version (5.8.0 to be exact)</span></a> of this software.<br/>
    </div>

    <h1 class="contentSectionTitle1"><p class="contentSectionTitle1_span">Company Profile</p></h1>
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
    </div>




    <h2 class="contentSectionTitle1"><span class="contentSectionTitle1_span">Stable Apps</span></h2>

    <?php
        /* REQUIRED ACCORDING TO 2025 LAWS THAT GOVERN HTTPS://nicer.app/music */
        global $naLAN;
        global $naSettings_app2D_musicPlayer_respectDutchCopyright;
        if (!$naSettings_app2D_musicPlayer_respectDutchCopyright || $naLAN) {
    ?>
        <a href="<?php echo $naURLs['music'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3"><span class="contentSectionTitle3_span">Music</span></h3></a>
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




    <h1 class="contentSectionTitle1"><p class="contentSectionTitle1_span">Current "difficulties" getting this site to work are POLITICAL AND CYBERWARFARE IN ORIGINS, yet again...</p></h1>
    <p>
    The guilty parties are the US Democrats, US REPUBLICANS, and their Dutch government "sub-ordinates", along with their UK and German collegues!<br/>
    While I usually am 100% behind NATO, no less.
    </p>
    <p>
    UPDATE, 2025-05-11(Sunday) 04:30CEST (Amsterdam.NL timezone) :<br/>
    The difficulties listed below, getting my background files read and displayed, are unfortunately not yet behind us.<br/>
    I'll work more now additional debug routines and the infamous current na.site.loadContent() bugs, to allow me to get additional open source community help for this.
    </p>
    <div style="width:40%;color:black;background:rgba(250, 233, 52,0.35);font-size:120%;margin:10px;font-weight:bold;padding:8px;border-radius:10px;text-shadow:0px 0px 3px rgba(255,0,0,0.7);box-shadow:0px 0px 8px 4px rgba(0,0,0,0.666), 2px 2px 2px rgba(0,0,0,0.7);">
        <p><a class="noPushState" href="https://x.com/ReneVeerma64021/status/1920179988361277510" target="Xcwna20250507a">UPDATE I - Love &amp; revenge &amp; profit goals...</a></p>
        <p><a class="noPushState" href="https://x.com/ReneVeerma64021/status/1920194520144044431" target="Xcwna20250507b">UPDATE II - Philantropy vs selfishness</a></p>
        <p><a class="noPushState" href="https://x.com/ReneVeerma64021/status/1920357531894878350" target="Xcwna20250507c0508">UPDATE III, just a few hours later - the half-apology + shelving of my future attacks against all US Americans.</a></p>
        <h2>Evidence of cyberattack by NATO's CIA.GOV AGAINST this server and businessman's personal life goals - with the full intent of driving me (the Owner of these websites and vast online content datastores into SUICIDAL thinking - or AGGRESSIVE PROVOCATIVE THINKING - which is potentially just as deadly)</h2>
        <p><a class="noPushState" href="/NicerAppWebOS/screenshots/2025%20A.D./Screenshot_20250508_043716.png"><img src="/NicerAppWebOS/screenshots/2025%20A.D./Screenshot_20250508_043716.png" style="width:280px;"/><br/><h3>File 1</h3></a></p>
        <p><a class="noPushState" href="/NicerAppWebOS/screenshots/2025%20A.D./Screenshot_20250508_044011.png"><img src="/NicerAppWebOS/screenshots/2025%20A.D./Screenshot_20250508_044011.png"style="width:280px;" /><br/><h3>File 2</h3></a></p>
    </div>

    <h1 class="contentSectionTitle1"><p class="contentSectionTitle1_span">X.com, 2025-05-12 02:31CEST: Buy-out offer and consequences if this buyout offer is not followed up on by 'Big Tech' from my main enemies; the US Americans.</p></h1>
    <div style="width:40%;color:black;background:rgba(250, 233, 52,0.35);font-size:120%;margin:10px;font-weight:bold;padding:8px;border-radius:10px;text-shadow:0px 0px 3px rgba(255,0,0,0.7);box-shadow:0px 0px 8px 4px rgba(0,0,0,0.666), 2px 2px 2px rgba(0,0,0,0.7);">
    <a href="https://x.com/ReneVeerma64021/status/1921674985266921710" class="noPushState" target="X-offer-001A">
<p style="width:300px;">
@elonmusk

@Google

@Meta

@facebook

@Microsoft

@microsoftnl
 I am putting a REAL buy-out offer for my https://nicer.app and all that it could ever become (with or without my excellent CTO/programmer-employee help under contract to the buyer), on the table for YOU and only you.<br/>
Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
·<br/>
3 u<br/>
Starting price is, due to potential of the stack of code that powers it, set at 14 million euro after-tax for me personally. Enough to retire on and start a job in #Linux programming, probably working on an innocent #Ubuntu UI extension.<br/>
Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
·<br/>
3 u<br/>
.. environment :-)<br/>
And I promise, if you ever kick me out of the development team for it, dear potential buyers, due to my handicaps of low tolerances for real deadlines at the tender age of nearly-48, then I won't be creating these ideas on any other OS/software platform at ALL.<br/>
Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
·<br/>
3 u<br/>
But I'd rather finish the 3D data universe world thing in a browser for you, the buyers. :-)<br/>
I have *excellent* ideas now, which I keep to myself, I'm not even making drawings or flowcharts of any kind on that topic, on how to get those tasks done in a cloudhosted, CPU+GPU ...<br/>
Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
·<br/>
3 u<br/>
Major Release time is Christmas each year. :-)<br/>
And this time, it won't be for free, not in any years beyond this point where I have not been able to sell my entire (C) + (R) status for this huge stack of code and coding structures and IDEAS on how to make it all work later on.<br/>
Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
·<br/>
3 u<br/>
Contact me for an office setup you create for the initial meetings here in http://Amsterdam.NL (I don't like to travel long distances at the moment; again, due to minor yet severe handicaps I suffer from temporarily), through SINCERE AND HONEST (hint, criminals!) DMs ...<br/>
amsterdam.nl<br/>
Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
·<br/>
3 u<br/>
... right here on my http://x.com/ReneVeerma64021 account; I'll be bringing in my parents as deputy-CEO and only CFO for these meetings that are, once again, to happen in downtown Amsterdam, or on the economic business district in http://south.amsterdam.nl<br/>
x.com<br/>
Rene 'Gavan', NATO Diplomatic & Intel Services (@ReneVeerma64021) on X<br/>
Businessman, Living Demi-God (per Dutch Army dictionary). Living Prophet (NOT a former Prophet). Very terriorial about my (C) & (R) status. HETRO.<br/>
Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
·<br/>
3 u<br/>
This offer is valid until Jan. 10th, 2026AD.<br/>
</p>
</div>

<div style="width:40%;color:black;background:rgba(250, 233, 52,0.35);font-size:120%;margin:10px;font-weight:bold;padding:8px;border-radius:10px;text-shadow:0px 0px 3px rgba(255,0,0,0.7);box-shadow:0px 0px 8px 4px rgba(0,0,0,0.666), 2px 2px 2px rgba(0,0,0,0.7);">
<a href="https://x.com/ReneVeerma64021/status/1921709427070992476" class="noPushState" target="X-consequences-of-not-yielding-001A"><p style="width:300px;">

Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
And I will also need to perform my personal life experiences revenge actions.<br/>
FOR STARTERS : Buy up my software, <br/>
@Google
,
@Meta
,
@Facebook
,
@microsoft
, or
@elonmusk
, or I will TAKE DOWN YOUR SOCIAL MEDIA AND ONLINE FORUM AND DATING FORUM INDUSTRIES ENTIRELY AND FOREVER!!!<br/>
<br/>
Post vertalen<br/>
1:30 a.m. · 12 mei 2025<br/>
·<br/>
3<br/>
 Weergaven<br/>
Interacties van post bekijken<br/>
<br/>
Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
·<br/>
1 u<br/>
By simply making it GPL LICENSED and make that THE ONLY VALID LICENSE FOR ALL UNDER *MY* http://GITHUB.COM/NicerEnterprisnterprises… - you damn right I can be NOT nice too.
github.com<br/>
NicerEnterprises - Overview<br/>
Hosting code for potentially, and soon enough *actually*, THE most advanced 2D+3D CMS browser-based software. In PHP, on Linux for the server (for now). - NicerEnterprises
Revenger Veerman, NATO Diplomatic & Intel Forces.<br/>
@ReneVeerma64021<br/>
·<br/>
49 m<br/>
This is my **very last** social media / online forum post anywhere until Dec 1st 2025AD<br/>
</p>
</a>
</div>


