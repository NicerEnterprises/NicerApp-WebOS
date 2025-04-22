if (typeof na!=='object') { debugger; var NicerApp_WebOS = nicerapp = na = {}; }

/*import { naMisc, arrayRemove } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/na.miscellaneous.js';
import { naThemeEditor } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/na.themeEditor-2.y.z.js';
import { naLogo } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/na.canvasLogo-4.y.z.js';

import { vividUserInterface_2D_background } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/logic.vividUserInterface/v6.y.z/2D/background.js';
import { vividUserInterface_2D_desktop } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/logic.vividUserInterface/v6.y.z/2D/desktop.js';
//import { vividUserInterface_3D_button_startMenu_planet } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/logic.vividUserInterface/v6.y.z/3D/button_startMenu-planet.js';
import { vividUserInterface_2D_dialog } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/logic.vividUserInterface/v6.y.z/2D/dialog.js';
import { vividUserInterface_2D_button } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/logic.vividUserInterface/v6.y.z/2D/button-5.y.z.js';
import { vividUserInterface_2D_button_v4 } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/logic.vividUserInterface/v6.y.z/2D/button-4.1.0.js';
import { vividUserInterface_2D_menu } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/logic.vividUserInterface/v6.y.z/2D/menu.js';
import { naVividMenu__behavior_rainbowPanels as naVividMenu } from '/NicerAppWebOS/ajax_getModule.php?f=/NicerAppWebOS/logic.vividUserInterface/v6.y.z/2D/vividMenu-5.y.z--behavior-rainbowPanels-1.1.0.js';
*/

