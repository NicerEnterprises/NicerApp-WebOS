if (typeof na!=='object') { var NicerApp_WebOS = nicerapp = na = {}; }
na.background = na.bg = {
    settings : {},

    initialize (settings) {
        var t = this;
        t.settings = $.extend (na.bg.settings, settings);

        var
        url = '/NicerAppWebOS/domainConfigs/'
            +settings.naSite.globals.domainFolder
            +'/ajax_backgrounds.php',
        ac = {
            type : 'GET',
            url : url,
            success : function (data, ts, xhr) {
                try {
                    t.data = JSON.parse(data);

//debugger;
                    //settings.naSite.globals.domain =nicer.app-5.8.0-alpha001c'; // TODO : get this fixed in .../NicerAppWebOS/logic.business-5.8.z/class.NicerAppWebOS.php::TODO 1
                    //t.next ('#siteBackground', 'landscape', null, false, function() {
                        var
                        url2 = '/NicerAppWebOS/domainConfigs/'
                            +settings.naSite.globals.domainFolder
                            +'/ajax_backgrounds_recursive.php',
                        ac2 = {
                            type : 'GET',
                            url : url2,
                            success : function (data, ts, xhr) {
                                try {
                                    t.recursive = JSON.parse(data);
                                } catch (err) {
                                    t.recursive = false;
                                }
                            },
                            error : function (xhr, textStatus, errorThrown) {

                            }
                        };
                        $.ajax(ac2);
                    //});

                } catch (err) {
                    t.data = false;
                    t.recursive = false;
                }

            },
            error : function (xhr, textStatus, errorThrown) {
            }
        };
        $.ajax(ac);

        return this;
    },

    next : function (div, search, url, saveTheme, callback, callStack) {
        var t = na.background;
        var fncn = 'na.background.next()';//na.m.myName(t);
        na.m.waitForCondition (fncn+' : t.data?', function() {
            return t.data;
        }, function() {
            t.next_do (div, search, url, saveTheme, callback, callStack);
        }, 20);
    },

    next_do : function (div, search, url, saveTheme, callback, callStack) {
        var t = na.background;
        if (!div) div = '#siteBackground';
        if (!callStack) callStack = '';
        if (!search) search = t.settings.backgroundSearchKey;
        if (!search) {
            search = 'landscape';
        };
        t.settings.backgroundSearchKey = search;
        if (saveTheme!==false) saveTheme = true;

        var
        fncn = 'na.backgrounds.next(div,search,url,saveTheme,callback)',
        bgs = t.data,
        sk = search.split(/\s+/),
        hits = [];

        $('#siteBackground, #siteBackground img, #siteBackground div, #siteBackground iframe').css({
            position:'absolute',
            width : $(window).width(),
            height : $(window).height()
        });

        t.settings.lastMenuSelection = search;
        //debugger;

        var useRoot = false;
        if (typeof url !== 'string' || url === '') {
            for (var collectionIdx=0; collectionIdx<bgs.length; collectionIdx++) {
                if (!bgs[collectionIdx].files) continue;

                for (var i=0; i<bgs[collectionIdx].files.length; i++) {
                    var
                    bg = bgs[collectionIdx].files[i],
                    hit = true;

                    for (var bgk in bg) break;
                    var
                    bgSize = bg[bgk].split('x'),
                    w = parseInt(bgSize[0]),
                    h = parseInt(bgSize[1]);

                    for (var j=0; j<sk.length; j++) {
                        if (sk[j].substr(0,1)==='-') {
                            if (bgk.match(sk[j])) hit = false;
                        } else {
                            if (!bgk.match(sk[j])) hit = false;
                        }
                    }

                    if (
                        !bgk.match(/tiled/)
                        && !bgk.match(/\.txt$/)
                        && (
                            $(window).width() > w
                            || $(window).height() > h
                        )
                    ) {
                        hit = false;
                    }

                    if (hit) {
                        if (useRoot)
                            hits[hits.length] = bgs[collectionIdx].root+bgk;
                        else
                            hits[hits.length] = bgk;
                    }
                };
            }

            if (hits.length===0) return false;
 //debugger;
            var
            url = hits[Math.floor(Math.random() * Math.floor(hits.length))];
        };
        //debugger;
        //na.m.log (20, fncn+' : url='+url, true);

        t.settings.div = div;

        var
        ajaxCommand = {
            type : 'GET',
            url : url,
            success : function (data, ts, xhr) {
                var
                div = t.settings.div,
                bgf = $(div+' img.bg_first')[0],
                bgl = $(div+' img.bg_last')[0],
                bgDiv = $(div+'_bg')[0],
                bgDiv2 = $(div+'_bg2')[0];
                if (!bgl) debugger;

                if (url.match('tiled')) {
                    $(bgf).add(bgl).fadeOut('slow');
                    $(bgDiv2).css ({
                        width: jQuery(window).width() * na.site.settings.current.scale,
                        height: jQuery(window).height() * na.site.settings.current.scale,
                        background : 'url("'+url+'") repeat'
                    });
                    setTimeout(function() {
                        $(bgDiv2).fadeIn('slow', 'swing', function () {
                            $(bgDiv).css ({
                                display : 'block',
                                width: jQuery(window).width() * na.site.settings.current.scale,
                                height: jQuery(window).height() * na.site.settings.current.scale,
                                background : 'url("'+url+'") repeat'
                            });
                            setTimeout(function(){
                                $(bgDiv2).css ({display:'none'});
                            }, 50);

                            if (typeof callback == 'function') callback();
                        });
                    }, 500);

                } else if (url.match('youtube')) {
                    $(bgDiv).add(bgDiv2).css({display:'none'});
                    $(bgf).add(bgl).fadeOut('slow');

                    var ac = {
                        type : 'GET',
                        url : url,
                        success : function (data, ts, xhr) {
                            var
                            outsideURL = data;

                            var vidID = /embed\/(.*)\?/.exec(outsideURL);
                            if (vidID) {
                                vidID = vidID[1];
                            } else {
                                vidID = /watch\?v\=(.*)\&/.exec(outsideURL);
                                if (vidID) vidID = vidID[1];
                            };

                            var html = 'var player; function onYouTubeIframeAPIReady() {  player = new YT.Player("siteBackground_iframe", { height: "100%", width: "100%", videoId: "'+vidID+'", playerVars: { "playsinline": 1 }, events: { "onReady": na.backgrounds.onPlayerReady, "onStateChange": na.backgrounds.onPlayerStateChange } }); }';
                            $('#siteBackground_iframe_js').html (html);

                            outsideURL = 'https://youtube.com/embed/'+vidID+'?autoplay=1&vq=hd2160&wmode=transparent&enablejsapi=1&html5=1&origin='+document.location.href;

                            $('#siteBackground_iframe').css({display:'block',width:'100%',height:'100%',zIndex:100});
                            $('#siteBackground_iframe')[0].src = outsideURL;
                            $(bgDiv).add(bgDiv2).add(bgl).add(bgf).css({display:'none'});

                            if (typeof callback == 'function') callback();
                        },
                        error : function (xhr, textStatus, errorThrown) {
                            na.site.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
                        }
                    };
                    $.ajax(ac);

                } else {
                    bgl.onload=function(){
                        jQuery(bgDiv).add('#siteBackground_iframe').fadeOut('slow', function(){
                            //$(bgDiv).tubeplayer('destroy');
                        });
                        setTimeout(function() {
                            jQuery(bgl).fadeIn('slow', function(){
                                bgf.src = bgl.src;
                                $(bgf).css ({ display : 'block', opacity : 1 });
                                $(bgl).hide();
                                if (typeof callback == 'function') callback();
                            });
                        }, 500);
                    };
                    $(bgl).css({position:'absolute',display:'none',opacity:1}).hide();
                    bgl.src = url;
                };


                na.site.globals.backgroundSearchKey = search;
                na.site.globals.background = url;
                if (na.site.globals.debug_backgroundChanges) debugger;
                /*if (!$.cookie('cdb_loginName') || $.cookie('cdb_loginName')=='Guest') {
                    $.cookie('siteBackground_search', search, na.m.cookieOptions());
                    $.cookie('siteBackground_url', url, na.m.cookieOptions());
                } else if (saveTheme) {
                    na.site.saveTheme();
                }*/
                if (saveTheme) {
                    na.site.saveTheme();
                }


                //if (!url.match(/cracked-surface/)) na.analytics.logMetaEvent ('background set to '+url, false);

            },
            error : function (xhr, textStatus, errorThrown) {
                //na.site.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
                //TODO: re-enable:
                //na.backgrounds.next (div, search, '', saveTheme, callback);
            }
        };
        //debugger;
        $.ajax(ajaxCommand);

    },

    onPlayerReady : function (a,b,c,d,e,f,g) {
        debugger;
    },

    onPlayerStateChange : function (a,b,c,d,e,f,g) {
        debugger;
    }
}
