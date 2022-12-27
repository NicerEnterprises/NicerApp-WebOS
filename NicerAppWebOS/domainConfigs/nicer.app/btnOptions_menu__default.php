<?php
    require_once (realpath(dirname(__FILE__).'/../../../').'/NicerAppWebOS/boot.php');
    global $naWebOS;
    error_reporting (E_ALL);
?>
<div id="btnOptions_menu__background"></div>

<div id="btnOptions_menu__specificity__containerDiv" style="display:flex;align-items:center;height:44px;">
    <span class="label_specificityOrThemeChange">Specificity</span><select id="specificityChange_specificityName" type="text"></select>
</div>
<div id="btnOptions_menu__theme__containerDiv" style="display:flex;align-items:center;height:44px;">
    <span class="label_specificityOrThemeChange">Theme</span><select id="themeChange_themeName" type="text" onchange="na.te.themeSelected(event);"></select>
</div>



<p style="margin:5px;padding:5px;text-align:center;width:calc(100%-10px);">Set the time between background changes :</p>
<div id="btnOptions_menu__backgroundTimeSettingsChanged_save__containerDiv">
    <div style="margin-left:10px;width:calc(100% - 20px)">
        <input id="changeBackgroundsAutomatically" type="checkbox" onchange="na.site.saveTheme()">
        <label id="changeBackgroundsAutomatically_label" class="smallPadding" for="changeBackgroundsAutomatically" onclick="setTimeout(na.site.saveTheme, 250);">Change backgrounds automatically</label>
    </div>
    <div style="margin:10px;width:calc(100% - 40px)">
        <span>Hours</span><input id="backgroundChange_hours" type="number" min="0" max="23" value="0" style="width:40px;height:1em;margin-left:15px" onchange="na.site.saveTheme()"></input>
        <span style="margin-left:10px;">Minutes</span><input id="backgroundChange_minutes" type="number" min="5" max="59" value="5" style="width:40px;height:1em;margin-left:15px" onchange="na.site.saveTheme()"></input>
    </div>
</div>



<p class="smallPadding" style="width:calc(100%-10px);margin:5px;padding:3px;text-align:center;">Fading speed of menus :</p>
<input id="menusFadingSpeed" type="range" min="300" max="1000" value="400" class="sliderOpacityRange" style="left:10px;width:calc(100% - 30px);position:relative;" onchange="na.site.menusFadingSpeed_change(event);"/>

<div style="margin-left:10px;width:calc(100% - 20px)">
    <input id="menusUseRainbowPanels" type="checkbox" onchange="na.site.menusUseRainbowPanels_change(event)" CHECKED>
    <label id="menusUseRainbowPanels_label" class="smallPadding" for="menusUseRainbowPanels" onclick="setTimeout(na.site.saveTheme, 250);">Menus use rainbow colored panels</label>
    <!--
        TODO :
        i'm going to need radio-buttons (category, behavior, mode, type) *and* checkboxes (to enable specific functionality common to all these categories) in these lines.

        but what works even better is a vividMenu here, version 5.1.z, which has a setting to make vividButton in that vividMenu have an enabled/disabled setting and user-interface css declaration (an animation in yellow boxshadow for instance, or blue-cyan or whatever).

        and then a version 5.2.z, which enables vividDialogPopup dialogs to be popped up via a menu.
    -->
</div>




<p class="smallPadding" style="width:calc(100%-10px);margin:5px;padding:3px;text-align:center;">Transparency value of text background :</p>
<input id="textBackgroundOpacity" type="range" min="1" max="100" value="50" class="sliderOpacityRange" style="left:10px;width:calc(100% - 30px);position:relative;" onchange="na.te.textBackgroundOpacityChange(event);"/>
<br/>


<?php 
    global $naWebOS;
    echo $naWebOS->html_vividButton (
        0, 'align-items:center;justify-content:center;margin-right:10px;margin-left:10px;',
        
        'btnClearCookies',
        'vividButton_icon_50x50 grouped btnDelete forum', '_50x50', 'grouped',
        '', 
        'na.m.clearCookies(event)',
        '',
        '',
        
        201, 'Reset cookies.',

        
        'btnCssVividButton_outerBorder.png',
        'btnCssVividButton.blue1a.png',
        null,//'btnCssVividButton_iconBackground.png',
        'btnTrashcan_red.png',
        
        '',
        
        'Reset cookies.',
        'grouped btnDelete themes', 
        ''
    );
?>
<?php
    global $naLAN;
    if ($naLAN) echo $naWebOS->html_vividButton (
        0, 'align-items:center;justify-content:center;margin-right:10px;margin-left:10px;',

        'btnFullResetOfAllThemes',
        'vividButton_icon_50x50 grouped btnDelete forum', '_50x50', 'grouped',
        '',
        'na.site.onclick_btnFullResetOfAllThemes(event)',
        '',
        '',

        201, 'Reset to default themes.',


        'btnCssVividButton_outerBorder.png',
        'btnCssVividButton.blue1b.png',
        null,//'btnCssVividButton_iconBackground.png',
        'btnTrashcan_red.png',

        '',

        'Reset to default themes.',
        'grouped btnDelete themes',
        ''
    );
?>
<?php
    echo $naWebOS->html_vividButton (
        0, 'align-items:center;justify-content:center;margin-right:10px;margin-left:10px;',

        'btnShowErrors',
        'vividButton_icon_50x50 grouped btnDelete forum', '_50x50', 'grouped',
        '',
        'na.site.onclick_displayPHPerrors(event)',
        '',
        '',

        203, 'View PHP errors.',

        'btnCssVividButton_outerBorder.png',
        'btnCssVividButton.yellow1a.png',
        null,//'btnCssVividButton_iconBackground.png',
        'btnTrashcan_red.png', //!! !!

        '',

        'View PHP errors.',
        'grouped btnDelete menuLayoutData',
        ''
    );
?><?php
    /*echo $naWebOS->html_vividButton (
        0, 'align-items:center;justify-content:center;margin-right:10px;margin-left:10px;',
        
        'btnShowErrors', 
        'vividButton_icon_50x50 grouped btnDelete forum', '_50x50', 'grouped',
        '', 
        'na.site.onclick_displayPHPerrors(event)',
        '',
        '',

        203, 'View all PHP errors of the past 2 hours',
        
        'btnCssVividButton_outerBorder.png',
        'btnCssVividButton.yellow1a.png',
        null,//'btnCssVividButton_iconBackground.png',
        'na.question-mark.svg.png', //!! !!
        
        '',
        
        'View all PHP errors of the past 2 hours', 
        'grouped btnDelete menuLayoutData', 
        ''
    );*/
?>

