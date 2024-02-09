na.backgrounds = {
    about : {
        version : '2.1.3'
    },
    settings : {
        lastMenuSelection : (
            $(window).width() > $(window).height()
            ? 'landscape'
            : 'portrait'
        )
    },
    describeCurrentBackground : function () {
        var
        fncn = 'na.backgrounds.describeCurrentBackground()',
        html = '<table style="width:100%;height:100%;"><tr><td>Now analyzing image at <a href="https://clarifai.com)." class="noPushState" target="clarifaiDotCom">clarifai.com</a>, this will take a few seconds to a minute depending on network and process speeds available at this time.</td></tr></table>';
        
        na.site.setStatusMsg (html, true, 30 * 1000);

        var
        url = '/NicerAppWebOS/apps/NicerAppWebOS/application-programmer-interfaces/crawlers/imagesMetaInfo/ajax_imageDescription.json.php',
        ajaxCmd = {
            type : 'GET',
            url : url,
            data : {
                imageURL : $('.bg_first')[0].src
            },
            success : function (jsonText, ts, xhr) {
                var
                data = JSON.parse(jsonText);
                html = '<table style="width:100%;height:100%;"><tr><td><span class="imageDescription_about">Words describing current background</span> : <span class="imageDescription_wordList"><span class="imageDescription_word">'+data.concepts.join('</span>, <span class="imageDescription_word">')+'</span></span><br/> <span class="dataCredits_brackets">(</span><span class="dataCredits">data provided by courtesy of</span> <a href="https://clarifai.com" class="noPushState" target="clarifaiDotCom">clarifai.com</a><span class="dataCredits_brackets">)</span><span class="imageDescription_about">.</span></td></tr></table>';
                na.site.setStatusMsg (html, true, 30 * 1000);
            },
            error : function (xhr, textStatus, errorThrown) {
                na.site.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
            }                
        };
        $.ajax(ajaxCmd);
    },
    next : function (div, search, url, saveTheme, callback, callStack) {
        if (na.site.globals.debug_backgroundChanges) debugger;
        //debugger;
        //return false;


        if (!callStack) callStack = '';
        if (!search) search = na.site.globals.backgroundSearchKey;
        if (!search) {
            search = 'landscape';
            na.site.globals.backgroundSearchKey = search;
        };
        if (saveTheme!==false) saveTheme = true;
        
        var
        fncn = 'na.backgrounds.next(div,search,url,saveTheme,callback)',
        bgs = na.site.settings.backgrounds,
        sk = search.split(/\s+/),
        hits = [];
        
        $('#siteBackground, #siteBackground img, #siteBackground div, #siteBackground iframe').css({
            position:'absolute',
            width : $(window).width(),
            height : $(window).height()
        });
        
        na.bg.s.lastMenuSelection = search;
        
        var useRoot = true;
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

        na.backgrounds.settings.div = div;

        var 
        ajaxCommand = {
            type : 'GET',
            url : url,
            success : function (data, ts, xhr) {
                var
                div = na.backgrounds.settings.div,
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


                if (!url.match(/cracked-surface/)) na.analytics.logMetaEvent ('background set to '+url, false);
                
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
};
na.bg = na.backgrounds;
na.backgrounds.s = na.backgrounds.settings;
