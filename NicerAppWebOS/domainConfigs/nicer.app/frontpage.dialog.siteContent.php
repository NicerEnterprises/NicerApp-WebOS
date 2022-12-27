<?php
    global $naWebOS;
    require_once ($naWebOS->basePath.'/NicerAppWebOS/documentation/pageHeader.php');
?>
    <h2 class="contentSectionTitle2">Current Problems</h2><br/><br/>

    <p>
    2022-11-02 08:56CEST:<br/>
    NicerApp won't work properly on iPhone 13, 14, and the related iPad products.<br/>
    This is because Apple.com has become standards-non-compliant.<br/>
    And I'll leave it up to Apple to fix their own products to be able to view my websites again,<br/>
    I'm not buying Apple products every year.
    </p>
    <br/><br/>

    <h2 class="contentSectionTitle2">THIS COMPANY IS NOW FOR SALE!</h2><br/><br/>

    <p>
    Bids can be sent in by unencrypted email to <a href="maillto:rene.veerman.netherlands@gmail.com">rene.veerman.netherlands@gmail.com</a>.<br/>
    Starting price is 50 million euro.<br/>
    You might see me building a Real Time Strategy game, or a Linux security-boosting security service app, or commandline file-copying app with proper progressbar, in the future that way! :)
    </p>
    <br/><br/>

    <h2 class="contentSectionTitle2">The license for this software is now relaxed!</h2><br/><br/>

    <p>
    2022-11-14 01:02CEST:<br/>
    From now on, you will no longer have to pay 5% of your costs to me in order to use NicerApp WebOS for commercial purposes.<br/>
    The only cost remaining for you from now on is 5% of your profits.
    </p>
    <br/><br/>


    <h1 class="contentSectionTitle1">Available Apps</h1><br/><br/><br/>

    <a href="<?php echo $naURLs['music'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">Music</h3></a><br/><br/>
    
    <h3 id="h3_news" class="contentSectionTitle3">News</h3><br/>
    <ul class="index" style="margin-block-end:33px;">
        <li><a href="<?php echo $naURLs['newsHeadlines_englishNews'];?>" class="contentSectionTitle3">English News</a></li>
        <li><a href="<?php echo $naURLs['newsHeadlines_englishNews_worldHeadlines'];?>" class="contentSectionTitle3">English News : World Headlines only</a></li>
        <li><a href="/news-business" class="contentSectionTitle3">English Business News</a></li>
        <li><a href="<?php echo $naURLs['newsHeadlines_nederlandsNieuws'];?>" class="contentSectionTitle3">Nederlands Nieuws</a></li>
        <li><a href="<?php echo $naURLs['newsHeadlines_nederlandsNieuws_wereldNieuws'];?>" class="contentSectionTitle3" >Nederlands Nieuws : internationale headlines</a></li>
        <li><a href="<?php echo $naURLs['newsHeadlines_deutscheNachrichten'];?>" class="contentSectionTitle3">Deutsche Nachrichten</a></li>
        <li><a href="<?php echo $naURLs['newsHeadlines_arabic'];?>" class="contentSectionTitle3">Arabic Business News (in English)</a></li>
    </ul>
    
    <a href="<?php echo $naURLs['tarot'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">Tarot cardgame</h3></a><br/><br/>

    <a href="https://said.by" class="contentSectionTitle3_a" target="saidBy"><h3 class="contentSectionTitle3">Blogging features (on https://said.by)</h3></a>.<br/><br/>
    
    <a href="https://zoned.at" target="zonedAt" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">URL redirection (on https://zoned.at)</h3></a>
    <br/><br/>
    <br/><br/>

    <h2 class="contentSectionTitle2" >Demos</h2><br/><br/><br/>
    <a href="<?php echo $naURLs['3Dcube'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">3D demo : cube</h3></a><br/><br/>
    <a href="<?php echo $naURLs['3Dmodels'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">3D demo : loading of models (slow to start up)</h3></a><br/><br/>
    <a href="<?php echo $naURLs['backgroundsBrowser'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">3D file explorer</h3></a><br/><br/>
    <br/><br/>
  
    
    
<?php 
    global $naLAN; 
    if ($naLAN) { 
?>
    <h2 class="contentSectionTitle2" >Administrative features</h2><br/><br/><br/>

    <a href="<?php echo $naURLs['analytics'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">Analytics</h3></a><br/><br/>

    <a href="<?php echo $naURLs['tasks'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">Tasks</h3></a><br/><br/>


    <br/><br/>
<?php } ?>

