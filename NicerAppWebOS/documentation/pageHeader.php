<?php
    global $naWebOS;
    require_once ($naWebOS->basePath.'/NicerAppWebOS/domainConfigs/'.$naWebOS->domain.'/mainmenu.items.php');
    global $naURLs; // from .../NicerAppWebOS/domainConfigs/nicer.app/mainmenu.items.php
    global $na_apps_structure;
    if (false) {
    echo '<pre style="color:blue;">';
    var_dump ($na_apps_structure);
    echo '</pre><pre style="color:purple">';
    var_dump ($naURLs);
    echo '</pre>'; exit();
    }
?>
		<table id="logoAndSiteTitle" border="0" bordercolor="blue" style="width:557px;">
            <tr>
                <td id="tdFor_saCompanyLogo">
                    <table id="tableFor_saCompanyLogo" border="0" style="width:260px;">
                        <tr>
                            <td>
                                <div id="divFor_saCompanyLogo" style="margin-left:5px;width:250px;height:250px;border-radius:10px;border:solid rgba(0,0,0,0.8);padding:5px;box-shadow:0px 0px 2px 1px rgba(0,0,0,0.55);">
                                    <canvas id="saCompanyLogo" width="250" height="250" onclick="event.data={element:'saCompanyLogo'}; na.logo.settings.stage.removeAllChildren(); na.logo.init_do_createLogo('saCompanyLogo','countryOfOriginColors');"></canvas>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="td_spacer" style="width:5px;height:270px;">&nbsp;</td>
                <td>
                    <table id="headerSite" border="0" bordercolor="red" style="width:calc(680px-260px);height:260px;">
                        <tr>
                            <td>
                                <div id="headerSiteDiv" style="height:200px;width:calc(680px-260px-20px);padding-top:20px;border-radius:10px;border:solid rgba(0,0,0,0.8);box-shadow:0px 0px 2px 1px rgba(0,0,0,0.55)">
                                    <div style="height:10px;">&nbsp;</div>
                                    <h1 id="pageTitle" style="font-family:Krona One;margin-block-start:0;margin-block-end:0.2em;text-shadow:4px 4px 2px rgba(0,0,0,0.7);font-size:170%">nicer.app</h1>

                                    <h2 id="tagline1" style="font-size:1rem;font-family:ABeeZee;text-shadow:2px 2px 1px rgba(0,0,0,0.7)">
                                    THE web/pad/phone/TV<br/>
                                    user-interface framework<br/>
                                    and apps platform
                                    </h2>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <script type="text/javascript">
    $(document).ready(function() {
        na.m.waitForCondition ('.../NicerAppWebOS/domainConfigs/nicer.app/frontpage.dialog.siteContent.php::#siteContent : na.m.desktopIdle()? (-->na.site.onload_phase2())', na.m.desktopIdle, na.site.onload_phase2, 50);
    });
    </script>
    <br/><br/>

    <h1 class="contentSectionTitle1">about Nicer Enterprises' WebOS</h1><br/>

    <div class="linkContainer">
        <a href="<?php echo $naURLs['docs__overview'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">Documentation</h3></a>
        <a href="<?php echo $naURLs['docs__license'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">License</h3></a>
        <a href="<?php echo $naURLs['docs__todoList'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">To-Do List</h3></a>
        <a href="<?php echo $naURLs['docs__companyOverview'];?>" class="contentSectionTitle3_a"><h3 class="contentSectionTitle3">Company Overview</h3></a>
    </div>
    <br/><br/><br/>