na.site = {
    about : {
        firstCreated : '10 January 2002',
        copyright : '<table style="height:100%;"><tr><td>Copyright (c)/(C) and All Rights Reserved (r)/(R) 2002-2025 by <a href="mailto:rene.veerman.netherlands@gmail.com" class ="contentSectionTitle3_a"><span class="contentSectionTitle3_span">Rene A.J.M. Veerman</span></a></td><td style="width:40px;"><div class="vividButton" theme="dark" style="position:relative;color:white;height:20px;width:40px;" onclick="na.dismissCopyrightMessage();">Ok</div></td></table>',
        easterEggs : {
            '2023-12(Dec)-13(Tue) 11:34CET (Amsterdam.NL\'s timezone)' : '<p>at a certain point in a soul\'s career,<br/>that soul (learns to) trancend(s) judgement of IQ and EQ of others.<br/>this is usually only once enough kung-fu has been practiced though.<br/><a class="directLink" href="https://youtube.com/@cheetahKungFu" target="ckf">https://youtube.com/@cheetahKungFu</a></p>'
        }
    },

    globals : {
        domain : 'nicer.app', // TODO : not hardcode this
        domainFolder : 'nicer.app-5.7.0', // TODO : do not hardcode this either
        margin : 8,
        smallDeviceWidth : 1081,
        reallySmallDeviceWidth : 700
    },
    settings : {
        current : {},
        heldUp : {}, menus : {}, buttons : {}, eventHandlers : [],
        loadContent : {
            recent : [],
            current : {},
            events : [],
            eventIdx : 0
        }
    },
    apps : {},

    dismissCookieWarning : function () {
        $.cookie('agreedToPolicies', 'true', na.m.cookieOptions());
        na.site.settings.defaultStatusMsg = na.site.about.copyright;
        na.site.setStatusMsg (na.site.about.copyright);

    },

    dismissCopyrightMessage : function () {
        $.cookie('visible_siteStatusbar', 'false', na.m.cookieOptions());
        na.d.s.visibleDivs = arrayRemove (na.d.s.visibleDivs,'#siteStatusbar');
        na.desktop.resize();
    },

    error : function (errorHTML) {
        // detailed (internal) status information in HTML should also be passed to *this* function.
        na.site.setStatusMsg (errorHTML);
        //na.site.displayErrorWindow(errorHTML); -> uses a different input data format these days.
    },

    fail : function (msg, xhr, ajaxOptions, errorFunction) {
        //for na.site.setStatusMsg()
        //var html = '<table class="tableFail" style="width:100%;height:100%;"><tr><td style="font-size:1.5em">'
                //+'<span class="statusFail_nonGlow">'+msg+'</span>'
                //+ '</td><td style="width:105px;"><div class="vividButton" theme="dark" style="position:relative;color:white;width:100px;" onclick="na.site.setStatusMsg(na.site.settings.defaultStatusMsg);">Ok</div></td></table>';
        na.site.error(msg);
        na.m.log (3, 'na.site.fail() : msg='+msg);
        na.analytics.logMetaEvent ('na.site.fail() : msg='+msg);

        if (typeof errorFunction=='function') errorFunction();
    },
    ajaxFail : function (location, url, xhr, ajaxOptions, thrownError) {
        var
        msg = 'AJAX error ('+location+') : '+thrownError+':<br/>url = '+url;

        if (location=='na.site.testDBconnection()' && thrownError=='Internal Server Error') {
            msg = 'Database cookie expired. Please log in again.';
            na.site.displayLogin();
        }

        var
        html = '<table class="tableFail" style="width:99%;"><tr><td style="font-size:1em">'
                +'<span class="statusFail">'+msg+'</span>'
                + '</td><td style="width:105px;"><div class="vividButton" theme="dark" style="position:relative;color:white;width:100px;" onclick="na.site.setStatusMsg(na.site.settings.defaultStatusMsg);">Ok</div></td></table>';
        //var msg2 = '<span style="display:table-cell;vertical-align:middle;background:rgba(255,255,255,0.45);color:red;borderRadius:10">'+msg+'</span>';


        na.site.setStatusMsg(html, true);
        na.m.log (3, 'na.site.ajaxFail() : msg='+msg);
        na.analytics.logMetaEvent ('na.site.ajaxFail() : msg='+msg);
    },
    success : function (msg) {
        var html = '<table class="tableSuccess" style="width:99%;"><tr><td style="font-size:1em">'
                +'<span class="statusSuccess">'+msg+'</span>'
                + '</td><td style="width:105px;"><div class="vividButton" theme="dark" style="position:relative;color:white;width:100px;" onclick="na.site.setStatusMsg(na.site.settings.defaultStatusMsg);">Ok</div></td></table>';
        //var msg2 = '<span style="display:table-cell;vertical-align:middle;background:rgba(255,255,255,0.45);color:red;borderRadius:10">'+msg+'</span>';
        na.site.setStatusMsg(html, true);
        na.m.log (3, 'na.site.success() : msg='+msg);
        na.analytics.logMetaEvent ('na.site.success() : msg='+msg);
    },
    setStatusMsg : function (msg, resize, showMilliseconds, fade) {
        if (resize===undefined) resize = true;
        //debugger;

        //if (!resize) na.site.settings.current.cancelAllResizeCommands = true;
        if (!showMilliseconds) showMilliseconds = 10 * 1000;
        na.site.settings.current.desktopIdle = false;
        if (fade)
        $('#siteStatusbar .vividDialogContent').stop(true,true).animate({opacity:0.0001},'fast', function () {
            na.site.setStatusMsg_do (msg, resize, showMilliseconds);
        });
        else na.site.setStatusMsg_do (msg, resize, showMilliseconds);
    },

    setStatusMsg_do : function (msg,resize,showMilliseconds) {
        $('#siteStatusbar .vividDialogContent').html(msg).delay(50).css({display:'block',margin:0}).stop(true,true).animate({opacity:1},'fast');
        $('#siteStatusbar').animate({height:'auto'}, {
            speed : 'fast',
            progress : function (evt) {
                $(window).trigger('resize');
            }
        });

        na.m.waitForCondition(
            'na.site.setStatusMsg(msg,resize,showMilliseconds) : na.m.HTMLidle()?', na.m.HTMLidle,
            function() {
                if (resize) {
                    na.site.settings.current.statusbarVisible = na.desktop.settings.visibleDivs.includes('#siteStatusbar');
                    if (!na.site.settings.current.statusbarVisible) na.desktop.settings.visibleDivs.push('#siteStatusbar');
                    $(window).trigger('resize');
                };

                if (
                    msg !== na.site.settings.defaultStatusMsg
                    && typeof showMilliseconds=='number'
                ) {
                    clearTimeout (na.site.settings.current.timeoutRevertStatusbarMsg);
                    na.site.settings.current.timeoutRevertStatusbarMsg = setTimeout (function () {
                        na.site.setStatusMsg (na.site.settings.defaultStatusMsg, false);
                        if (!na.site.settings.current.statusbarVisible) na.d.s.visibleDivs = arrayRemove (na.d.s.visibleDivs,'#siteStatusbar');
                        if (resize) setTimeout(function() {
                            $(window).trigger('resize');
                        }, 1000);
                    }, showMilliseconds);
                }
            }, 200
        );
    },

    initialize : function (desktopDefinition) {
        var t = this;
        t.s = t.settings;

        if (navigator.connection) {
            console.log(`Effective network type: ${navigator.connection.effectiveType}`);
            console.log(`Downlink Speed: ${navigator.connection.downlink}Mb/s`);
            console.log(`Round Trip Time: ${navigator.connection.rtt}ms`);
        } else {
            console.log('Navigator Connection API not supported');
        }

        na.desktop.initialize(desktopDefinition);

        t.components = t.c = { dialogs : {}, buttons : {}, menus : {} };
        var c = t.components;

        na.background.initialize({naSite : t});
        na.backgrounds = na.background;


        $('#btnShowStartMenu').mouseenter (function(evt) {
            var evt2 = $.extend( {}, evt);
            evt2.currentTarget = $('#siteMenu__0')[0];
            na.site.components.menus['#siteMenu'].currentEl = evt2.currentTarget;
            na.site.components.menus['#siteMenu'].onmouseover (evt2);
        });


        /*
        c.taskbar = new vividUserInterface_2D_dialog({
            naSite : t,
            el : $('#siteTaskbar')
        });*/
        $('.vividButton4, .vividButton_icon_50x50').each(function(idx,el) {
            c.buttons['#'+el.id] = new vividUserInterface_2D_button ({ naSite : t, el : el });
        });
        $('.vividDialog').each(function(idx,el) {
            var d = new vividUserInterface_2D_dialog ({ naSite : t, el : $(el) });
            switch (el.id) {
                case 'siteTaskbar' : c.taskbar = d; break;
                case 'siteSettingsMenu' : c.settingsMenu = d; break;
                default : if ($('#'+el.id+' > .vividDialogContent').html().trim()!=='{$div_'+el.id+'}') { c.dialogs['#'+el.id] = d;  }break;
            }
        });
        $('#btnSettings').hover (function() {
            var menu = na.site.components.menus['#siteMenu'];
            menu.hideAll( menu, $('#siteMenu__panel__0')[0], 50 );
            $('#siteSettingsMenu').removeClass('hidden').addClass('shown');
        }, function () {
            c.settingsMenu.hide({ naSite : t, checkHeldUp : '#siteSettingsMenu' });
            //$('#siteSettingsMenu').removeClass('shown').addClass('hidden');
        });
        $('#siteSettingsMenu').hover(function() {
            t.settings.heldUp['#siteSettingsMenu'] = true;
        }, function(evt) {
            t.settings.heldUp['#siteSettingsMenu'] = false;
            c.settingsMenu.hide({ naSite : t, checkHeldUp : '#siteSettingsMenu' });
        });

        document.addEventListener ('keyup', function (e) {
            e.preventDefault();

            if (e.altKey && e.code=='KeyB') {
                na.backgrounds.next('#siteBackground');
                //debugger;
            };

        });

        //setInterval (t.backgrounds.next, 60 * 1000);
        setInterval (t.updateSiteDatetime, 1000);
        t.updateSiteDatetime();
        //setTimeout (function() {
            t.g = t.globals = $.extend (t.g, naGlobals);
            na.te = new naThemeEditor();
            debugger;
            t.reloadMenu({callback:function() {
                t.ui = {
                    vb : new vividUserInterface_2D_button_v4()
                };
                setTimeout (function() {
                    na.te.onload('siteContent');
                    t.setSpecificity();
                    t.loadTheme();
                }, 500);
                t.startTooltips();
                $('.vividDialog').css ({
                    overflow : 'hidden'
                });
                $('.vividDialog > .vividDialogContent').fadeIn('normal');
                $('.lds-facebook').fadeOut('normal');

            }});
            //debugger;
        //}, 5);



        console.log (this);
        return this;
    },

    loadModule : function (url, appName, jsClassName, jsVarName) {
        if (!appName.match(/[\w]+/)) {
            na.m.log (1, 'ERROR : na.loadModule() : appName parameter incorrect.');
            debugger;
            return false;
        }
        if (!jsClassName.match(/[\w_]+/)) {
            na.m.log (1, 'ERROR : na.loadModule() : jsClassName parameter incorrect.');
            debugger;
            return false;
        }
        if (!jsVarName.match(/[\w\.]*/)) {
            na.m.log (1, 'ERROR : na.loadModule() : jsVarName parameter incorrect.');
            debugger;
            return false;
        }
        if (
            !url.match ('https://'+na.site.globals.domain)
            && !url.match (/^\//)
        ) {
            na.m.log (1, 'ERROR : na.loadModule() : url parameter incorrect, for security reasons. url='+url);
            debugger;
            return false;
        };
        import (url).then((module) => {
            var js =
                'na.apps["'+appName+'"] = {'
                +'settings : new module.'+jsClassName+'('+jsVarName+')'
                +'}';
            eval (js);
        });
    },

    loadContent : function (event, url, callback_phase1, callback_phase2) {
        na.apps.mustHaveAtLeast_number = 0;
        na.site.settings.url = url;
        //if (na.site.globals.debug['na.site.loadContent']) alert (url);

        //na.desktop.setConfig ('content');

        var
        dateObj = new Date(),
        timeInMilliseconds = dateObj.getTime(),
        appRunTime = timeInMilliseconds - na.m.settings.siteStartTime,
        timeString_runningPage = na.m.secondsToTimeString (appRunTime / 1000),
        timeString_now = na.m.dateObj_toDateString (dateObj),
        timeString = timeString_now+' (@'+timeString_runningPage+' now)',
        dt = { dateObj : dateObj, timeString : timeString },

        ec = na.m.newEventChain(dt, {
            root : {
                labels : { marker : {
                    whatsThis : 'na.m.site.loadContent() : url='+url,
                    stacktrace : na.m.stacktrace(),
                    HTMLevent : event
                }},
                functions : [
                    { callback_phase1 : [na.m.newEventFunction (callback_phase1)] },
                    { callback_phase2 : [na.m.newEventFunction (callback_phase2)] }
                ]
            }
        }),

        c = na.site.settings,
        lc = c.loadContent,
        lcr = lc.recent,
        lcc = lc.current;

        lcc.ec = ec;

        ec.displayStatusUpdates = true;
        ec.isCurrentEventChain_for__na_site_loadContent = true;
        na.m.makeEventsChain_theCurrentOne (lc, ec);

        //na.desktop.settings.visibleDivs = na.desktop.globals.visibleDivs;
        //na.desktop.resize();


   // debugger;
        if (!url.match(/\/view\//) && url.indexOf('/')===0) {
            debugger;
            History.pushState (null, '', document.location.origin+url);
        } else if (url.indexOf('/')===-1) {
            History.pushState (null, '', document.location.origin+'/view/'+url);
        } else debugger;

        event.preventDefault();
    },

	stateChange : function(){
		var
		c = na.site.settings,

        lcc = c.loadContent.current;
        debugger;

        if (!lcc.ec) {
            var
            dateObj = new Date(),
            timeInMilliseconds = dateObj.getTime(),
            appRunTime = timeInMilliseconds - na.m.settings.siteStartTime,
            timeString_runningPage = na.m.secondsToTimeString (appRunTime / 1000),
            timeString_now = na.m.dateObj_toDateString (dateObj),
            timeString = timeString_now+' (@'+timeString_runningPage+' now)',
            dt = { dateObj : dateObj, timeString : timeString },
            state = History.getState(),
            url1 = state.url.replace(document.location.origin,'').replace('/view-content/', '').replace(/^\//,'');

            var
            c = na.site.settings,
            lc = c.loadContent,
            lcr = lc.recent,
            lcc = lc.current;
            ec = na.m.newEventChain(dt, {
                root : {
                    labels : { marker : {
                        whatsThis : 'na.site.stateChange() : url='+state.url,
                        stacktrace : na.m.stacktrace(),
                        HTMLevent : event
                    }},
                    functions : []
                }
            });
            ec.displayStatusUpdates = true;
            ec.isCurrentEventChain_for__na_site_loadContent = false;
            //lcc.ec = ec;
            na.m.makeEventsChain_theCurrentOne (lc, ec);
        } else {
            var
            ec = lcc.ec,

            state = History.getState(),
            url1 = state.url.replace(document.location.origin,'')./*replace('/view/', '').*/replace(/^\//,'');
        }

        if (url1==='') url1 = '/';

        na.m.log (200, 'na.s.c.stateChange(2) : na.site.settings.url='+state.url);
        na.site.settings.url = state.url;
        debugger;
        na.site.loadContent_getContent (ec, url1); // also displays the content
	},

    loadContent_getContent : function (ec, url1) {
        var
        fncn = 'na.site.loadContent_getContent()',
        reloadMenu = false,
		state = History.getState(),
        c = na.site.settings,
        lc = c.loadContent,
        lcc = lc.current,
        reports = [];

        na.site.closeAll_2D_apps();
        na.site.closeAll_3D_apps();

        na.an.logEvent(na.site.settings.event);

        if (url1.match('/view-content/')) {
            var
            url2 = url1
                    .replace(document.location.origin,'')
                    .replace(document.location.host,'')
                    .replace('/view-content/', ''),
            url3 = url1;
        } else if (url1.match('/view/')) {
            var
            url2 = url1
                    .replace(document.location.origin,'')
                    .replace(document.location.host,'')
                    .replace('/view-content/', ''),
            url3 = url1;
        } else {
            var
            url2 = url1.replace(document.location.origin,'').replace(document.location.host,''),
            url3 = url2;
        };
        url3 = url3.indexOf('/')===-1 ? '/view-content/'+url3 : '/'+url3;

        try {
            //  debugger;
            var app = url1.match(/\/view-content/)?JSON.parse(na.m.base64_decode_url(url2)):{};
        } catch (error) {
            appValidJSON = false;
            na.site.settings.loadContent_appValidJSON = appValidJSON;
            var msg = na.m.log (11, 'na.site.loadContent_getContent() : base64 decode error *or* JSON decode error in loadContent_getContent() for <b>url3</b>='+url3+', error='+error.message+', base64 data='+url2+', JSON data='+na.m.base64_decode_url(url2), false);
            reports.push (msg);
            na.site.fail (msg, null);
        };

        var appValidJSON = app !== undefined; //(url2.indexOf('/')!==0);

        var
        dateObj = new Date(),
        timeInMilliseconds = dateObj.getTime(),
        appRunTime = timeInMilliseconds - na.m.settings.siteStartTime,

        timeString_runningPage = na.m.secondsToTimeString (appRunTime / 1000),
        timeString_now = na.m.dateObj_toDateString (dateObj),
        timeString = timeString_now+' (@'+timeString_runningPage+' now)',

        dt = { dateObj : dateObj, timeString : timeString },

        naEventData = na.m.newEvent (dt, {
            loadContent_getContent : {
                reports : { plaintext : reports },
                labels : { marker : {
                    whatsThis : fncn+' : url1='+url1+', url2='+url2+', url3='+url3,
                    stacktrace : na.m.stacktrace(),
                    HTMLevent : event
                }},
                params : {
                    url : state.url,
                    urlTransformedA : url1,
                    urlTransformedB : url2,
                    urlTransformedC : url3,
                    appValidJSON : appValidJSON
                },
                functions : [
                    { ignoreThis : [null] }
                ]
            }

        });
        ec.events.push(naEventData);

        var
        fncn = (
            url2.match(/\/view\//)
                ? fncn+':: app='+JSON.stringify(app)+', app==valid JSON='+(appValidJSON?'true':'false')+ ', url3='+url3
                : fncn+':: url2='+url2
        ),
        loadContent_getContent_do = function () {
            $('.lds-facebook').fadeIn('normal');

            var
            ac = {
                type : 'GET',
                url : url3,
                success : na.site.loadContent_displayContent,
                error : function (xhr, textStatus, errorThrown) {
                    var fncn = 'na.site.loadContent_getContent_do()::error()';

                    $('.lds-facebook').fadeOut('normal');

                    if (xhr.status===302) {
                        var msg = na.m.log (11, fncn+' : REDIRECTED (HTTP 302) -- probably an SEO_value URL -- now calling na.site.loadContent_displayContent(eventData,  xhr.responseText, textStatus, xhr);', false);

                        eventData.reports.plaintext.push (msg);

                        na.site.loadContent_displayContent(xhr.responseText, textStatus, xhr);
                        return false;
                    };

                    if (url3.match(/\/view-content\//)) {
                        var
                        url4 = url2.replace(document.location.origin,'').replace(document.location.host,'').replace('/view_content/', ''),
                        app = JSON.parse(na.m.base64_decode_url(url4));
                    } else {
                        var
                        app = {
                            url : url3.replace(document.location.origin,'').replace(document.location.host,'')
                        };
                    };
                    na.site.ajaxFail(fncn, JSON.stringify(app), xhr, textStatus, errorThrown);
                }
            };
            ac.url = ac.url.replace('\/\/','/');
            $.ajax(ac);
            if (!url1.match(/\/view\//) && url1.indexOf('/')===0) {
                na.analytics.logMetaEvent('na.site.loadContent() : url='+url1);
            } else {
                na.analytics.logMetaEvent('na.site.loadContent() : url2='+url2);
            }
        };

        if (app && app.meta && app.meta.mustBeLoggedIn) {
            if (false /*$.cookie('cdb_loginName')==='Guest'*/) {
                na.site.settings.postLoginSuccess = loadContent_getContent_do;
                na.site.displayLogin();
            } else loadContent_getContent_do();
        } else loadContent_getContent_do();
    },



    loadContent_displayContent (data, ts, xhr) {

        $('.lds-facebook').fadeOut('normal');

        var
        c = na.site.settings,
        lc = c.loadContent,
        lcc = lc.current;

        // stage 001 : call the .ondestroy() handler for all running apps
        for (var appID in na.apps.loaded) {
            var app = na.apps.loaded[appID];
            if (typeof app=='object') {
                for (var divID in app.settings.loadedIn) {
                    if (typeof app.settings.loadedIn[divID].ondestroy == 'function') {
                        app.settings.loadedIn[divID].ondestroy();
                    }
                }
            }
            setTimeout (function(appID) {
                delete na.apps.loaded[appID];
            }, 500, appID);
        }
        na.apps.loaded = {};

/*
        // stage 002 : hide all the toolbar DIVs (apps loaded in this loadContent() call will have to make them visible again themselves during their onload() code call
        na.d.s.visibleDivs = arrayRemove (na.d.s.visibleDivs,'#siteToolbarTop'); $.cookie('visible_siteToolbarTop','', na.m.cookieOptions());
        na.d.s.visibleDivs = arrayRemove (na.d.s.visibleDivs,'#siteErrors'); $.cookie('visible_siteErrors','', na.m.cookieOptions());
        na.d.s.visibleDivs = arrayRemove (na.d.s.visibleDivs,'#siteToolbarLeft'); $.cookie('visible_siteToolbarLeft','', na.m.cookieOptions());
        na.d.s.visibleDivs = arrayRemove (na.d.s.visibleDivs,'#siteToolbarRight'); $.cookie('visible_siteToolbarRight','', na.m.cookieOptions());
        na.desktop.resize();
*/
        na.desktop.setConfig('content');



        var
        fncn = 'na.site.loadContent_displayContent(data,ts,xhr)',
        c = na.site.settings,
        divIdx = -1;

        c.startingScripts = true;
        c.scriptsLoaded = 0;
        c.scriptsToLoad = 0;
        c.scriptsToLoadTotal = 0;
        c.divsInitializing = [];

        // stage 003 : attempt to decode the HTTP-delivered JSON that supplies the HTML and JS for the new page (url2a) and all the apps on that page.
        try {
            var dat = JSON.parse(data);
        } catch (error) {


            //var msg = na.m.log (11, fncn+' : JSON decode error in <b>data</b> error='+error.message+', in data='+data, false);
            //reports.push (msg);
            var msg = na.m.log (11, fncn+' : JSON decode error in data, error='+error.message, false);
            na.site.fail (msg, xhr);

            $('#siteContent > .vividDialogContent').html (data);

            return false;
        };

        //debugger;
        // start the rest of the page startup processing
        var
        dateObj = new Date(),
        timeInMilliseconds = dateObj.getTime(),
        appRunTime = timeInMilliseconds - na.m.settings.siteStartTime,

        timeString_runningPage = na.m.secondsToTimeString (appRunTime / 1000),
        timeString_now = na.m.dateObj_toDateString (dateObj),
        timeString = timeString_now+' (@'+timeString_runningPage+' now)',

        dt = { dateObj : dateObj, timeString : timeString },

        naEventData = na.m.newEvent (dt, {
            loadContent_displayContent : {
                //dt : { created : dt, starts : dt, completed : dt },
                labels : { marker : { whatsThis : fncn+'::lcc.ec.events.push() called' } },
                params : {
                    data : data,
                    dat : dat
                },
                functions : [
                    { ignoreThis : [{completed:true}] }
                ]
            }
        });
        lcc.ec.events.push(naEventData);
        na.site.settings.running_loadTheme = true;
        na.site.settings.running_loadContent = true;


        na.m.runFunctions (lcc.ec, na.m.updateEvent (dt, {
            loadContent_displayContent : {
                labels : { marker : { whatsThis : fncn+'::na.m.runFunctions() called' } },
                newFunctions : [
                    { initializeScriptsForApps : [na.m.newEventFunction (na.site.initializeScriptsForApps, { dat : dat })] },
                    { initializeApps : [na.m.newEventFunction(na.site.initializeApps, { dat : dat })] },
                    { resizeApps : [na.m.newEventFunction(function() {
                        na.m.waitForCondition ('loadContent_displayContent : na.m.HTMLidle() && !na.site.settings.loadingApps?', function () { var r1=na.m.HTMLidle(); var r2=!na.site.settings.loadingApps; return r1&&r2;}, function () {
                            na.site.resizeApps();
                            na.site.settings.running_loadContent = false;
                        }, 100);
                    }, { dat : dat })] },
                    //{ getPageSpecificSettings : [na.m.newEventFunction (na.site.getPageSpecificSettings)] }
                    { loadTheme : [na.m.newEventFunction (function() {
                        na.m.waitForCondition ('loadContent_displayContent : na.m.HTMLidle() && !na.site.settings.running_loadContent?', function () { var r1 = na.m.HTMLidle(); var r2=!na.site.settings.running_loadContent; return r1 && r2;}, function () {
                            na.site.loadTheme (null, null, true, true);
                        }, 100);
                    })] },
                    { reloadMenu : [na.m.newEventFunction(na.site.reloadMenu)] },
                    { loadTheme_cleanup : [na.m.newEventFunction (function() {
                        na.m.waitForCondition ('loadContent_displayContent : na.m.HTMLidle() && !na.site.settings.running_loadTheme?', function () { return na.m.HTMLidle() && !na.site.settings.running_loadTheme}, function () {
                            na.site.globals.themes[na.site.globals.themeName].themeSettings.Apps = {};
                            na.themeEditor.onload(); // results in excess /view/logs data
                            na.site.globals.themes.default = na.site.loadTheme_fetchDialogs();
                        }, 100);
                    })] },
                    { initializeVivids : [na.m.newEventFunction(function(){
                        na.m.waitForCondition ('na.site.initializeVivids() : na.m.HTMLidle()?', function () { return na.m.HTMLidle() && !na.site.settings.running_loadContent}, na.site.startUIvisuals, 100);
                    })] },
                    { renderAllCustomHeadingsAndLinks : [na.m.newEventFunction(function(){
                        na.m.waitForCondition ('na.site.renderAllCustomHeadingsAndLinks() : na.m.HTMLidle()?', function () { return na.m.HTMLidle() && !na.site.settings.running_loadContent}, na.site.renderAllCustomHeadingsAndLinks, 100);
                    })] }
                ]
            }
        }));
    },

    onresize : function(settings) {
        $('#siteBackground, #siteBackground iframe, #siteBackground img, #siteBackground div').css({
            width : $(window).width(),
            height : $(window).height()
        });
        //$('#siteBackground img.bg_first').fadeIn(2000);

        // fix attempts (all failed) for [apple bug 1] orientation change bug on iphone 6
        $('body')[0].scrollLeft = 0;//	$('body')[0].style.position = 'relative';
        $('body')[0].scrollTop = 0;//	$('body')[0].style.position = 'relative';

        $('html')[0].scrollLeft = 0;
        $('html')[0].scrollTop = 0;
        $('html')[0].style.display = 'none';
        $('html')[0].style.display = 'block';

        if (typeof settings=='object' && settings.possiblyChangeBackground) {
            var oldBSK = na.site.globals.backgroundSearchKey;
            if (oldBSK==='' || oldBSK=='landscape' || oldBSK=='portrait') {
                if ( parseFloat($(window).width()) > parseFloat($(window).height()) )
                    na.site.globals.backgroundSearchKey = 'landscape';
                else
                    na.site.globals.backgroundSearchKey = 'portrait';
            }
            if (oldBSK !== '' && oldBSK != na.site.globals.backgroundSearchKey)
                na.backgrounds.next (
                    '#siteBackground',
                    na.site.globals.backgroundSearchKey,
                    null,
                    false
                );
        };

        if (
            na.site.settings.app
            && na.apps.loaded[na.site.settings.app]
            && typeof na.apps.loaded[na.site.settings.app].preResize == 'function'
        ) na.apps.loaded[na.site.settings.app].preResize ( {} );

        na.desktop.resize(function (div, calculationResults, sectionIdx, section, divOrderIdx) {
            if (!settings) settings = {};
            if (!settings.finalized) {
                settings.finalized = true;

                na.site.settings.siteInitialized = true;

                na.site.reloadMenu();

                na.site.onresize_doContent(settings);



                if (typeof settings=='object' && typeof settings.callback=='function') {

                    var cb2 = function (settings) {
                        settings.callback = settings.callback_naSiteOnresize;
                        delete settings.callback_naSiteOnresize;
                        if (
                            (typeof settings=='object' && settings.reloadMenu===true)
                        ) na.site.reloadMenu(settings);
                        else if (typeof settings=='object' && typeof settings.callback=='function') settings.callback();
                    }

                    var cb = settings.callback;
                    settings.callback_naSiteOnresize = cb;
                    settings.callback = function() {
                        na.site.settings.numAppsResizing = 0;
                        na.site.settings.numAppsResized = 0;
                        na.site.settings.appsResizing = {};
                        cb2(settings);
                    };
                } else
                    settings.callback = function() {
                        na.site.settings.numAppsResizing = 0;
                        na.site.settings.numAppsResized = 0;
                        na.site.settings.appsResizing = {};
                        //cb2(settings);
                    };

                na.site.resizeApps(settings.callback);
            }
        });


    },


    updateSiteDatetime : function () {
        var
        d = new Date(),
        r =
        d.getFullYear() + '-' + na.m.padNumber((d.getMonth()+1),2,'0') + '-' + na.m.padNumber(d.getDate(), 2, '0')
        + '(' + Date.locale.en.day_names_short[d.getDay()] + ')'
        + ' ' + na.m.padNumber(d.getHours(), 2, '0') + ':' + na.m.padNumber(d.getMinutes(), 2, '0')
        + ':' + na.m.padNumber(d.getSeconds(), 2, '0'), // + '+' + na.m.padNumber(d.getMilliseconds(), 3, 0);
        html =
            '<div class="datetime time animatedText-orangeYellow">'+na.m.padNumber(d.getHours(), 2, '0')
            + ':' + na.m.padNumber(d.getMinutes(), 2, '0')
            + ':' + na.m.padNumber(d.getSeconds(), 2, '0')+'</div>'
            + '<div class="datetime date animatedText-blue">'
            + d.getFullYear()
            + '-' + na.m.padNumber((d.getMonth()+1),2,'0')
            + '-' + na.m.padNumber(d.getDate(), 2, '0')
            + '(' + Date.locale.en.day_names_short[d.getDay()] + ')'
            +'</div>';
        $('#siteDatetime').html(html);
    },

    reloadMenu : function (settings) {
        // only drastically slows things down
        //na.desktop.resize(null, false);
        //na.onresize ({ reloadMenu:false });


        var t = this;


        //na.m.waitForCondition ('na.reloadMenu() : na.m.HTMLidle() && !na.site.components.startingApps?', function() {
        na.m.waitForCondition ('na.reloadMenu() : na.m.HTMLidle()?', function() {
            var r =
                na.m.HTMLidle();
                //&& !na.site.components.startingApps;
            return r;
        }, function() {
            var
            callback3x = (settings ? settings.callback : null),
            callback2b = function () {
                na.m.log (210, '<UL> & <LI> DATA LOADED FOR #siteMenu', false);
                na.m.log (210, 'STARTING TO RE-INITIALIZE #siteMenu', false);

                setTimeout (function() {
                    $('#siteMenu').css({zIndex:800*1000});
                    na.site.components.menus['#siteMenu'] = new naVividMenu($('#siteMenu')[0], function(menu) {
                        $('#siteMenu').css ({
                            top : $(window).height()+100,
                            left : 10,
                        });
                        $('#siteMenu__0').css ({
                            opacity : 0.00001,
                            zIndex : -1,
                            bottom : -100
                        });

                        na.m.log (210, 'DONE RE-INITIALIZING #siteMenu', false);
                        var topLevelItemCount = $('.vividMenu_mainUL > li', menu).length;
                        //debugger;

                        if (settings) settings.naVividMenu_menuInitialized = menu;
                        if (typeof callback3x=='function') callback3x (settings);
                    });
                }, 50);
            };

            na.site.reloadMenu_reOrganise (callback2b);
        }, 50);
    },

    reloadMenu_reOrganise : function (callback4a) {

        if (!$('#siteMenu_vbChecker')[0]) $('#siteMenu').append('<div id="siteMenu_vbChecker" class="vividButton vividButton_text vividMenu_item" theme="'+$('#siteMenu').attr('theme')+'" style="opacity:0.0001;position:absolute;">abc XYZ</div>');

        var
        fncn = 'na.reloadMenu_forTheFirstTime(callback)',
        menuItemWidth = $('#siteMenu_vbChecker').outerWidth(),
        numRootItems = $('#siteMenu').width() / menuItemWidth,
        nri = Math.floor(numRootItems) > 2 ? Math.floor(numRootItems) : 1,
        mlp = '<li class="contentMenu"><a class="contentMenu" href="-contentMenu-">-contentMenu-</a></li>',
        contentMenu = $('#app_mainmenu li')[0] ? '<li class="contentMenu_populated">'+$('#app_mainmenu li')[0].innerHTML+'</li>' : '';

        var
        widest = { rootItems : 0, layout : null },
        hit = { rootItems : 0, layout : null };

        $('.vividMenu_layout').each (function(idx,layout) {
            var
            iw = parseInt($(layout).attr('itemsLevel1'));

            if (iw > widest.rootItems) widest = { rootItems : iw, layout : layout };
            if (iw === nri) hit = { rootItems : iw, layout : layout };
        });
        if (!hit.layout) hit = widest;

        var
        menu = $('#siteMenu'),
        items = $('.vividMenu_mainUL', menu),
        segs = $('.vividMenu_segments', menu);
        $('.vividMenu_item', menu).remove();

        items.html(hit.layout.innerHTML);
        $('.subMenu, .vividMenu_subMenuPanel', items).each(function (idx, subMenu) {
            var
            smID = '#subMenu__'+$(subMenu).attr('subMenuID');
            //smID = '.subMenu[submenuid="'+$(subMenu).attr('subMenuID')+'"]'; // only to be used when experiencing DNS problems
            items.html (
                items[0].innerHTML.replace( subMenu.outerHTML, $(smID)[0].outerHTML )
            );
        });

        var
        menu = items[0].innerHTML,
        p1 = menu.indexOf(mlp),
        mt = menu.substr(0,p1) + contentMenu + menu.substr(p1+mlp.length);

        items[0].innerHTML = mt;
        var il1 = parseInt($('#siteMenu ul').attr('itemslevel1'));
        //if (mt.indexOf('-contentMenu-')===-1) $('#siteMenu ul').attr('itemslevel1', ''+(il1-1));
        //debugger;

        na.site.transformLinks ($('#siteMenu_items')[0]);
        if (typeof callback4a=='function') callback4a ( menu );
    },

    transformLinks : function (rootElement) {
        //if (!na.site.globals.useLoadContent) return false;
        $('a', rootElement).not('.contentMenu, .noPushState, .hmNavE').each(function(idx, el){

            let x = el.href, y = el.target;

            if (
                el.href.match(document.location.origin)
                && !el.href.match(document.location.origin+'\/#')
            ) {
                let h = "javascript:na.site.loadContent(event,'"+el.href.replace(document.location.origin,'').replace('/view/','')+"');";
                //el.href = '#';
                $(el).attr('onclick', h);
                $(el).attr('targetDisabled',$(el).attr('target'));
                $(el).attr('target','');

            }
        });
    },

    startTooltips : function (evt, rootEl) {
        if (!rootEl) rootEl = document;
        $('.tooltip', rootEl).each (function(idx,el) {
            var theme = $(el).attr('tooltipTheme');
            if (!theme) theme = 'mainTooltipTheme';
            /*if (el.id=='btnLoginLogout' && parseInt($.cookie('haveShownTutorial'))<3) {
                na.site.components.btnLoginLogout = this;
                var ptSettings = {
                    theme : theme,
                    contentAsHTML : true,
                    content : $(el).attr('title'),
                    animation : 'grow',
                    alignTo : 'target',
                    alignX : 'inner-left',
                    offsetX : 10,
                    offsetY : 10,
                    fade : !na.m.userDevice.isPhone,
                    slide : !na.m.userDevice.isPhone,
                    slideOffset : 25
                };
                if (na.m.userDevice.isPhone) ptSettings.showOn = 'none';
                if (ptSettings.content!=='') {
                    $(el).tooltipster(ptSettings);
                    $(el).tooltipster('show');
                    $(el).tooltipster('hide');
                    $(el).addClass('started');
                    setTimeout (function() {
                        $(na.site.components.btnLoginLogout).tooltipster('show');
                        setTimeout(function() {
                            $(na.site.components.btnLoginLogout).tooltipster('hide');
                        }, 2000);
                    }, 500);
                }

            } else */

            if (el.id=='btnChangeBackground' /*&& parseInt($.cookie('haveShownTutorial'))<3*/) {
                na.site.components.btnChangeBackground = el;
                try {
                    var html = $($(el).attr('title'));
                } catch (error) {
                    var html = $(el).attr('title');
                }
                debugger;
                var
                ptSettings = {
                    theme : theme,
                    contentAsHTML : true,
                    content : html,
                    animation : 'grow',
                    alignTo : 'target',
                    alignX : 'inner-right',
                    offsetX : -20,
                    offsetY : 10,
                    fade : !na.m.userDevice.isPhone,
                    slide : !na.m.userDevice.isPhone,
                    slideOffset : 25
                };
                if (na.m.userDevice.isPhone) ptSettings.showOn = 'none';
                if (ptSettings.content!=='') {
                    $(el).tooltipster(ptSettings);
                    setTimeout (function() {
                        $(el).tooltipster('show');
                        $('.mainTooltipTheme').css ({opacity:0.001});
                        setTimeout (function() {
                            $(el).tooltipster('hide');
                        }, 200);
                    }, 600);
                    $(el).addClass('started');
                    setTimeout (function() {
                        $(na.site.components.btnChangeBackground).tooltipster('show');
                        setTimeout(function() {
                            $(na.site.components.btnChangeBackground).tooltipster('hide');
                        }, 2000);
                        if (na.m.userDevice.isPhone) $('.mainTooltipTheme').css({left:$('.mainTooltipTheme').offset().left-20});
                        $('.tip-arrow').css({left:$(el).offset().left-$('.mainTooltipTheme').offset().left});
                    }, 1000);
                };
            } else /*if (
                el.id!=='btnChangeBackground'
                && el.id!=='btnLoginLogout'
            ) */{
                try {
                    var html = $($(el).attr('title'));
                } catch (error) {
                    var html = $(el).attr('title');
                }
                var
                ptSettings = {
                    theme : theme,
                    contentAsHTML : true,
                    content : html
                };
                if (na.m.userDevice.isPhone) ptSettings.showOn = 'none';
                if (ptSettings.content!=='') $(el).tooltipster(ptSettings);
            }
            //console.log ('startTooltips : el.id=='+el.id+', cookie::haveShownTutorial='+$.cookie('haveShownTutorial'));
            $(el).attr('title','');
        });
        $.cookie('haveShownTutorial', parseInt($.cookie('haveShownTutorial'))+1, na.m.cookieOptions());
    },

    setSpecificity : function (simple) {
        $('.na_themes_dropdown').html('<div class="vividDropDownBox_selected vividScrollpane" style="white-space:normal;"></div><div class="vividDropDownBox_selector"><div class="vividScrollpane" style="padding:0px;"></div></div>').delay(50);
        $('.vividDropDownBox_selected, .vividDropDownBox_selector').each(function(idx,el) {
            var w = 0;
            $('.vividButton4, .vividButton, .vividButton_icon_50x50', $(el).parent().parent() ).each(function(idx2, el2) {
                w += $(el2).width();
                $(el2).css ({display : 'inline-block', position:'relative'});
            });
            var w3 = $(this).parent().parent().width();
            var w2 = w3
                    - $('.siteToolbarThemeEditor__label__specificity, .siteToolbarThemeEditor__label__themes, .btnOptions_menu__label__specificity_dropdown, .btnOptions_menu__label__themes_dropdown',
                        $(this).parent().parent()
                    ).width()
                    - w
                    - 20;

            $(this).css({
                width: w2,
                height : 'auto'
            });

        });
        for (var i in na.site.globals.themesDBkeys) {
            if (
                na.site.globals.themesDBkeys[i].display===false
                || !na.site.globals.themesDBkeys[i].has_write_permission
            ) continue;
            var l = i;
        }
        for (var i in na.site.globals.themesDBkeys) {
            if (
                na.site.globals.themesDBkeys[i].display===false
                || !na.site.globals.themesDBkeys[i].has_write_permission
            ) continue;

            var
            divEl = document.createElement('div');
            //l = Object.keys(na.site.globals.themesDBkeys).length - 1;

            $(divEl)
                .html(na.site.globals.themesDBkeys[i].specificityName)
                .attr('value',i);

            //if (!na.site.globals.themesDBkeys[i].hasWritePermission) $(divEl).addClass('disabled');

            var
            b = na.site.components.buttons['#btnLockSpecificity'],
            b1 = b.icon_svg.settings.buttons['#btnLockSpecificity'],
            selectMe = (
                simple
                    ? (
                        na.site.globals.themeSpecificityName === na.site.globals.themesDBkeys[i].specificityName
                        || na.site.globals.specificityName === na.site.globals.themesDBkeys[i].specificityName
                    )
                    : b1 && b1.state == b1.btnCode.selectedState
                        ? (
                            na.site.globals.themeSpecificityName === na.site.globals.themesDBkeys[i].specificityName
                            || na.site.globals.specificityName === na.site.globals.themesDBkeys[i].specificityName
                        )
                        : i == l
            );

            if (selectMe) {
                //debugger;
                $(divEl).addClass('selected');
                //$('.na_themes_dropdown__specificity > .vividDropDownBox_selected').html (na.site.globals.specificityName);
                na.site.globals.themeDBkeys = na.site.globals.themesDBkeys[i];
                //na.loadTheme_applySettings (na.site.globals.themes[na.site.globals.themeName]);
                $('.na_themes_dropdown__specificity > .vividDropDownBox_selected').html (na.site.globals.themeDBkeys.specificityName);
                na.te.settings.specificity = na.site.globals.themeDBkeys;
            };

            //debugger;
            $('.na_themes_dropdown__specificity > .vividDropDownBox_selector > .vividScrollpane').append($(divEl).clone(true,true));
        };

        na.te.s.selectedThemeName = na.site.globals.themeName;
        for (var themeName in na.site.globals.themes) {
            var theme = na.site.globals.themes[themeName];
            for (var i in na.site.globals.themesDBkeys) {
                var it = na.site.globals.themesDBkeys[i];
                if (
                    it.user === theme.user
                    || it.role === theme.role
                    || it.url === theme.url
                    || it.view === theme.view
                    || it.specificityName === theme.specificityName
                ) {
                    var divEl2 = document.createElement('div');
                    $(divEl2).html(themeName).attr('value',i);

                    if (themeName==na.site.globals.themeName) {
                        $(divEl2).addClass('selected');
                        $('.na_themes_dropdown__themes > .vividDropDownBox_selected').html(themeName);
                    }
                    $('.na_themes_dropdown__themes > .vividDropDownBox_selector > .vividScrollpane').append($(divEl2).clone(true,true));
                    break;
                }
            };
        }
        $('.na_themes_dropdown__specificity').hover(function() {
            clearTimeout(na.site.components.timeout_onmouseover_specificity);
            na.site.components.timeout_onmouseover_specificity = setTimeout(function() {
                $('.na_themes_dropdown__specificity > .vividDropDownBox_selector').fadeIn('normal');
                $('#btnDeleteSpecificity').css({alignSelf:'start'});
            }, 700);
        }, function() {
            clearTimeout(na.site.components.timeout_onmouseover_specificity);
            clearTimeout(na.site.components.timeout_onmouseout_specificity);
            na.site.components.timeout_onmouseout_specificity = setTimeout(function() {
                $('.na_themes_dropdown__specificity > .vividDropDownBox_selector').fadeOut('normal');
                $('#btnDeleteSpecificity').css({display:'block'});
            }, 700);

        });
        $('.na_themes_dropdown__specificity > .vividDropDownBox_selector').mouseover(function() {
            clearTimeout(na.site.components.timeout_onmouseout_specificity);
        });

        $('.na_themes_dropdown__specificity > .vividDropDownBox_selector > .vividScrollpane > div').click(function(evt) {
            na.site.globals.specificityName = $(this).html();
            //debugger;
            $('.na_themes_dropdown__specificity > .vividDropDownBox_selected').html($(this).html());
            $('.na_themes_dropdown__specificity > .vividDropDownBox_selector > .vividScrollpane > div').removeClass('selected');
            $(this).addClass('selected');
            na.te.specificitySelected(evt);
        });

        //$('#siteToolbarThemeEditor .vividScrollpane').not('.vividDropDownBox_selected').css({ overflow : 'visible' });

        //if (!na.m.desktopIdle()) {
            na.te.s.c.selectedThemeName = na.site.globals.themeName;
            //$('.themeItem').each(function(idx,ti) {
            $('.themeItem').removeClass('onfocus');

/*
                $(ti).removeClass('onfocus');
                if ($(ti).val()==na.te.s.c.selectedThemeName) {
                    $(ti).addClass('onfocus');
                }
*/

            $('.na_themes_dropdown__themes').hover(function() {
                clearTimeout(na.site.components.timeout_onmouseout_themes);
                $('.na_themes_dropdown__themes > .vividDropDownBox_selector').fadeIn('normal');
            }, function() {
                clearTimeout(na.site.components.timeout_onmouseout_themes);
                na.site.components.timeout_onmouseout_themes = setTimeout (function() {
                    $('.na_themes_dropdown__themes > .vividDropDownBox_selector').fadeOut('normal');
                }, 500);
            });
            $('.na_themes_dropdown__themes > .vividDropDownBox_selector').mouseover(function() {
                clearTimeout(na.site.components.timeout_onmouseout_themes);
            });
            $('.na_themes_dropdown__themes > .vividDropDownBox_selector > .vividScrollpane > div').click(function(evt) {
                $('.na_themes_dropdown__themes > .vividDropDownBox_selected').html($(this).html());
                $('.na_themes_dropdown__themes > .vividDropDownBox_selector > .vividScrollpane > div').removeClass('selected');
                $(this).addClass('selected');
                na.te.themeSelected(evt);
            });





            $('#nb_url1_dropdown').html('<div id="nb_url1_dropdown_selected" class="vividDropDownBox_selected"></div><div id="nb_url1_dropdown_selector" class="vividDropDownBox_selector"></div>');
            $('#url1_dropdown').html('<div id="url1_dropdown_selected" class="vividDropDownBox_selected"></div><div id="url1_dropdown_selector" class="vividDropDownBox_selector"></div>');

            var optEls = $('#nb_url1_select option');
            optEls.each(function(idx,el) {
                var optEl2 = document.createElement('option');
                optEl2.value = JSON.stringify(it);
                optEl2.innerHTML = el.innerHTML;
                if (optEl2.innerHTML==$('.themeItem.onfocus').val()) {
                    $(optEl2)[0].selected = true;
                    $(optEl2).addClass('onfocus');
                };

                var divEl2 = document.createElement('div');
                $(divEl2).html(el.innerHTML);

                //$('#url1_select')[0].appendChild(optEl2);
                $('#nb_url1_dropdown_selector, url1_dropdown_selector').append(divEl2);
                if ($(optEl2)[0].selected) $('#nb_url1_dropdown_selected, #url1_dropdown_selected').html(el.innerHTML);
            });

            $('#url0').html('/'+$.cookie('cdb_loginName').replace(/.*___/g,'').replace(/__/g,'-')+'/');

            $('#nb_url1_dropdown, #url1_dropdown').hover(function() {
                $('#nb_url1_dropdown_selector, #url1_dropdown_selector').fadeIn('normal');
            }, function() {
                $('#nb_url1_dropdown_selector, #url1_dropdown_selector').fadeOut('normal');
            });

            $('#nb_url1_dropdown_selector > div, #url1_dropdown_selector > div').click(function(evt) {
                $('#nb_url1_dropdown_selected, #url1_dropdown_selected').html($(this).html());
                $('#nb_url1_dropdown_selector > div, #url1_dropdown_selector > div').removeClass('selected');
                $(this).add($('#'+$(this).parent()[0].id.replace('nb_',''))).addClass('selected');
                $('#nb_url2_value').css({width:120});
                na.blog.onchange_documentHeaders(evt,na.blog.onresize);
            });






            //});
        /*} /*else {
            $('#themes option').each(function(idx,optEl){
                $('#themeChange_themeName').html('');
                for (var i=0; i<na.site.globals.themesDBkeys.length; i++) {
                    var optEl2 = document.createElement('option');
                    //debugger;
                    optEl2.value = JSON.stringify(na.site.globals.themesDBkeys[i]);
                    optEl2.innerHTML = $(optEl).html();
                    if (optEl.innerHTML==$('.themeItem.onfocus').val()) {
                        $(optEl2)[0].selected = true;
                    };
                    $('#themeChange_themeName')[0].appendChild(optEl2);
                };

                optEl.selected=false;
                if (optEl.innerHTML==$('.themeItem.onfocus').val()) {
                    optEl.selected=true;
                }
            });

        }*/

        //na.setSiteLoginLogout();
    },

    loadTheme : function (callback, theme, doGetPageSpecificSettings, doSwitchSpecificities, specificityName, loadBackground, includeClientOnlyThemes, preserveCurrentTheme, stickToCurrentSpecificity) {
        var
        fncn = 'na.loadTheme(callback,theme)',
        s = na.te.settings.specificity,
        u = na.site.settings.url,
        apps = na.site.globals.app;

        if (typeof specificityName=='undefined') specificityName = na.site.globals.specificityName;
        if (typeof preserveCurrentTheme=='undefined') preserveCurrentTheme = true;

        for (var app in apps) break;

        na.site.settings.running_loadTheme = true;

        na.m.log (10, 'na.loadTheme() : STARTING.', false);

        if (
            !theme
            || typeof theme=='number' // when called via na.loadContent()
        ) theme = na.site.globals.themeName;

        na.te.settings.selectedThemeName = theme;

        // maybe use the immediately following line instead, depends on permissions checking in /NicerAppWebOS/logic.AJAX/ajax_database_loadTheme.php
        //if (!s) var s = { url : '[default]', role : 'guests', user : 'Guest' };

        //if (!s) var s = { url : '[default]' };
        if (doGetPageSpecificSettings) {

            if (preserveCurrentTheme) {
                var ct = na.site.globals.themes[theme];
            } else {
                var ct = null;
            }
            na.site.loadTheme_doGetPageSpecificSettings (function() {

                na.site.loadTheme_do (callback, specificityName, theme, loadBackground);

            }, doSwitchSpecificities, includeClientOnlyThemes, specificityName, theme, ct, stickToCurrentSpecificity);

        } else {
            na.site.loadTheme_do (callback, specificityName, theme, loadBackground);
        };
    },
    loadTheme_initializeExtras : function () {
        // gets called at the end of a chain started by onload_phase2()

/*
        if (
            na.site.globals.themes.default.themeSettings
            && (
                typeof na.site.globals.themes.default.themeSettings['Extras']!=='object'
                || typeof na.site.globals.themes.default.themeSettings['Extras'].length==='number'
            )
        ) {
*/


                        /*
            for (var themeID in na.site.globals.themes) break;
            na.site.globals.themes.default.themeSettings.Extras = {
                'texts' : {
                    'css' : {
                        '#siteContent > .vividDialogContent > li > a, p:not(.backdropped, .vividTextCSS), h1:not(.backdropped, .vividTextCSS), h2:not(.backdropped, .vividTextCSS), h3:not(.backdropped, .vividTextCSS)' : { opacity : // CULPRIT for blogging app na.site.globals.themes[themeID].textBackgroundOpacity, backgroundClip:'text' },
                        '#siteContent .newsApp__item__outer p' : { opacity : 1, backgroundClip:'none' }
                    }
                },
                'menus' : {
                    'css' : {
                        '.vividMenu_item' : { opacity : 1 }
                    }
                }
            };
  //      };
                        */

    },
    loadTheme_doGetPageSpecificSettings : function (callback, doSwitchSpecificities, includeClientOnlyThemes, specificityName, theme, ct, stickToCurrentSpecificity) {
        if (typeof includeClientOnlyThemes=='undefined') includeClientOnlyThemes = true;
        if (typeof stickToCurrentSpecificity=='undefined') stickToCurrentSpecificity = true;

        var
        state = History.getState(),
        url = state.url.replace(document.location.origin,'').replace('/view/', ''),
        url2 = url.replace(document.location.origin,'').replace(document.location.host,'').replace('/view/', ''),
        url3 = '/NicerAppWebOS/logic.AJAX/ajax_get_pageSpecificSettings.php',
        ac2 = {
            type : 'GET',
            url : url3,
            data : {
                viewID : na.m.base64_encode_url(JSON.stringify(na.site.globals.app)),// url2
                includeClientOnlyThemes : includeClientOnlyThemes || na.site.globals.specificityName.match(' client')?'true':'false',
                stickToCurrentSpecificity : stickToCurrentSpecificity,
                specificityName : na.te.s.c.specificity.specificityName,
                c : na.m.changedDateTime_current()
            },
            success : function (data2, ts2, xhr2) {
                if (
                    typeof data2 == 'string'
                    && !data2.match(/E_FATAL/)
                    && !data2.match(/E_WARNING/)
                    && !data2.match(/E_NOTICE/)
                ) {
                    $('#cssPageSpecific, #jsPageSpecific').remove();
                    $('head').append(data2).delay(100);
                }
                if (doSwitchSpecificities) {
                    debugger;
                    if (ct && !na.site.globals.themes[ct.theme]) {
                        na.site.globals.themes[ct.theme] = ct;
                        na.site.globals.themeName = ct.theme;
                    } else {
                        if (theme) na.site.globals.themeName = theme;
                    }
                    na.setSpecificity(true);
                }
                setTimeout(function () {
                    if (typeof callback=='function') callback(true);
                }, 50);
            },
            error : function (xhr, textStatus, errorThrown) {
                na.ajaxFail(fncn, url3, xhr, textStatus, errorThrown);
            }
        };
        //setTimeout (function() {
            debugger;
            $.ajax(ac2);
        //}, 250);
    },

    loadTheme_do : function (callback, specificityName, theme, loadBackground) {
        var
        fncn = 'na.loadTheme_do(callback,theme)',
        s = na.te.settings.specificity,
        u = na.site.settings.url,
        apps = na.site.globals.app,
        acData = {
            orientation : na.site.settings.orientation//,
            //theme : theme//,
            //dialogs : JSON.stringify (na.desktop.settings.visibleDivs)
        };
        if (
            typeof specificityName=='undefined'
            || specificityName===null
        ) specificityName = na.site.globals.specificityName;
        if (typeof apps=='object')
            for (var app in apps) break;
        else app = apps;
        //if (app) acData.app = app;


        if (s) {
            if (s.view) acData.view = s.view;
            if (s.role) acData.role = s.role;
            if (s.user) acData.user = s.user;
            //if (s.specificityName) acData.specificityName = s.specificityName;
            acData.specificityName = specificityName;
            if (specificityName.match('current page')) {
                if (u) acData.url = u;
                if (s.url) acData.url = s.url;
                if (!acData.url) acData.url = window.location.href.replace('https://'+na.site.globals.domain,'');
            }
            if (specificityName.match('app \'')) {
                if (app) acData.app = app;
            }
            if (specificityName.match(/^site /)) {
                delete acData.view;
                delete acData.app;
                delete acData.url;
            }
        } else debugger;

        var
        url = '/NicerAppWebOS/logic.AJAX/ajax_database_loadTheme.php',
        ac = {
            type : 'POST',
            url : url,
            data : acData,
            success : function (data, ts, xhr) {
                // reload #cssPageSpecific and #jsPageSpecific
                if (data=='status : Failed.') {
                    na.m.log (10, 'na.loadTheme() : FAILED (HTTP SUCCESS, but no theme was found)');
                    na.loadTheme_applySettings (na.site.globals.themes[na.site.globals.themeName]);
                    if (typeof callback=='function') callback(true);
                    return false;
                } else if (data==='') {
                    na.m.log (10, 'na.loadTheme() : FAILED (HTTP SUCCESS, but no data returned at all)');
                    na.site.loadTheme_applySettings (na.site.globals.themes[na.site.globals.themeName]);
                    na.site.loadTheme_initializeExtras();
                    if (typeof callback=='function') callback(true);
                    return false;
                }
                try {
                    var themes = JSON.parse(data);
                } catch (error) {
                    na.m.log (10, 'na.loadTheme() : FAILED (could not decode JSON data - '+error.message+')+');
                    na.loadTheme_applySettings (na.site.globals.themes[na.site.globals.themeName]);
                    if (typeof callback=='function') callback(true);

                    // only significantly slows down startup for new viewers :
                    //na.fail (fncn+' : AJAX decode error in data returned for url='+url+', error='+error.message+', in data='+data, xhr, function () {
                    //    na.error (data);
                    //});
                    return false;
                }
                //na.site.globals.themes = themes;
                //na.site.components.theme = themes[theme];

                /*
                var html = ''; idx = 0;
                for (var themeName in themes) {
                    var dit = themes[themeName];

                    if (themeName==theme) {
                        html += '<div id="theme_'+idx+'" class="selected onfocus">'+themeName+'</div>';
                    } else {
                        html += '<div id="theme_'+idx+'">'+themeName+'</div>';
                    }
                }
                $('.na_themes_dropdown__themes > .vividDropDownBox_selector > .vividScrollpane').html(html);
                debugger;
                $('.na_themes_dropdown__themes > .vividDropDownBox_selected').html(theme);
                */

                var dat = themes[theme];
                /*
                for (var themeName in themes) {
                    var dat = themes[themeName];
                    na.site.components.theme = dat;
                    break;
                };*/
                //na.setSpecificity (true);
                na.site.loadTheme_applySettings (dat, callback, loadBackground);
                //na.te.onload('siteContent');
            },
            error : function (xhr, textStatus, errorThrown) {
                debugger;
                //only significantly slows down startup for new viewers :
                //na.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
            }
        };
        $.ajax(ac);
    },

    loadTheme_applySettings : function (dat, callback, loadBackground) {
        if (!dat) {
            na.m.log (1, 'Error : loadTheme_applySettings() called with dat=undefined/false', false);
            return false;
        };
        if (typeof loadBackground=='undefined') loadBackground = true;
        //if (dat.specificityName) {
            $('.na_themes_dropdown__specificity > .vividDropDownBox_selector > div')
                .removeClass('selected')
                .each (function(idx,el) {
                    /*if (el.innerHTML === dat.specificityName) {
                        $(el).addClass('selected');
                        na.te.settings.specificity = na.site.globals.themesDBkeys[$(el).attr('value')];
                    };*/
                    /*
                    var l = Object.keys(na.site.globals.themesDBkeys).length - 1;
                    if (el.innerHTML === na.site.globals.themesDBkeys[l].specificityName) {
                        $(el).parent().find('.vividDropDownBox_selected').html(el.innerHTML);
                        $(el).addClass('selected');
                        na.site.globals.specificityName = el.innerHTML;
                        na.te.settings.specificity = na.site.globals.themesDBkeys[$(el).attr('value')];
                    };
                    */

                });
        //};

        if (dat.menusFadingSpeed) {
            $('#menusFadingSpeed').val(dat.menusFadingSpeed);
            for (var menuID in na.site.components.menus) {
                var m = na.site.components.menus[menuID];
                m.fadingSpeed = parseInt(dat.menusFadingSpeed);
            }
        }

        /*
        $('#menusUseRainbowPanels')[0].checked = dat.menusUseRainbowPanels !== 'false';
        if (dat.menusUseRainbowPanels) {
            for (var menuID in na.site.components.menus) {
                var m = na.site.components.menus[menuID];
                m.percentageFor_rainbowPanels = dat.menusUseRainbowPanels === 'false' ? 0 : 100;
            }

        }*/

        if (loadBackground && dat.background /*&& dat.background!==na.site.globals.background*/) { /* doesn't jive with na.loadContent() */
            na.background.next (
                '#siteBackground',
                na.site.globals.backgroundSearchKey,
                dat.background,
                false
            );
        } else if (loadBackground && !dat.background /*&& dat.background!==na.site.globals.background*/) { /* doesn't jive with na.loadContent() */
            na.background.next (
                '#siteBackground',
                na.site.globals.backgroundSearchKey,
                na.site.globals.background,
                false
            );
        }

        clearInterval (na.site.settings.backgroundChangeInterval);
        if (dat.changeBackgroundsAutomatically=='true') {
    //$('#changeBackgroundsAutomatically')[0].checked = true;
            /*
            var m = $('#backgroundChange_minutes').val();
            var h = $('#backgroundChange_hours').val();
            var ms = ((h * 60)+1) * (m * 60) * 1000;
            na.site.components.backgroundChangeInterval = setInterval (function() {
                na.backgrounds.next (
                    '#siteBackground',
                    na.site.globals.backgroundSearchKey,
                    null,
                    true
                );
            }, ms);
            */
        }
        if (dat.backgroundChange_hours) $('#backgroundChange_hours').val(dat.backgroundChange_hours);
        if (dat.backgroundChange_minutes) $('#backgroundChange_minutes').val(dat.backgroundChange_minutes);
        if (dat.vdSettings_show) $('#vdSettings_show').val(dat.vdSettings_show);
        else $('#vdSettings_show').val('transparent');

        var opacity = (
            $('#vdSettings_show').val()=='hidden'
            ? 0.000001
            : $('#vdSettings_show').val()=='transparent'
                ? 0.5
                : 1
        );
        setTimeout (function() {
            $('.vdSettings').delay(50).css({ opacity : opacity });
        }, 1500);

        var
        h = parseInt($('#backgroundChange_hours').val()),
        m = parseInt($('#backgroundChange_minutes').val()),
        ms = (
            ( h > 0 ? (h * 60) : 1) // 60 minutes in an hour
            * (m > 0 ? (m * 60) : 1) // 60 seconds in a minute
            * 1000 // 1000 milliseconds in a second
        );
        clearInterval (na.site.settings.backgroundChangeInterval);
        //if ($('#changeBackgroundsAutomatically')[0].checked)
        if (true)
        na.site.settings.backgroundChangeInterval = setInterval (function() {
            na.background.next (
                '#siteBackground',
                na.site.globals.backgroundSearchKey,
                null,
                true,
                "na.site.components.backgroundChangeInterval() : this website's backgroundChangeInterval is currently turned on to occur every "+(ms/1000)+" seconds."
            );
        }, ms);

        if (dat.textBackgroundOpacity) {
            na.te.s.c.textBackgroundOpacity = dat.textBackgroundOpacity;
            $('#btnOptions_menu input.sliderOpacityRange').val(dat.textBackgroundOpacity * 100);
            /*
            $('li span, p, h1, h2, h3').css({
                background : 'rgba(0,0,0,'+dat.textBackgroundOpacity+')'
            });
            */
//debugger;
            $('#siteContent > .vividDialogContent > li > a, p, h1, h2, h3').not('.naVividTextCSS, .contentSectionTitle1, .contentSectionTitle1_a, .contentSectionTitle1_span, .contentSectionTitle2, .contentSectionTitle2_a, .contentSectionTitle2_span, .contentSectionTitle3, .contentSectionTitle3_a, .contentSectionTitle3_span, .backdropped, .animatedText_orangeYellow, .animatedText_blue, .animatedText_ivory, .naExternalLink, .naInternalLink, .naText').each (function(idx,el) {
                var bg = na.m.adjustColorOpacity(el, dat.textBackgroundOpacity);
                if (bg) $(el).css({background:bg});
            });
        }
        if (dat.themeSettings && dat.themeSettings['.vividDialog']) {
            $('.vividDialog').css(dat.themeSettings['.vividDialog']);
            $('.vividDialog > .vividDialogBackground1').css(dat.themeSettings['.vividDialog > .vividDialogBackground1']);
        };
        if (dat.themeSettings)
        for (var category in dat.themeSettings) {
            if (
                dID=='.vividDialog'
                || dID=='.vividDialog > .vividDialogBackground1'
                || dID=='.vividDialogBackground1'
            ) continue;
            var categoryItems = dat.themeSettings[category];
            switch (category) {
                case 'Dialogs' :
                    for (var dID in categoryItems) {
                        var dit = categoryItems[dID].css;
                        for (var divSel in dit) {
                            var dit2 = dit[divSel];
                            if (divSel=='#siteToolbarThemeEditor') dit2.opacity = 1; // dirty hack
                            $(divSel).css (dit2);
                            if (dit2.background && dID == '#'+na.te.settings.forDialogID+' > .vividDialogBackground1') {
                                var
                                del = $(dID)[0],
                                rgbaRegEx = /rgba\(\d{1,3}\,\s*\d{1,3}\,\s*\d{1,3}\,\s*([\d\.]+)\).*/,
                                test = rgbaRegEx.test(dit.background),
                                ditbgOpacity = test ? dit.background.match(rgbaRegEx)[1] : dit.opacity;
                                $('.sliderOpacityRange', del).attr('value', ditbgOpacity*100);
                                if (test && na.te.settings.selectedButtonID == 'btnSelectBackgroundColor') {
                                    $('#colorpicker').css({display:'block'}).spectrum ({
                                        color:dit.background,
                                        type:'flat',
                                        clickoutFiresChange : false,
                                        change : function (color) {
                                            var bg = $('.vividDialogBackground1', $('#'+na.te.settings.forDialogID)[0]);
                                            $(bg).css({ background : color, opacity : 1 });
                                            na.te.settings.fireSaveTheme = true;
                                            na.saveTheme();
                                        }
                                    }).css({display:'none'});
                                }
                            }
                        }
                    }
                    break;
                case 'Apps' :
                    for (var appName in categoryItems) {
                        var appItem = categoryItems[appName].css;
                        for (var divSel in appItem) {
                            var dit = appItem[divSel];

                            /* messes up theme loading :
                            for (var prop in dit) {
                                var v = dit[prop];
                                if (typeof v=='string' && !v.match(/\!important/)) {
                                    dit[prop] = dit[prop].replace(';','').replace(/\s\s/g,' ').trim();
                                    dit[prop] += ' !important';
                                }
                            }
                            */

                            $(divSel).css(dit);

                            /*
                            if (dit.background && dID == '#'+na.te.settings.forDialogID+' > .vividDialogBackground1') {
                                var
                                del = $(dID)[0],
                                rgbaRegEx = /rgba\(\d{1,3}\,\s*\d{1,3}\,\s*\d{1,3}\,\s*([\d\.]+)\).* /,
                                test = rgbaRegEx.test(dit.background),
                                ditbgOpacity = test ? dit.background.match(rgbaRegEx)[1] : dit.opacity;
                                $('.sliderOpacityRange', del).attr('value', ditbgOpacity*100);
                                if (test && na.te.settings.selectedButtonID == 'btnSelectBackgroundColor') {
                                    $('#colorpicker').css({display:'block'}).spectrum ({
                                        color:dit.background,
                                        type:'flat',
                                        clickoutFiresChange : false,
                                        change : function (color) {
                                            var bg = $('.vividDialogBackground1', $('#'+na.te.settings.forDialogID)[0]);
                                            $(bg).css({ background : color, opacity : 1 });
                                            na.te.settings.fireSaveTheme = true;
                                            na.saveTheme();
                                        }
                                    }).css({display:'none'});
                                }
                            }*/
                        }
                    }
                    break;
                case 'Extras' :
                    for (var btnAddGraphics_jsTreeText in categoryItems) {
                        var it = categoryItems[btnAddGraphics_jsTreeText].css;
                        for (var divSel in it) {
                            var dit = it[divSel];

                            /* messes up theme loading :
                            for (var prop in dit) {
                                var v = dit[prop];
                                if (typeof v=='string' && !v.match(/\!important/)) {
                                    dit[prop] = dit[prop].replace(';','').replace(/\s\s/g,' ').trim();
                                    dit[prop] += ' !important';
                                }
                            }
                            */

                            $(divSel).css(dit);
                            /*
                            if (dit.background && dID == '#'+na.te.settings.forDialogID+' > .vividDialogBackground1') {
                                var
                                del = $(dID)[0],
                                rgbaRegEx = /rgba\(\d{1,3}\,\s*\d{1,3}\,\s*\d{1,3}\,\s*([\d\.]+)\).* /,
                                test = rgbaRegEx.test(dit.background),
                                ditbgOpacity = test ? dit.background.match(rgbaRegEx)[1] : dit.opacity;
                                $('.sliderOpacityRange', del).attr('value', ditbgOpacity*100);
                                if (test && na.te.settings.selectedButtonID == 'btnSelectBackgroundColor') {
                                    $('#colorpicker').css({display:'block'}).spectrum ({
                                        color:dit.background,
                                        type:'flat',
                                        clickoutFiresChange : false,
                                        change : function (color) {
                                            var bg = $('.vividDialogBackground1', $('#'+na.te.settings.forDialogID)[0]);
                                            $(bg).css({ background : color, opacity : 1 });
                                            na.te.settings.fireSaveTheme = true;
                                            na.saveTheme();
                                        }
                                    }).css({display:'none'});
                                }
                            }*/
                        }
                    }
                    break;
            }
        };

        na.m.log (10, 'na.loadTheme_applySettings() : FINISHED.', false);
        na.site.settings.running_loadTheme = false;
        if (typeof callback=='function') callback(true);
    },

    saveTheme : function (callback, theme, loadBackground) {
        var
        fncn = 'na.saveTheme(callback,theme)',
        s = na.te.settings.specificity,
        u = na.site.components.url,
        apps = na.site.globals.app;

        if (!na.te.s.c.forDialogID && !na.te.s.c.forElements) na.te.onload();

        //if (!theme) theme = na.site.globals.themeName;
        na.site.components.running_saveTheme = true;

        if (typeof apps=='object')
            for (var app in apps) break;
        else var app = apps;

        na.m.log (10, 'na.saveTheme() : STARTING.', false);

        if (!s) return false;
        if (!theme) theme = $('.na_themes_dropdown__themes > .vividDropDownBox_selected > .vividScrollpane').html();

        clearTimeout (na.site.components.saveThemeTimeout);
        na.site.components.saveThemeTimeout = setTimeout(function() {
            var tApp = null;
            if (
                na.site.globals.themes
                && na.site.globals.themes[theme]
                && na.site.globals.themes[theme].apps
            ) tApp = na.site.globals.themes[theme].apps;

            var
            themeData = {
                specificityName : $('.na_themes_dropdown__specificity > .vividDropDownBox_selected').html(),
                theme : theme,
                orientation : na.site.components.orientation,
                backgroundSearchKey : na.site.globals.backgroundSearchKey,
                background : na.site.globals.background,
                changeBackgroundsAutomatically : 'true',//$('#changeBackgroundsAutomatically')[0].checked?'true':'false',
                vdSettings_show : 'hidden',//$('#vdSettings_show').val(),
                backgroundChange_hours : 0,//$('#backgroundChange_hours').val(),
                backgroundChange_minutes : 1,//$('#backgroundChange_minutes').val(),
                menusFadingSpeed : 500,//$('#menusFadingSpeed').val(),
                menusUseRainbowPanels : 'true',//$('#menusUseRainbowPanels')[0].checked ? 'true' : 'false',
                dialogs : {},
                apps : tApp,
                //view : na.site.components.app,
                textBackgroundOpacity : 0.4//parseInt($('#textBackgroundOpacity').val()) / 100
            };

            if (s.view) themeData.view = s.view; //else if (s.url) themeData.url = s.url;
            if (s.role) themeData.role = s.role;
            if (s.user) themeData.user = s.user;
            if (s.specificityName) themeData.specificityName = s.specificityName;
            if (s.specificityName.match('current page')) {
                if (u) themeData.url = u;
                if (s.url) themeData.url = s.url;
                if (!themeData.url) themeData.url = window.location.href.replace('https://'+na.site.globals.domain,'');
                //if (themeData.app) delete themeData.app;
            }
            if (
                typeof s.specificityName=='string'
                && (
                    s.specificityName.match(/site /)
                    || s.specificityName.match(/current page/)
                )
            ) {
                delete themeData.view;
                delete themeData.app;
            }
            if (
                typeof s.specificityName=='string'
                && s.specificityName.match(/app /)
            ) {
                delete themeData.view;
                if (app) themeData.app = app;
            }
            if (
                typeof s.specificityName=='string'
                && s.specificityName.match(/user /)
            ) {
                delete themeData.role;
                if (themeData.app) delete themeData.app;
            }


            /*
            for (var i=0; i<na.desktop.globals.divs.length; i++) {
                var selector = na.desktop.globals.divs[i];
                themeData.dialogs = $.extend (themeData.dialogs, na.fetchTheme (selector));
            }*/

            themeData = na.site.loadTheme_fetchDialogs(themeData);
            na.site.loadTheme_applySettings (themeData, null, false); // apply theme changes, all except .background in this case.
            na.site.globals.themes[na.site.globals.themeName] = $.extend({}, themeData);

            // ENCAPSULATE (ENCODE) json objects for HTTP transport
            themeData.themeSettings = JSON.stringify(themeData.themeSettings);
            themeData.apps = JSON.stringify(Object.assign({},themeData.apps));
            //if (themeData.dialogs.indexOf('+')!==-1) themeData.dialogs = themeData.dialogs.replace(/\+/g, ' ');
            //if (themeData.dialogs.indexOf('\\')!==-1) themeData.dialogs = themeData.dialogs.replace(/\\/g, '');

            var
            url = '/NicerAppWebOS/logic.AJAX/ajax_database_saveTheme.php?viewID='+na.m.base64_encode_url(JSON.stringify(na.site.globals.app)),
            ac2 = {
                type : 'POST',
                url : url,
                data : themeData,
                success : function (data, ts, xhr) {
                    if (data.match('status : Failed')) {
                        $('#siteLoginFailed').html('Could not save settings. Please login again.').fadeIn('normal', 'swing', function () {
                            setTimeout (function() {
                                $('#siteLoginFailed').fadeOut('normal', 'swing');
                            }, 2 * 1000);
                        });
                        na.m.log (10, 'na.saveTheme() : FAILED.');

                    } else {
                        //na.site.globals.specificityName = na.site.globals.specificityName_revert;
                        //na.setSpecificity();

                        //na.loadTheme(null, null, false); //REPLACED with .loadTheme_applySettings() in the block above this AJAX call.

                        na.m.log (10, 'na.saveTheme() : FINISHED.', false);
                        na.site.components.running_saveTheme = false;
                        if (typeof callback=='function') callback (themeData, data);
                    }
                },
                error : function (xhr, textStatus, errorThrown) {
                    na.m.log (10, 'na.saveTheme() : FAILED (HTTP ERROR CODE : '+xhr.status+', HTTP ERROR MSG : '+errorThrown+')+');
                    na.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
                }
            };
            //debugger;
            $.ajax(ac2);
        }, 750);
    },

    loadTheme_fetchDialogs : function (themeData) {
        themeData = $.extend (na.site.globals.themes[na.site.globals.themeName], themeData);
        for (var divSel in na.site.settings.dialogs) {
            if (!themeData.themeSettings) {
                themeData.themeSettings = { // gets initialized through na.onload_phase2() calling na.loadTheme()
                    Dialogs : {}, // filled in below here.
                    Apps : {}, // ditto
                    Extras :  na.te.transform_jsTree_to_siteGlobalsThemes() // pulls data modified by end-users from the Theme Editor back into this na.saveTheme() AJAX call
                };
            }
            if (!themeData.themeSettings.Apps) themeData.themeSettings.Apps = {};

            var
            regExDialogs = /#site(.*)[\s\w\.\#\d\>]*/,
            regExApps = /#app__(.*)__(.*)$/;
            if (divSel.match(regExDialogs)) {
                var divName = divSel.match(regExDialogs)[1];
                if (!themeData.themeSettings['Dialogs'][divName])
                    themeData.themeSettings['Dialogs'][divName] = { css : {} };
                themeData.themeSettings['Dialogs'][divName]['css'] =
                    $.extend (
                        themeData.themeSettings['Dialogs'][divName]['css'],
                        na.fetchTheme(divSel)
                    );
            } else if (divSel.match(regExApps)) {
                var
                m = divSel.match(regExApps),
                appName = m[1],
                appDialogName = m[2];
                if (!themeData.themeSettings['Apps'][appName])
                    themeData.themeSettings['Apps'][appName] = { css : {} };
                //if (!themeData.themeSettings['Apps'][appName]['css'][divSel])
                themeData.themeSettings['Apps'][appName]['css'] =
                    $.extend(
                        themeData.themeSettings['Apps'][appName]['css'],
                        na.fetchTheme(divSel)
                    );
            }
        };

        //if (!themeData.themeSettings.Extras)
        try {
            themeData.themeSettings.Extras = na.te.transform_jsTree_to_siteGlobalsThemes();
        } catch (err) {
            debugger;
        }

        return themeData;
    },

    fetchTheme : function (selector) {
        var ret = {};
        ret[selector] = {
            border : $(selector).css('border'),
            borderRadius : $(selector).css('borderRadius'),
            boxShadow : $(selector).css('boxShadow'),
            color : $(selector).css('color'),
            fontSize : $(selector).css('fontSize'),
            fontWeight : $(selector).css('fontWeight'),
            fontFamily : $(selector).css('fontFamily'),
            textShadow : $(selector+' > .vividDialogContent').css('textShadow')//,
            //opacity : $(selector).css('opacity')
        };
        ret[selector].border = // firefox work-around
            $(selector).css('borderTopWidth')+' '
            //+$(selector).css('borderRightWidth')+' '
            //+$(selector).css('borderBottomWidth')+' '
            //+$(selector).css('borderLeftWidth')+' '
            +$(selector).css('borderTopStyle')+' '
            //+$(selector).css('borderRightStyle')+' '
            //+$(selector).css('borderBottomStyle')+' '
            //+$(selector).css('borderLeftStyle')+' '
            +$(selector).css('borderTopColor')+' '
            //+$(selector).css('borderRightColor')+' '
            //+$(selector).css('borderBottomColor')+' '
            //+$(selector).css('borderLeftColor')+' ';
        ret[selector].borderRadius = // firefox work-around
            $(selector).css("borderTopLeftRadius")+' '
            +$(selector).css("borderTopRightRadius")+' '
            +$(selector).css("borderBottomRightRadius")+' '
            +$(selector).css("borderBottomLeftRadius")+' ';





        if (!$(selector+' > .vividDialogBackground1')[0]) {
            if ($(selector).css('opacity')!=='') {
                ret[selector].opacity = $(selector).css('opacity');
            };
            if ($(selector).css('backgroundSize')!=='') {
                ret[selector].backgroundSize = $(selector).css('backgroundSize');
            };

            if ($(selector).css('backgroundImage') && $(selector).css('backgroundImage')!=='' && !$(selector).css('backgroundImage').match(/none/)) {
                ret[selector].background =
                    $(selector).css('backgroundImage').match(/url\(.*\).*%/)
                        ? $(selector).css('backgroundImage')
                        : $(selector).css('backgroundImage').replace(')',') 0% 0% / ')
                    +$(selector).css('backgroundSize')+' '
                    +$(selector).css('backgroundRepeat');
            } else if ($(selector).css('backgroundColor') !== '') {
                ret[selector].background = $(selector).css('backgroundColor');
            }
        };


        if (
            !selector.match(/,/)
            && $(selector+' > .vividDialogBackground1').length>0
        ) { // for vividDialogs only
            ret[selector+' > .vividDialogBackground1'] = {
                opacity : $(selector+' > .vividDialogBackground1').css('opacity'),
                background :
                    $(selector+' > .vividDialogBackground1').css('background') && $(selector+' > .vividDialogBackground1').css('background') !==''
                    ? $(selector+' > .vividDialogBackground1').css('background').match(/url\(.*\).*%/)
                        ? $(selector+' > .vividDialogBackground1').css('background')
                        : $(selector+' > .vividDialogBackground1').css('background').replace(')',') 0% 0% / ')
                    : 'none',
                borderRadius : $(selector).css('borderRadius'),
                backgroundSize : $(selector+' > .vividDialogBackground1').css('backgroundSize'),
                boxShadow : $(selector+' > .vividDialogBackground1').css('boxShadow')
            };
            ret[selector+' > .vividDialogBackground1'].borderRadius = ret[selector].borderRadius;

            // bugfix for firefox :
            if (
                ret[selector+' > .vividDialogBackground1'].background===''
                && $(selector+' > .vividDialogBackground1').css('backgroundImage') !== ''
            ) ret[selector+' > .vividDialogBackground1'].background =
                $(selector+' > .vividDialogBackground1').css('backgroundImage').replace(/http.*?\/\/.*?\//,'')+' '
                +$(selector+' > .vividDialogBackground1').css('backgroundSize')+' '
                +$(selector+' > .vividDialogBackground1').css('backgroundRepeat');

            if (
                ret[selector+' > .vividDialogBackground1'].background
                && (
                    ret[selector+' > .vividDialogBackground1'].background===''
                    || ret[selector+' > .vividDialogBackground1'].background.match('none')
                )
                && $(selector+' > .vividDialogBackground1').css('backgroundColor') !== ''
            ) ret[selector+' > .vividDialogBackground1'].background = $(selector+' > .vividDialogBackground1').css('backgroundColor');
        };

        /*
        ret[selector+' td'] = {
            fontSize : $(selector+' td').css('fontSize'),
            fontWeight : $(selector+' td').css('fontWeight'),
            fontFamily : $(selector+' td').css('fontFamily'),
            textShadow : $(selector+' td').css('textShadow')
        };
        */
        if (ret[selector].fontFamily) ret[selector].fontFamily = ret[selector].fontFamily.replace(/"/g, '');
        //if (ret[selector+' td'].fontFamily) ret[selector+' td'].fontFamily = ret[selector+' td'].fontFamily.replace(/"/g, '');
        return ret;
    }
};
