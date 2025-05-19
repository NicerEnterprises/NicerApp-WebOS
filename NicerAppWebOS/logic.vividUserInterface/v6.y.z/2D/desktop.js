if (typeof na!=='object') { var NicerApp_WebOS = nicerapp = na = {}; }
na.desktop = na.d = {
    initialize (settings) {
        var t = this;
        t.g = {
            animationSpeed : 300,//'slow',
            divs : [ '#siteTaskbar', '#siteDateTime', '#siteErrors', '#btnOptions', '#btnLoginLogout', '#btnChangeBackground', '#siteContent', '#siteVideo', '#siteVideoSearch', '#siteComments', '#siteStatusbar', '#siteToolbarThemeEditor', '#siteToolbarLeft', '#siteToolbarRight', '#siteToolbarTop' ],
            configs : {
                'background' : [ ],
                'all' : [ '#siteContent', '#siteVideo', '#siteVideoSearch', '#siteStatusbar' ],
                'content' : [ '#siteContent' ],
                'contentStatusbar' : [ '#siteContent', '#siteStatusbar' ],
                'contentMusicAndMusicSearch' : [ '#siteContent', '#siteVideo', '#siteVideoSearch' ],
                'contentMusicComments' : [ '#siteContent', '#siteVideo', '#siteComments' ],
                'contentComments' : [ '#siteContent', '#siteComments' ],
                'comments' : [ '#siteComments' ],
                'musicAndMusicSearch' : [ '#siteVideo', '#siteVideoSearch' ],
                'musicComments' : [ '#siteVideo', '#siteComments' ],
                'contentAndToolbarRight' : [ '#siteContent', '#siteToolbarRight' ]
            },
            defaultPos : {
                '#siteDateTime' : {
                    top : -100,
                    left : 10,
                    opacity : 0.0001
                },
                '#siteContent' : {
                    top : ($(window).height()/2)-50,
                    left : ($(window).width()/2)-50,
                    width : 100,
                    height : $(window).height()-120,
                    opacity : 0.0001
                },
                '#siteErrors' : {
                    top : -1 * ( $(window).height() * 2),
                    left : ($(window).width()/2) - ( $(window).width()/10/2 ),
                    width : $(window).width()/10,
                    height : $(window).height()/10,
                    opacity : 0.0001
                },
                '#siteVideo' : {
                    top : $('#siteDateTime').height()+20,
                    left : $(window).width()+100,
                    opacity : 0.0001
                },
                '#siteVideoSearch' : {
                    top : $('#siteDateTime').height()+20+$('#siteVideo').height()+10,
                    left : $(window).width()+100,
                    width : !na.m.userDevice.isPhone ? 300 : $(window).width() - 50,
                    opacity : 0.0001
                },
                '#siteComments' : {
                    top : $('#siteDateTime').height()+20,
                    left : $(window).width()+100,
                    width : !na.m.userDevice.isPhone ? 300 : $(window).width() - 50,
                    opacity : 0.0001
                },
                '#siteToolbarThemeEditor' : {
                    top : $('#siteDateTime').height()+20,
                    left : -400,
                    height : $(window).height()-120,
                    width : !na.m.userDevice.isPhone ? 340 : $(window).width() - 50,
                    opacity : 0.0001
                },
                '#siteToolbarLeft' : {
                    top : $('#siteDateTime').height()+20,
                    left : -420,
                    height : $(window).height()-120,
                    width : !na.m.userDevice.isPhone ? 400 : $(window).width() - 50,
                    opacity : 0.0001
                },
                '#siteToolbarRight' : {
                    top : $('#siteDateTime').height()+20,
                    left : $(window).width()+100,
                    height : $(window).height()-120,
                    width : 300,//!na.m.userDevice.isPhone ? 300 : $(window).width() - 50,
                    opacity : 0.0001
                },
                '#siteToolbarTop' : {
                    top : -250,
                    left : 10,
                    height : 200,
                    width : $(window).width() - 20,
                    opacity : 0.0001
                },
                '#siteStatusbar' : {
                    top : $(window).height() + 50,
                    opacity : 0.0001
                }
            },
            margin : 25
        };

        t.s = t.settings = $.extend( {
            animate : !na.m.userDevice.isPhone,
            animating : true,
            showVideoBackgroundControls : false,
            masterCallbacks : [],
            callbacks : [],
            callbacksProgress : [],
            cmds : [],
            visibleDivs : [ '#siteContent' ]
        }, settings);
        if (!na.m.userDevice.isPhone) t.s.visibleDivs.push ('#siteTaskbar');

        $(window).resize(t.resize);
        setTimeout (t.resize, 10);

        window.removeEventListener('deviceorientation', na.desktop.reloadMenu);
        window.addEventListener('deviceorientation', na.desktop.reloadMenu);
        window.removeEventListener('devicemotion', na.desktop.reloadMenu);
        window.addEventListener('devicemotion', na.desktop.reloadMenu, false);
        window.removeEventListener('gesturechange', na.desktop.gestureChange);
        window.addEventListener('gesturechange', na.desktop.gestureChange, false);
        window.removeEventListener('gestureend', na.desktop.gestureChange);
        window.addEventListener('gestureend', na.desktop.gestureChange, false);

        document.removeEventListener('touchmove', na.desktop.gestureChange);
        document.addEventListener('touchmove', na.desktop.gestureChange, false);
        window.visualViewport.addEventListener("resize", na.desktop.gestureChange);
        /*
        $('body').hammer().on('pinchin', '.vividDialog', na.desktop.gestureChange);
        $('body').hammer().on('pinchout', '.vividDialog', na.desktop.gestureChange);
        na.site.settings.zingtouch = new ZingTouch.Region(document.body);
        na.site.settings.zingtouch.bind ($('#siteContent')[0], 'distance', na.desktop.gestureChange);
        */

    },

    reloadMenu : function () {
        na.site.onresize({ reloadMenu : true });
    },

    gestureChange : function (e) {
        debugger;
        if (e.scale < 1.0) {
            // User moved fingers closer together
            na.site.settings.na3D['.na3D'].orbitControls.handleTouchMovePan (e);

        } else if (e.scale > 1.0) {
            // User moved fingers further apart
            na.site.settings.na3D['.na3D'].orbitControls.handleTouchMovePan (e);
        }
    },

    resize : function (callback, animate, reset) {
        var
        fncn = 'na.components.desktop.resize()',
        t = na.desktop;

        na.d.s.animating = true;
        if (reset === undefined) reset = true;

        $('#siteBackground, #siteBackground iframe, #siteBackground img, #siteBackground div').css({
            width : $(window).width(),
            height : $(window).height()
        });

        $('#siteMenu').css ({
            top : $(window).height()+100,
            left : 10,
        });
        $('#siteMenu__0').css ({
            opacity : 0.00001,
            zIndex : -1,
            bottom : -100
        });

        if (!na.d.s.visibleDivs.includes('#siteTaskbar')) na.d.s.visibleDivs.push('#siteTaskbar');
        //na.d.s.visibleDivs.push('#siteToolbarThemeEditor');
        if (!na.d.s.visibleDivs.includes('#siteContent'))
        na.d.s.visibleDivs.push('#siteContent');

        //var cr = $.extend(true, {}, na.desktop.settings.negotiateOptions );
        var cr = JSON.parse(JSON.stringify(na.desktop.settings.negotiateOptions));
        while (JSON.stringify(cr).match('conditions')) {
            var cr = t.parseOptions(t, cr);
        }
        var calculationResults = na.desktop.settings.calculationResults = {
            calculationResults_visible : cr
        };

       cr.order = [];
       cr.order.push ('#siteTaskbar');
       //cr.order.push ('#siteToolbarThemeEditor');
       if (na.d.s.visibleDivs.includes('#siteToolbarLeft')) cr.order.push('#siteToolbarLeft');
       if (na.d.s.visibleDivs.includes('#siteToolbarRight')) cr.order.push('#siteToolbarRight');
       cr.order.push ('#siteContent');

        if (cr['#siteContent']) {
            let gtl = cr['#siteContent'].growToLimits;

            //if (visibleDivs.includes('#siteToolbarTop')) gtl.push ({ element : '#siteToolbarTop', edge : 'bottom' });
        }

        let divs = {};
        for (var sectionID in calculationResults) {
            let section = calculationResults[sectionID];

            var sectionKeys = Object.keys(calculationResults);
            for (var j=0; j<sectionKeys.length; j++) {
                if (sectionKeys[j]===sectionID) var sectionIdx = j;
            };

            for (var divID in na.d.g.defaultPos) {
                $(divID).css(na.d.g.defaultPos[divID]);
            }

            for (var i=0; i<section.order.length; i++) {
                var divID = section.order[i];


                //if (!section[divID]) { debugger; continue; };
                divs[divID] = { top : 0, left : 0, width : $(divID).width(), height : $(divID).height() };
                //debugger;

                for (var j=0; j<section[0][divID].snapTo.length; j++) {
                    var
                    sn = section[0][divID].snapTo[j],
                    offsetY = section[0][divID].offsetY ? section[0][divID].offsetY : 0,
                    offsetX = section[0][divID].offsetX ? section[0][divID].offsetX : 0;
                    //if (divID=='#btnOptions' || divID=='#siteMenu') debugger;
                    //if (divID=='#siteToolbarThemeEditor') debugger;
                    switch (sn.edge) {
                        case 'top':
                            if (sn.element==='body') divs[divID].top = na.d.g.margin; else divs[divID].top = divs[sn.element].top + na.d.g.margin;
                            break;
                        case 'bottom':
                            if (sn.element==='body') {
                                divs[divID].top = $(window).height() - $(divID).height();
                            } else {
                                if (divs[sn.element]) divs[divID].top = divs[sn.element].top + $(sn.element).height() + na.d.g.margin;
                            }
                            break;
                        case 'left':
                            if (sn.element==='body') divs[divID].left = na.d.g.margin;
                            else divs[divID].left = divs[sn.element].left + $(sn.element).width() + na.d.g.margin;
                            break;
                        case 'right':
                            if (sn.element=='body') {
                                divs[divID].left = $(window).width() - $(divID).width() - na.d.g.margin+ offsetX;
                            } else {
                                if (!divs[sn.element]) debugger;
                                divs[divID].left = divs[sn.element].left + $(sn.element).width() + na.d.g.margin + offsetX;
                            }
                            break;
                        case 'rightNegative':
                            if (!divs[sn.element]) debugger;
                            divs[divID].left = divs[sn.element].left - $(divID).width() - na.d.g.margin + offsetX;
                            break;
                    }
                }

                switch (section[0][divID].growTo) {
                    case 'max':
                        divs[divID].width = $(window).width() - divs[divID].left - na.d.g.margin;
                        divs[divID].height = $(window).height() - divs[divID].top;
                        break;
                    case 'maxX':
                        divs[divID].width = $(window).width() - divs[divID].left - na.d.g.margin;
                        divs[divID].height = $(divID).height();
                        break;
                    case 'maxY':
                        if ($(window).width() < na.site.globals.reallySmallDeviceWidth)
                            divs[divID].width = $(window).width() - (2 * na.d.g.margin)
                        else
                            divs[divID].width = $(divID).width();

                        divs[divID].height = $(window).height() - divs[divID].top;
                        break;
                }

                if (section[0][divID].growToLimits)
                for (var j=0; j<section[0][divID].growToLimits.length; j++) {
                    var gtl = section[0][divID].growToLimits[j];
                    switch (gtl.edge) {
                        case 'left': divs[divID].width -= ($(window).width() - divs[gtl.element].left); break;
                        case 'top': divs[divID].height -= ($(window).height() - divs[gtl.element].top); break;
                        case 'bottom': break; // doesnt need this : divs[divID].height -= $(gtl.element).height(); break;
                        case 'right': break; // doesnt need this either : divs[divID].width -= $(gtl.element).width(); break;
                    }
                }

                if (section[0][divID].xMinLeft) divs[divID].left -= section[0][divID].xMinLeft;
                if (section[0][divID].yMinTop) divs[divID].top -= section[0][divID].yMinTop;
                if (section[0][divID].xMinWidth) divs[divID].width -= section[0][divID].xMinWidth;
                if (section[0][divID].yMinHeight) divs[divID].height -= section[0][divID].yMinHeight;
                na.m.log (10010, fncn+' : calculated sections', false);

                switch (divID) {
                    case '#siteMenu':
                        //divs[divID].top += na.d.g.margin;
                        divs[divID].left += na.d.g.margin;
                        break;
                    case '#btnOptions':
                        if ($('#siteDateTime').css('display')!=='none') divs[divID].left += na.d.g.margin;
                        //divs[divID].top += na.d.g.margin;
                        break;
                    case '#siteDateTime':
                    case '#btnLoginLogout':
                    case '#btnChangeBackground':
                        //divs[divID].top += na.d.g.margin;
                        break;
                    case '#siteToolbarLeft':
                    case '#siteToolbarThemeEditor':
                        divs[divID].height -= (1*na.d.g.margin);
                        break;
                    case '#siteContent':
                        divs[divID].height -= (2 * na.d.g.margin) - 6;
                        //divs[divID].left += na.d.g.margin;
                        divs[divID].width -= (na.d.g.margin);
                        //if (visibleDivs.includes('#siteDateTime')) {
                            //divs[divID].top += na.d.g.margin;
                            //divs[divID].height -= na.d.g.margin;
                        //}
                        if (
                            na.d.s.visibleDivs.includes('#siteComments')
                            || na.d.s.visibleDivs.includes('#siteToolbarRight')
                        ) {
                            //divs[divID].width -= ( na.d.g.margin );
                        }
                        break;
                    case '#siteVideo':
                        divs[divID].left -= (na.d.g.margin);
                        divs[divID].top += (2 * na.d.g.margin );
                        break;
                    case '#siteVideoSearch':
                    case '#siteToolbarRight':
                        divs[divID].height -= na.d.g.margin;
                        break;
                    case '#siteComments':
                        divs[divID].height -= (2*na.d.g.margin);
                        divs[divID].left += na.d.g.margin;
                        divs[divID].width -= (2 * na.d.g.margin);
                        if (na.d.s.visibleDivs.includes('#siteVideo')) divs[divID].top += na.d.g.margin;
                        //if (visibleDivs.includes('#siteDateTime')) {
                            divs[divID].top += (2 * na.d.g.margin );
                            divs[divID].height -= (2 * na.d.g.margin );
                        //}
                        if (na.d.s.visibleDivs.includes('#siteStatusbar')) {
                            divs[divID].height -= (na.d.g.margin );
                        }
                        break;
                    case '#siteTaskbar':
                        divs[divID].top -= na.d.g.margin;
                        //divs[divID].left += na.d.g.margin;
                        //divs[divID].width -= (2 * na.d.g.margin);
                        divs[divID].height = 'auto';
                        break;
                }
            }
                na.m.log (10010, fncn+' : calculated divs', false);




            for (var i=0; i<na.d.g.divs.length; i++) {
                var divID = na.d.g.divs[i], shown = false;
                for (var divID2 in divs) if (divID2==divID) shown = true;
                //if (shown) debugger;
                if (shown) $(divID).css({ display : 'block' });
                else $(divID).css({ display : 'none' });
            }

            var divsDone = [];


            // DIV position and dimensions calculations are done, now start to animate everything :
            na.d.s.masterCallbackIdx = 0;
            if (reset) na.d.s.animatingDivs = {};

            //debugger;

            if (reset)
            for (var masterCallbackIdx=0; masterCallbackIdx<section.order.length; masterCallbackIdx++) {
                let divID = section.order[masterCallbackIdx];
                na.d.s.animatingDivs[divID] = true;
            };

            /*
            var dp = $('.vividDialogPopup').not('#siteErrors');
            var dpa = 0;
            dp.each(function(idx,el) {
                if ($(el).css('display')!=='none') {
                    dpa++
                    $(el).stop().animate({
                        top : ( $(window).height() - $(el).height() ) / 2,
                        left : ( $(window).width() - $(el).width() ) / 2
                    });
                }
            });*/

            for (var masterCallbackIdx=0; masterCallbackIdx<section.order.length; masterCallbackIdx++) {
                na.m.log (10010, fncn+' : issuing animation calls for masterCallbackIdx='+masterCallbackIdx, false);
                let divID = section.order[masterCallbackIdx];
                var haveFiredAnimationsForDivAlready = false;
                for (var i=0; i < divsDone.length; i++) if (divsDone[i]==divID) haveFiredAnimationsForDivAlready = true;
                if (!haveFiredAnimationsForDivAlready) {
                    divsDone.push(divID);
                    /*na.m.waitForCondition ('ready to animate divID='+divID,
                        function () {
                            return na.d.s.masterCallbackIdx < masterCallbackIdx
                        },
                        function () {
                        */
                            // HIDE all <div> that needs to be hidden
                            var shown = false;
                            for (var divID2 in divs) if (divID==divID2 && divID2==divID2) { shown = true; break; }

                            na.m.log (15, 'na.c.desktop.goto (divID='+divID+', shown='+shown, false);


                            //if (divID=='#siteContent') debugger;
                            var
                            hasValidAvoidClause = false;
                            try {
                                var
                                avoidClause = $(divID).attr('avoid');
                                if (avoidClause) {
                                    avoidClause = JSON.parse(avoidClause);
                                    hasValidAvoidClause = true;
                                }
                            } catch (error) {
                                avoidClause = false;
                            }
                            if (avoidClause) {
                                for (var j=0; j < avoidClause.length; j++) {
                                    var divID2 = avoidClause[j];
                                    if (
                                        divs[divID]
                                        && divs[divID2]
                                        && divs[divID].left < divs[divID2].left
                                        && divs[divID].left + divs[divID].width > divs[divID2].left
                                    ) {
                                        var w1 = divs[divID2].left - divs[divID].left - na.d.g.margin;
                                        console.log ('t6543210:'+divID+':'+w1);
                                        divs[divID].width = w1;
                                    }
                                }
                            }

                            //if (divID!=='#siteContent') debugger;


                            if (!shown /*|| !visibleDivs.includes(divID)*/) {
                                var options = {
                                        queue : false,
                                        duration : na.d.g.animationSpeed,
                                        easing : 'swing',
                                        complete : function() {
                                            na.d.s.animatingDivs[divID] = false;
                                            na.d.masterCallback(callback, $(divID)[0], calculationResults, sectionIdx, section, i)
                                        }
                                };
                                if (na.d.s.animate) {
                                    $(divID).stop(true,true,false).animate(na.d.g.defaultPos[divID],options);
                                } else {
                                    na.d.s.animatingDivs[divID] = false;
                                    $(divID).stop(true,true,false).css(na.d.g.defaultPos[divID]);
                                }
                            } else {
                                // for mobile phones, use plain $(...).css() calls, for desktops, use $(...).animate() calls,
                                // and don't forget to call the callback functions of course
                                if (divID=='#siteContent') {
                                    if (na.d.s.animate) {
                                        $(divID).css ({
                                            display : 'flex'
                                        }).animate ({
                                            top : divs[divID].top,
                                            left : divs[divID].left,
                                            width : divs[divID].width,
                                            height : divs[divID].height,
                                            opacity : 1
                                        }, {
                                            queue : false,
                                            duration : na.d.g.animationSpeed,
                                            complete : function () {
                                                na.d.s.animatingDivs[divID] = false;
                                                na.d.masterCallback(callback, $(divID)[0], calculationResults, sectionIdx, section, i);
                                            }
                                        });
                                        if (na.site.settings.na3D)
                                        for (var id in na.site.settings.na3D) {
                                            var el = na.site.settings.na3D[id];
                                            $('canvas', el.p)
                                                .animate (
                                                    { width : $(el.p).width(), height : $(el.p).height() },
                                                {
                                                    queue : false,
                                                    duration : na.d.g.animationSpeed
                                                }
                                                ).attr('width', $(el.p).width())
                                                .attr('height', $(el.p).height());
                                            na.m.waitForCondition ('na.site.settings.na3D available', function() { return el && el.camera; }, function() {
                                                el.camera.aspect = $(el.p).width() / $(el.p).height();
                                                el.camera.updateProjectionMatrix();
                                                el.renderer.setSize  ($(el.p).width(), $(el.p).height());
                                            }, 100);
                                        };

                                    } else {
                                        let divID2 = divID;
                                        $(divID).stop(true,true,false).animate ({
                                            top : divs[divID].top,
                                            left : divs[divID].left,
                                            width : divs[divID].width,
                                            height : divs[divID].height,
                                            opacity : 1
                                        }, {
                                        queue : false,
                                            duration : na.d.g.animationSpeed,
                                            easing : 'swing',
                                            progress : function () {
                                                /*
                                                for (var i=0; i<na.c.desktop.settings.callbacksProgress.length; i++) {
                                                    var cb = na.c.desktop.settings.callbacksProgress[i].callback;
                                                    if (typeof cb=='function') cb ($(divID)[0]);
                                                }
                                                */
                                            },
                                            complete : function () {
                                                if (na.site.settings.na3D)
                                                for (var id in na.site.settings.na3D) {
                                                    var el = na.site.settings.na3D[id];
                                                    $('canvas', el.p)
                                                        .css ({ width : $(el.p).width(), height : $(el.p).height() })
                                                        .attr('width', $(el.p).width())
                                                        .attr('height', $(el.p).height());
                                                    el.camera.aspect = $(el.p).width() / $(el.p).height();
                                                    el.camera.updateProjectionMatrix();
                                                    el.renderer.setSize  ($(el.p).width(), $(el.p).height());
                                                };
                                                na.d.s.animatingDivs[divID] = false;
                                                na.d.masterCallback(callback, $(divID)[0], calculationResults, sectionIdx, section, i);
                                            }
                                        });
                                    }
                                } else if (!na.d.s.animate) {
                                    var props = {
                                        top : divs[divID].top,
                                        left : divs[divID].left,
                                        width : divs[divID].width,
                                        height : divs[divID].height,
                                        display : 'flex'
                                    };
                                    if (divID.substr(0,4)!=='#btn' || !na.m.userDevice.isPhone) props.opacity = 1;
                                    $(divID).css(props);
                                    na.d.s.animatingDivs[divID] = false;
                                    na.d.masterCallback(callback, $(divID)[0], calculationResults, sectionIdx, section, i);

                                } else {
                                    var props = {
                                        top : divs[divID].top,
                                        left : divs[divID].left,
                                        width : divs[divID].width,
                                        height : divs[divID].height
                                    }, options = {
                                        queue : false,
                                        duration : na.d.g.animationSpeed,
                                        easing : 'swing',
                                        progress : function () {
                                            /*
                                            for (var i=0; i<na.c.desktop.settings.callbacksProgress.length; i++) {
                                                var cb = na.c.desktop.settings.callbacksProgress[i].callback;
                                                if (typeof cb=='function') cb ($(divID)[0]);
                                            }*/
                                        },
                                        complete : function() {
                                            na.d.s.animatingDivs[divID] = false;
                                            na.d.masterCallback(callback, $(divID)[0], calculationResults, sectionIdx, section, i)
                                        }
                                    };
                                    if (divID.substr(0,4)!=='#btn' || !na.m.userDevice.isPhone) props.opacity = 1;
                                    $(divID).stop(true,true,false).animate (props, options);
                                }
                            }
                        //}, 10); // ready to animate next DIV wait time between steps (in milliseconds)
                    } else {
                        masterCallbackIdx++;

                    }
            }

        }
    },

    masterCallback : function (callbackFunction, div, calculationResults, sectionIdx, section, divOrderIdx) {
        var
        fncn = 'na.c.desktop.masterCallback()',
        eh = na.site.settings.eventHandlers;
        //na.m.log (15, 'na.c.desktop.masterCallback (divID='+div.id+')');
        if (eh) {
            for (var i=0; i<eh.length; i++) {
                for (var j in eh[i]) {
                    var
                    cb = eh[i][j],
                    ehSplit = j.split(':'),
                    component = ehSplit[0],
                    eventName = ehSplit[1];

                    if (component=='na.c.desktop' && eventName=='afterResize') cb(null, div);
                }
            }
        }

        var allCompleted = true;
        for (var i=0; i<na.d.s.visibleDivs.length; i++) {
            var did = na.d.s.visibleDivs[i];
            var ds = na.d.s.animatingDivs[did];
            if (ds) allCompleted = false;
        }
        //na.m.log (556, fncn + ' : na.c.desktop.settings.animatingDivs='+JSON.stringify(na.d.s.animatingDivs, null, 2), false);
        //debugger;
        //na.m.log (50, fncn + ' : allCompleted='+(allCompleted?'true':'false')+', na.m.HTMLidle()='+(na.m.HTMLidle()?'true':'false'), false);
        if (!allCompleted) {
            na.d.s.animating = true;
            return false;
        } else {
            na.d.s.animating = false;
        }


        // call desktop.registerCallback() callbackFunctions,
        //  same as jQuery.animate({progress:callbackFunction});
        for (var i=0; i<na.d.s.callbacks.length; i++) {
            var cb = na.d.s.callbacks[i];
            if (cb.divID=='#'+div.id && typeof cb.callback=='function') cb.callback(cb, div, calculationResults, sectionIdx, section, divOrderIdx);
        };


        // and now call the na.c.desktop equivalent of jQuery.animate({complete:callbackFunction})
        //  for all #div.id, AFTER allCompleted==true and na.m.HTMLidle()===true
        na.m.waitForCondition('na.c.desktop.masterCallback() : #'+div.id+' : na.m.desktopIdle()?',
            na.m.desktopIdle, function () {
                na.desktop.masterCallback_do (div, calculationResults, sectionIdx, section, divOrderIdx);
            },
        50);

        if (allCompleted) na.d.s.masterCallbacks = [];
        /*
        na.m.waitForCondition('na.c.desktop.masterCallback() : na.m.desktopIdle() && all masterCallbacks called?', function () {
            var allDone = allCompleted;
            for (var i=0; i < na.d.s.masterCallbacks.length; i++) {
                var cf = na.d.s.masterCallbacks[i];
                for (var divID in calculationResults.calculationResults_visible) {
                    //debugger;
                    if ( divID == 'mode' || divID == 'order') continue;
                    if (
                        typeof cf.masterCallbacksCalled=='object'
                        && !(divID in cf.masterCallbacksCalled)
                    ) allDone = false;
                }
            }
            //debugger;
            return allDone;
        }, function () {
            na.d.s.masterCallbacks = [];
        }, 50);
        */
        na.d.s.masterCallbackIdx++;
    },

    masterCallback_do : function (div, calculationResults, sectionIdx, section, divOrderIdx) {
        //na.m.log (15, 'na.c.desktop.masterCallback_do (divID='+div.id+')',false);
        for (var i=0; i < na.d.s.masterCallbacks.length; i++) {
            var cf = na.d.s.masterCallbacks[i];
            if (!cf) debugger;
            if (!cf.masterCallbacksCalled) {
                cf.masterCallbacksCalled = {};
            }
            //debugger;
            if (
                '#'+div.id in calculationResults.calculationResults_visible
                && !('#'+div.id in cf.masterCallbacksCalled)
            ) {
                cf (div, calculationResults, sectionIdx, section, divOrderIdx);
                cf.masterCallbacksCalled['#'+div.id] = true;
            }
        }
    },

    registerProgress : function (name, func) {
        var entry = { name : name, callback : func };
        na.d.deleteProgress(name);
        na.d.s.callbacksProgress.push (entry); // na.d.s = na.d.sktop.settings
    },

    deleteProgress : function (name) {
        for (var i=0; i<na.d.s.callbacksProgress.length; i++) {
            if (na.d.s.callbacksProgress[i].name == name) { na.d.s.callbacksProgress.splice(i,1); i--; if (i==na.d.s.callbacksProgress.length-1) break;}
        }
    },

    registerCallback : function (name, divID, func) {
        var entry = { name : name, divID : divID, callback : func };
        na.d.s.callbacks.push (entry); // na.d.s = na.d.sktop.settings
    },

    deleteCallback : function (name) {
        for (var i=0; i<na.d.s.callbacks.length; i++) {
            if (na.d.s.callbacks[i].name == name) { na.d.s.callbacks.splice(i,1); i--; if (i==na.d.s.callbacks.length-1) break;}
        }
    },



    parseOptions : function (t, desktopDefinition) {
        var dd = $.extend({}, desktopDefinition);

        var p = { t : t, ld2 : {}, idxPath : '', idxPath2 : '/0' };
        na.m.walkArray (dd, dd, null, t.parseOptions_walkValue, false, p);

        var
        dd2 = t.arrayUnique ([].concat(dd )),
        dd3 = [{}];
        for (var i in dd2[0]) {
            dd3[0] = Object.assign(dd3[0], dd2[0][i]);
        }

        return dd3;
    },

    parseOptions_walkValue : function (cd) {
        if (typeof cd.v == 'object')
            for (var k1 in cd.v) {
                if (k1=='conditions') {
                    var vResult = cd.params.t.parseOptions_conditions(cd);
                    if (vResult) cd.at[cd.k] = cd.v.conditionsMet; else cd.at[cd.k] = cd.v.conditionsFailed;
                    return true;
                }
            }
    },

    parseOptions_conditions : function (cd) {
        for (var i=0; i < cd.v.conditions.length; i++) {
            var clauseResult = cd.params.t.parseOptions_clauseResult (cd, i);
            if (!clauseResult) return false;
        }
        return true;
    },

    parseOptions_clauseResult : function (cd, i) {
        if (typeof cd.v.conditions[i].jsVar=='string') {
            if (!cd.v.conditions[i].jsVar.match(/[\w\.]+/)) {
                return false;
            }
            if (
                typeof cd.v.conditions[i].jsVarIncludes=='string'
                && eval(cd.v.conditions[i].jsVar).includes(cd.v.conditions[i].jsVarIncludes)
            ) {
                return true;
            }
        }

        if (typeof cd.v.conditions[i].htmlSelector=='string'
            && typeof cd.v.conditions[i].cssPropertyName=='string'
            && cd.v.conditions[i].isNotExactly
            && $(cd.v.conditions[i].htmlSelector).css(cd.v.conditions[i].cssPropertyName) !== cd.v.conditions[i].isNotExactly
        ) return true;

        return false;
    },

     arrayUnique : function (array) {
        var a = array.concat();
        for(var i=0; i<a.length; ++i) {
            for(var j=i+1; j<a.length; ++j) {
                if(
                    JSON.stringify(a[i]) === JSON.stringify(a[j])
                    || JSON.stringify(a[j]) === '{}'
                )
                    a.splice(j--, 1);
            }
        }

        return a;
    }
}
