na.te = na.themeEditor = {
    settings : { 
        current : { 
            firstRun : true, 
            forDialogID : 'siteContent',
            //selectedButtonID : 'btnSelectBackgroundColor', // OBSOLETED
            selectedSetting : 'backgroundColor',
            selectedThemeName : na.site.globals.themeName
        } 
    }, 
    onload : function (forDialogID) {
        var
        fncn = 'na.themeEditor.onload("'+forDialogID+'")',
        date = new Date(),
        timeInMilliseconds = date.getTime();
        
        na.m.settings.startTime = timeInMilliseconds;
        
        na.te.s.c.forDialogID = forDialogID;
        $('#specificityForDiv').html ('#'+forDialogID);
        
        $('.themeEditorComponent').css({display:'none'});
        na.te.makeThemesList( na.te.s.c.selectedThemeName );
        for (var appName in na.site.globals.app) break;
        $('#span_cb_app').html ('<b>App : </b>'+appName);
        
        var 
        url = '/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS/blogEditor/ajax_getTreeNodes.php',
        ac = {
            type : 'GET',
            url : url,
            success : function (data, ts, xhr) {
                let dat = JSON.parse(data);
                na.te.s.c.db = dat;
                
                var lastFolder = null;
                
                if (na.te.s.c.backgroundFolder) {
                    var 
                    x = na.te.s.c.backgroundFolder.split('/'),
                    lastFolder = null;
                    
                    for (var i=x.length-1; i>=0; i--) {
                        for (var j=0; j<dat.length; j++) {
                            if (dat[j].text == x[i]) { 
                                if (!lastFolder) {
                                    lastFolder = dat[j];
                                    var path = na.te.currentPath (lastFolder);
                                    if (path == na.te.s.c.backgroundFolder) break;
                                }
                            }
                        }
                    }
                };
                    
                if ($.jstree) $.jstree.defaults.core.error = function (a,b,c,d) {
                    //debugger;
                };
                $('#themeEditor_jsTree').css({
                    height : $('#siteToolbarLeft .vividDialogContent').height() - $('#jsTree_navBar').height()
                }).jstree('destroy').jstree({
                    core : {
                        data : dat,
                        check_callback : true,
                        multiple : false
                    },
                    types : {
                        "naSystemFolder" : {
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naSystemFolder.png",
                            "valid_children" : []
                        },
                        "naUserRootFolder" : {
                            "max_depth" : 14,
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naUserRootFolder.png",
                            "valid_children" : ["naFolder", "naMediaAlbum", "naDocument"]
                        },
                        "naGroupRootFolder" : {
                            "max_depth" : 14,
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naGroupRootFolder.png",
                            "valid_children" : ["naFolder", "naMediaAlbum", "naDocument"]
                        },
                        "naFolder" : {
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naFolder.png",
                            "valid_children" : ["naFolder", "naMediaFolder", "naDocument"]
                        },
                        "naDialog" : {
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naSettings.png",
                            "valid_children" : []
                        },
                        "naSettings" : {
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naSettings.png",
                            "valid_children" : []
                        },
                        "naTheme" : {
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naVividThemes.png",
                            "valid_children" : []
                        },
                        "naVividThemes" : {
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naVividThemes.png",
                            "valid_children" : []
                        },
                        "naMediaFolder" : {
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naMediaAlbum.png",
                            "valid_children" : [ "naMediaFolder" ]
                        },
                        "naDocument" : {
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naDocument.png",
                            "valid_children" : []
                        },
                        "saApp" : {
                            "icon" : "/NicerAppWebOS/siteMedia/na.view.tree.naApp.png",
                            "valid_children" : []
                        }
                    },
                    "plugins" : [
                        "contextmenu", "dnd", "search",
                        "state", "types", "wholerow", "multiselect"
                    ]
                }).on('changed.jstree', function (e, data) {
                    if (
                        rec
                        && na.blog
                        && na.te.s.c.selectedTreeNode
                        && na.te.s.c.selectedTreeNode.type=='naDocument'
                    ) na.blog.saveEditorContent(na.blog.settings.current.selectedTreeNode);
                    
                    for (var i=0; i<data.selected.length; i++) {
                        var 
                        d = data.selected[i], 
                        rec = data.instance.get_node(d),
                        btn = na.site.settings.buttons['#btnSelectBackgroundImage'];
                        
                        $('#documentTitle').val(rec.original.text);
                        na.te.s.c.selectedTreeNode = rec;
                        if (rec.original.type=='naDocument') {
                            if (btn) btn.disable();
                        } else if (rec.original.type=='naMediaFolder') {
                            if (btn) btn.enable();
                            var
                            path = na.te.currentPath(rec),
                            path = path.replace(/ /g, '%20'),
                            src = '/NicerAppWebOS/logic.userInterface/photoAlbum/4.0.0/index.php?basePath='+path,
                            el = $('#themeEditor_photoAlbum')[0];
                            el.onload = setTimeout(na.te.onresize,250);
                            el.src = src;
                        } else {
                            if (btn) btn.disable();
                        }

                    };
                });
                
                if (lastFolder) setTimeout (function() {
                    $('#themeEditor_jsTree').jstree('deselect_all').jstree('select_node', lastFolder.id);
                }, 200);
                
                $('#siteToolbarLeft .lds-facebook').fadeOut('slow');
            },
            error : function (xhr, textStatus, errorThrown) {
                na.site.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
            }                
        };
        $.ajax(ac);

        var 
        div = $('#'+na.te.s.c.forDialogID),
        bg = $('#'+na.te.s.c.forDialogID+' > .vdBackground')[0],
        rgbaRegEx = /rgba\(\d{1,3}\,\s*\d{1,3}\,\s*\d{1,3}\,\s*([\d.]+)\).*/,
        rgbRegEx = /rgb\(\d{1,3}\,\s*\d{1,3}\,\s*\d{1,3}\).*/,
        scaleRegEx = /(\d+)px\s(\d+)px/,
        bgRegEx = /.*\/(Groups.*?)"\)/,
        test1a = $(bg).css('background').match(rgbaRegEx),
        test1b = $(bg).css('backgroundColor').match(rgbaRegEx)
        test2a = $(div).css('border').match(rgbaRegEx),
        test2b = $(div).css('borderTopColor').match(rgbaRegEx),
        test2c = $(div).css('border').match(rgbRegEx),
        test2d = $(div).css('borderTopColor').match(rgbRegEx),
        test3a = $(bg).css('backgroundSize').match(scaleRegEx),
        c = test1a ? $(bg).css('background') : test1b ? $(bg).css('backgroundColor') : 'rgba(0,0,0,0.5)',
        c2 = (
            test2a 
            ? $(div).css('border')
            : test2b
                ? $(div).css('borderTopColor')
                : test2c
                    ? $(div).css('border')  
                    : test2d
                        ? $(div).css('borderTopColor')
                        : 'black'
        ),
        c3 = $(bg).css('backgroundImage'),
        c3a = c3.match(bgRegEx);
        
        if (c3a) {
            var
            c4a = c3a[1].lastIndexOf('/'),
            c4b = c3a[1].substr(0, c4a);
            
            na.te.s.c.backgroundFolder = c4b;        
        };
        
        na.te.s.c.borderColor = c2;

        var bgSrc = $(bg).css('backgroundImage');
        bgSrc = bgSrc.replace('url("', '');
        bgSrc = bgSrc.replace('")', '');
        bgSrc = bgSrc.replace("url'", '');
        bgSrc = bgSrc.replace("')", '');
        var bgEl = document.createElement('img');
        bgEl.onload = function () {
            var
            bg = $('#'+na.te.s.c.forDialogID+' > .vdBackground')[0],
            scaleRegEx = /(\d+)px\s(\d+)px/,
            test3a = $(bg).css('backgroundSize').match(scaleRegEx);
            
            if (test3a) {
                na.te.s.c.scaleX = (parseInt(test3a[1]) * 100) / bgEl.naturalWidth;
                na.te.s.c.scaleY = (parseInt(test3a[2]) * 100) / bgEl.naturalHeight;        
            } else {
                na.te.s.c.scaleX = 100; 
                na.te.s.c.scaleY = 100;
            };
            $('#themeEditor_photoScaleX').val(na.te.s.c.scaleX);
            $('#themeEditor_photoScaleY').val(na.te.s.c.scaleY);
        };
        bgEl.src = bgSrc;
        
        
        $('#siteToolbarThemeEditor').css({ display : 'flex', flexDirection : 'row', flexWrap : 'wrap' });
        
        var x = $('#colorpicker').css('display'), y = 'abc';
        //debugger;
        $('#colorpicker').css({display:'block'}).spectrum ({
            color:c, 
            type:'flat',
            showAlpha : true,
            showPalette : false,
            clickoutFiresChange : false, 
            change : function (color) {
                debugger;
                if (typeof color=='object') color = 'rgba('+color._r+', '+color._g+', '+color._b+', '+color._a+')';
                var bg = $('#'+na.te.s.c.forDialogID+' > .vdBackground');
                $(bg).css({ background : color, opacity : 1 });
                na.site.saveTheme();                        
            }});
        //if (na.te.s.c.selectedButtonID!=='btnSelectBackgroundColor') $('#colorpicker').next().css({display:x});
        var x = $('#borderColorpicker').css('display');
        $('#borderColorpicker').css({display:'block'}).spectrum ({
            color:c2, 
            type: "flat", 
            showAlpha : true,
            showPalette : false, 
            clickoutFiresChange : false, 
            change : na.te.borderSettingsSelected
        });
        //if (na.te.s.c.selectedButtonID!=='btnSelectBorderSettings') $('#borderColorpicker').next().css({display:x});
        
        //if ($(window).width() < na.site.globals.reallySmallDeviceWidth) $('.sp-container').css({width:$(window).width()-35});
        //$('.sp-container').addClass('themeEditorComponent').css({position:'absolute'});

        na.te.s.c.borderColor = c2;

        /*
        var 
        div = $('#'+na.te.s.c.forDialogID),
        rgbaRegEx = /(rgba\(\d{1,3}\,\s*\d{1,3}\,\s*\d{1,3}\,\s*[\d.]+\)).* /,
        rgbRegEx = /(rgb\(\d{1,3}\,\s*\d{1,3}\,\s*\d{1,3}\)).* /,
        test1 = $(div).css('textShadow').match (rgbaRegEx),
        test2 = $(div).css('textShadow').match (rgbRegEx);
        if (test1) {
            var textShadowColor = test1[1];
        } else if (test2) {
            var textShadowColor = test2[1];
        } else {
            var textShadowColor = 'black';
        };
        na.te.s.c.textShadowColor = textShadowColor;
        */
        
        var
        p1 = $(div).find('td').css('color'),
        p2 = $(div).css('color');
        if (p1) {
            var textColor = p1
        } else if (p2) {
            var textColor = p2;
        } else {
            var textColor = 'white';
        };
        na.te.s.c.textColor = textColor;
        if (!na.te.s.c.selectedTextShadow) {
            na.te.s.c.selectedTextShadow = $('#textShadow_0')[0];
            $('#textShadow_0').css({ textShadow : $(div).css('textShadow') });
        }
        setTimeout (function() {
            var x = $('#'+forDialogID+' .vdBackground').css('background');
            //na.m.log (300, 'x='+x);
            $('.mediaThumb', $('#themeEditor_photoAlbum')[0].contentWindow.document).each(function(idx,el) {
                //na.m.log (300, 'el.src='+el.src.replace('thumbs/', ''));
                if (x && x.indexOf(el.src.replace('thumbs/', ''))!==-1) {
                    var scale = $('#'+forDialogID+' .vdBackground').css('backgroundSize').match(/\d+/);
                    if (scale) na.te.s.c.scale = scale[0];
                    na.te.s.c.selectedImage = el;
                    na.m.log (300, 'na.te.s.c.selectedImage = '+el.src);
                }
            });
        }, 750);
        

        var s = JSON.parse( $('#specificity').find('option:selected')[0].value );
        na.te.s.c.specificity = s;
        if (!s.role && !s.user) {
            na.site.settings.buttons['#btnDeleteSpecificity'].disable();
        } else {
            na.site.settings.buttons['#btnDeleteSpecificity'].enable();
        }
        
        $('#btnViewResult .vividButton_icon_borderCSS_50x50').css({ boxShadow : '0px 0px 0px 0px rgba(0,0,0,0)' });
        
        $('.vividButton, .vividButton_icon_50x50', $('#siteToolbarThemeEditor')[0]).each(function(idx,el){
            na.site.settings.buttons['#'+el.id] = new naVividButton(el);
        });

        var tabPage = na.te.s.c.selectedSetting;
        na.te.whichSettingSelected(tabPage);

        var theme = na.site.globals.themes[ $('#themes').val() ];
        na.te.s.c.selectedBoxShadowID = (theme && theme.selectedBoxShadowID) || 'boxShadow_0';
        na.te.s.c.selectedTextShadowID = (theme && theme.selectedTextShadowID) || 'textShadow_0';
        //if (!na.te.s.c.boxSettings) na.te.s.c.boxSettings = $(na.te.s.c.selectedBoxShadowID)[0];
        
        //setTimeout (na.te.selectBorderSettings, 100);

        setTimeout (na.te.onresize, 200);
    },
    
    hide : function (event) {
        if (!$(this).is('.disabled')) { 
            if (!na.desktop.settings.visibleDivs.includes('#siteContent')) na.desktop.settings.visibleDivs.push('#siteContent');
            
            na.desktop.settings.visibleDivs.remove('#siteToolbarThemeEditor'); 
            na.site.settings.activeDivs=['#siteContent']; 
            na.desktop.resize();
        }        
    },
    
    onresize : function () { 
        var 
        t = this,
        display = $('#themeEditor_photoAlbum').css('display'),
        doc = $('#themeEditor_photoAlbum')[0].contentWindow.document;
        $('.vividScrollpane div', doc).css({width:110,height:130});
        $('.vividScrollpane div img', doc).css({width:100,height:100}).each(function(idx,el){
            el.onclick = function () { na.te.imageSelected(el); };
        });
        /*$('#themeEditor_photoOpacity')[0].oninput = function () {
            if (na.te.s.c.selectedImage) na.te.imageSelected(na.te.s.c.selectedImage);
        };
        $('#themeEditor_photoScale')[0].oninput = function () {
            na.te.s.c.scale = parseInt($('#themeEditor_photoScale').val());
            if (na.te.s.c.selectedImage) na.te.imageSelected(na.te.s.c.selectedImage);
        };*/
        $('#themeEditor_jsTree').css({
            width : $('#siteToolbarThemeEditor .vividDialogContent').width(),
            height : 
                $('#siteToolbarThemeEditor .vividDialogContent').height() 
                - $('#themeEditor_jsTree').position().top + 10
        });
        
        $('.themeEditor_colorPicker').next().css ({ width : 230 });
        //$('#siteToolbarThemeEditor label', t.el).not('.specificityCB').css ({ float : 'left' });
        
        $('.themeEditorComponent').css({
            width : 'calc(100% - 20px)',
            height : 
                $('#siteToolbarThemeEditor .vividDialogContent').height() 
                - $('.nate_dialogTitle').height() - 10
                - $('#specificitySettings').height() - 8
                - 18
        });
        /*
        $('.boxSettings_label_containerDiv, .textSettings_label_containerDiv, .textShadowSettings_label_containerDiv').css ({
            width : '60px'
        });
        */
        $('.boxSettings_input_containerDiv, .textSettings_input_containerDiv, .textShadowSettings_input_containerDiv').css ({
            width : 'calc(100% - 50px - 20px)',
        });
            
        
        $('#themeEditor_photoAlbum').css({
            display : 'flex',
            width : $('#siteToolbarThemeEditor .vividDialogContent').width()-10,
            height : 
                $('#siteToolbarThemeEditor .vividDialogContent').height() 
                - $('#specificitySettings').height() - 250,
            top : 'auto'
        }).css({display:display});
    },
    
    onclick : function (el) {
        if (!el) return false;
        if (na.te.s.c.selectedButtonID) {
            var b = na.site.settings.buttons['#'+na.te.s.c.selectedButtonID];
            if (b) b.deselect();
        }
        
        var b = na.site.settings.buttons['#'+el.id];
        if (b) {
            na.te.s.c.selectedButtonID = el.id;
            b.select();
            $('#'+el.id).click(event);
        }
    },
    
    whichSettingSelected : function (event) {
        if (typeof event=='object') whichSetting = $(event.currentTarget).val(); else whichSetting = event;
        switch (whichSetting) {
            case 'border' : na.themeEditor.selectBorderSettings(event); break;
            case 'boxShadow' : na.themeEditor.selectBoxShadowSettings(event); break;
            case 'backgroundColor' : na.themeEditor.selectBackground_color(event); break;
            case 'backgroundFolder' : na.themeEditor.selectBackground_folder(event); break;
            case 'backgroundImage' : na.themeEditor.selectBackground_image(event); break;
            case 'text' : na.themeEditor.selectTextSettings(event); break;
            case 'textShadow' : na.themeEditor.selectTextShadowSettings(false); break;
            //case 'scrollbars' : break;
        };
    },
    
    currentPath : function (node) {
        var me = na.te, s = me.settings, c = s.current;
        
        var
        path = [ ],
        n = node;
        while (n.parent!=='#') {
            path.push(n.text);
            var n2 = n;
            for (var idx in c.db) {
                var st = c.db[idx];
                if (st.id && st.id == n.parent) {
                    n = st;
                    break;
                }
            }
            if (n2 === n) {
                console.log ('ERROR : na.tree.currentPath(iid, ) : n2===n');
                debugger;
                break;
            }
        };
        path.push (n.text);
        path = path.reverse().join('/');
        return path;//.replace('Users/','');
        //return path; // only paths being used right now already include the username in that path (from the tree node under 'Users')
    },
    
    specificitySelected : function (event) {
        var opt = $(event.currentTarget).find('option:selected');
        if (opt[0]) {
            var s = JSON.parse( opt[0].value );
            na.site.globals.themeSpecificityName = opt[0].innerHTML;
            na.te.s.c.specificity = s;
            if (!s.role && !s.user) {
                na.site.settings.buttons['#btnDeleteSpecificity'].disable();
            } else {
                na.site.settings.buttons['#btnDeleteSpecificity'].enable();
            }
            
            na.site.loadTheme (function () { // **POSSIBLY** NOT NEEDED
                var btn = $('#'+na.te.s.c.selectedButtonID)[0];
                if (btn) na.te.onclick(btn, false);
            });
            
            na.site.setSiteLoginLogout();
        }
    },
    deleteSpecificity : function (event, callback) {
        var
        fncn = 'na.themeEditor.deleteSpecificity(event, callback)',
        s = na.te.s.c.specificity,
        themeData = {};
        
        if (s.url) themeData.url = s.url;
        if (s.role) themeData.role = s.role;
        if (s.user) themeData.user = s.user;

        var
        url = '/NicerAppWebOS/logic.AJAX/ajax_delete_vividDialog_settings.php',
        ac = {
            type : 'POST',
            url : url,
            data : themeData,
            success : function (data, ts, xhr) {
                var 
                state = History.getState(),
                url = state.url.replace(document.location.origin,'').replace('/apps/', ''),
                url2 = url.replace(document.location.origin,'').replace(document.location.host,'').replace('/apps/', '');
                
                var ac2 = {
                    type : 'GET',
                    url : '/NicerAppWebOS/logic.AJAX/ajax_get_pageSpecificSettings.php',
                    data : {
                        apps : url2
                    },
                    success : function (data, ts, xhr) {
                        $('#cssPageSpecific, #jsPageSpecific').remove();
                        $('head').append(data);
                        setTimeout(function () {
                            na.site.loadTheme (function () {
                                var 
                                btn = $('#'+na.te.s.c.selectedButtonID)[0],
                                evt = { currentTarget : $('#specificity')[0] };
                                
                                na.te.specificitySelected(evt);
                                //na.te.onclick(btn, false);
                                var tabPage = na.te.s.c.selectedSetting;
                                na.te.whichSettingSelected(tabPage);
                                
                                if (typeof callback=='function') callback (themeData, data);
                            }); 
                        }, 250);
                    },
                    failure : function (xhr, ajaxOptions, thrownError) {
                    }
                };
                //setTimeout (function() { 
                    $.ajax(ac2);
                //}, 250);
                
            },
            error : function (xhr, textStatus, errorThrown) {
                na.site.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
            }                
        };
        $.ajax(ac);
    },
    
    cbSelected : function (event) {
        $('input.specificityCB').each(function(idx,el){ el.checked = el === event.currentTarget });
        var theme = $('#themes').val();
        na.site.loadTheme(function() {
            var btn = $('#'+na.te.s.c.selectedButtonID)[0];
            if (btn) na.te.onclick(btn, false);
        }, theme);
    },
    
    makeThemesList : function (themeName) {
        var 
        fncn = 'na.themeEditor.makeThemesList("'+themeName+'")',
        url = '/NicerAppWebOS/logic.AJAX/ajax_getThemesList.php',
        ac = {
            type : 'GET',
            url : url,
            success : function (data, ts, xhr) {
                $('#themes').html(data);
                $('#themeChange_themeName').html(data);
                var t = $('#themes')[0];
                for (var i=0; i<t.options.length; i++) {
                    if ((!themeName || themeName=='default') && t.options[i].value==na.site.globals.themeName) { t.options[i].selected = true; na.te.s.c.selectedTheme = t.options[i]; break; }
                    if (themeName && t.options[i].value==themeName) { t.options[i].selected = true; na.te.s.c.selectedTheme = t.options[i]; break; }
                }

                na.te.s.c.selectedThemeName = themeName || na.site.globals.themeName;
                $('#theme_'+i).html (na.te.s.c.selectedThemeName);
                
                na.site.setSiteLoginLogout();
            },
            error : function (xhr, textStatus, errorThrown) {
                na.site.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
            }                
        };
        $.ajax(ac);
    },    
    themeSelected : function (event) {
        var 
        themes = $('#themes')[0],
        theme = $('#themes').val();
        
        for (var i=0; i<themes.options.length; i++) {
            var opt = themes.options[i];
            if (opt.innerHTML === theme) var themeNameID = opt.id;
        };
        
        $('#themeName').val(theme);
        na.site.saveTheme(function() {
            na.te.s.c.selectedTheme = $('#'+themeNameID)[0];
            na.te.s.c.selectedThemeName = theme;
            $('#themes').val(theme);

            na.site.loadTheme(function() {
                var btn = $('#'+na.te.s.c.selectedButtonID)[0];
                if (btn) na.te.onclick(btn, false);
            }, theme);
        },$('#'+na.te.s.c.selectedTheme.id).html());
    },
    deleteTheme : function (event) {
        var
        fncn = 'na.themeEditor.deleteTheme(event)',
        url = '/NicerAppWebOS/logic.AJAX/ajax_database_deleteAllThemes_byName.php',
        themeName = $('.themeItem.onfocus')[0].value,
        ajaxCmd = {
            type : 'POST',
            url : url,
            data : {
                themeName : themeName
            },
            success : function (data, textStatus, xhr) {
                if (data == 'status : Success.') {
                    $('#themes option').each(function(idx,optEl){
                        if ($(optEl).val() === themeName) $(optEl).remove();
                    });
                    $('.themeItem').each(function(idx,inputEl){
                        if ($(inputEl).val() === themeName) $(inputEl).parent().remove();
                    });
                } else na.site.fail(fncn+' : '+url+' : '+data, xhr, textStatus, null);
            },
            error : function (xhr, textStatus, errorThrown) {
                na.site.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
            }                
        };
        $.ajax(ajaxCmd);            
        
    },
    themeNameSelected : function (themeNameID) {
        na.site.saveTheme (function() {
            na.te.s.c.selectedTheme = $('#'+themeNameID)[0];
            na.te.s.c.selectedThemeName = $(na.te.s.c.selectedTheme).val();
            
            $('.themeItem').removeClass('onfocus');
            setTimeout(function() {
                $('.themeItem').each(function(idx,ti) {
                    if ($(ti).val()==na.te.s.c.selectedThemeName) $(ti).addClass('onfocus');
                });

                na.site.loadTheme(function() {
                    var btn = $('#'+na.te.s.c.selectedButtonID)[0];
                    if (btn) na.te.onclick(btn, false);
                }, na.te.s.c.selectedThemeName);
            }, 500);
        
        }, na.te.s.c.selectedThemeName);
    },
    themeNameChanged : function (themeIdx, themeNameID) {
        var
        oldThemeName = null,
        newThemeName = $('#'+themeNameID).val();
        
        $('#themes option').each(function(idx,optEl) {
            if ($(optEl)[0].id=='option_'+themeNameID) oldThemeName=$(optEl).val();
        });
        
        var
        url = '/NicerAppWebOS/logic.AJAX/ajax_change_themeName.php',
        ajaxCmd = {
            type : 'POST',
            url : url,
            data : {
                oldThemeName : oldThemeName,
                newThemeName : newThemeName
            },
            success : function (data, ts, xhr) {
                if (data == 'status : Success.') {
                    $('#themes option').each(function(idx,optEl){
                        if (parseInt(idx) === parseInt(themeIdx)) $(optEl).val(newThemeName).html(newThemeName);
                    })
                };                    
            },
            error : function (xhr, textStatus, errorThrown) {
                na.site.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
            }                
        };
        $.ajax(ajaxCmd);            
    },
    setPermissionsForTheme : function (event) {
        $('.themeEditorComponent').not('#themePermissions').fadeOut('fast');
        $('.themeEditor_colorPicker').next().fadeOut('fast');
        $('#themePermissions').fadeIn('fast', 'swing', function () {
            na.te.s.c.oldThemeNames = [];
            $('.themeItem').remove();
            var 
            t = $('#themes')[0],
            html = '';
            for (var i=0; i<t.options.length; i++) {
                html += '<div id="theme_'+i+'_div"><input id="theme_'+i+'" class="themeItem" type="text" onclick="na.te.themeNameSelected(\'theme_'+i+'\')" onchange="na.te.themeNameChanged('+i+', \'theme_'+i+'\')" value="'+t.options[i].text+'"></div>';
                if (t.options[i].selected) $('#themeName').val(t.options[i].text);
                na.te.s.c.oldThemeNames.push (t.options[i].text);
            }
            $('#themePermissionsControls').append(html);
        });        
    },
    addTheme : function (event) {
        var 
        opt = document.createElement('option'),
        i = $('#themes')[0].options.length;
        
        opt.id = 'option_theme_'+i;
        opt.text = 'new theme';
        opt.selected = true;
        
        $('#themes').append(opt);
        na.te.s.c.oldThemeNames.push (opt.text);
        
        
        var html = '<div id="theme_'+i+'_div"><input id="theme_'+i+'" class="themeItem" type="text" onclick="na.te.themeNameSelected(\'theme_'+i+'\')" onchange="na.te.themeNameChanged('+i+', \'theme_'+i+'\')" value="'+opt.text+'"></div>';
        $('#themePermissionsControls').append(html);
        
        var evt = { currentTarget : opt };
        na.te.themeSelected (evt);
    },
    deleteCurrentTheme_bySpecificity : function (removeFromThemesList, callback) {
        var
        fncn = 'na.themeEditor.deleteTheme(removeFromThemesList, callback)';
        /*
        var opts = $('#themes')[0].options;
        for (var i=0; i<opts.length; i++) {
            if (opts[i].id === na.te.s.c.selectedTheme.id) break;
        }
        if (i < opts.length) $(opts[i]).remove();
        if (removeFromThemesList) {
            $('#theme_'+i).slideUp('normal', function() {
                $('#theme'+i).remove();
            });
        }*/

        
        var
        s = na.te.s.c.specificity,
        themeData = {   
            theme : na.te.s.c.selectedThemeName
        };
        if (s.app) themeData.app = s.app;
        if (s.url) themeData.url = s.url;
        if (s.role) themeData.role = s.role;
        if (s.user) themeData.user = s.user;
        
        var
        url = '/NicerAppWebOS/logic.AJAX/ajax_delete_vividDialog_settings.php',
        ac = {
            type : 'POST',
            url : url,
            data : themeData,
            success : function (data, ts, xhr) {
                if (typeof callback=='function') callback (themeData, data);
            },
            error : function (xhr, textStatus, errorThrown) {
                na.site.ajaxFail(fncn, url, xhr, textStatus, errorThrown);
            }                
        };
        $.ajax(ac);
    },
    onchange_themeName : function (event) {
        var 
        el = event.currentTarget,
        newName = $(el).val();
        
        na.te.deleteTheme(false, function() {
            na.site.saveTheme (function(themeData,data) {
                na.te.makeThemesList(newName);
            }, newName);
        });
    },
    onchange_applicationRange : function (event) {
        var 
        el = event.currentTarget,
        elVal = $(el).val();
        
        debugger;
    },
    
    cssExtract : function (elID) {
        var 
        $el = $('#'+elID),
        bs = $el.css('boxShadow').split(', rgb'),
        ts = $el.css('textShadow').split(', rgb'),
        b = $el.css('border');
        
        //console.log ('#'+el.id+'.boxShadow='+$(el).css('boxShadow'));
        
        // NOTE (for beginners) : re1a through re2b are regular expressions. you can test your regexs at https://regex101.com/
        var 
        re1a = /^rgba\((\d+),\s*(\d+),\s*(\d+),\s*([\d\.]+)\)\s+(\d+px)\s+(\d+px)\s+(\d+px)\s+(\d+px)\s*(\w+)*,?.*$/,
        re1b = /^rgb\((\d+),\s*(\d+),\s*(\d+)\)\s+(\d+px)\s+(\d+px)\s+(\d+px)\s*(\w+)?,?.*$/,
        re2a = /^(\d+)px\s*(\w+)\s*rgba\((\d+),\s*(\d+),\s+(\d+),\s+(\d+)\)$/,
        re2b = /^(\d+)px\s*(\w+)\s*rgb\((\d+),\s*(\d+),\s+(\d+)\)$/,
        re3a = /^rgba\((\d+),\s*(\d+),\s*(\d+),\s*([\d\.]+)\)\s+(\d+px)\s+(\d+px)\s+(\d+px)\s*(\w+)*,?.*$/,
        re3b = /^rgb\((\d+),\s*(\d+),\s*(\d+)\)\s+(\d+px)\s+(\d+px)\s*(\w+)?,?.*$/,
        m2a = typeof b !== 'string' || b==='' ? '' : b.match(re2a),
        m2b = typeof b !== 'string' || b==='' ? '' : b.match(re2b),
        boxShadow = [],
        boxShadowColor = [],
        boxShadowSliders = [],
        textShadow = [],
        textShadowColor = [],
        textShadowSliders = [],
        r = {};
        
        if (typeof $el.css('boxShadow')=='string' && $el.css('boxShadow')!=='') {
            for (var j=0; j < bs.length; j++) {
                if (j > 0) bs[j] = 'rgb'+bs[j];
                //console.log (bs[j]);
                var m1 = typeof bs[j] !== 'string' || bs[j]==='' 
                    ? bs[j] 
                    : bs[j].match(re1a) 
                        ? bs[j].match(re1a) 
                        : bs[j].match(re1b);
                    
                if (typeof m1==='string') sliders.push('ERROR - '+bs[j]); 
                else if (m1[8]) boxShadowSliders.push([ 
                    parseInt(m1[5].replace('px','')),
                    parseInt(m1[6].replace('px','')),
                    parseInt(m1[7].replace('px','')),
                    parseInt(m1[8].replace('px',''))
                ]); else boxShadowSliders.push([ 
                    parseInt(m1[5].replace('px','')),
                    parseInt(m1[6].replace('px','')),
                    parseInt(m1[7].replace('px',''))
                ]);

                boxShadow.push (bs[j]);
                boxShadowColor.push(
                    bs[j].match(re1a) 
                    ? 'rgba('+m1[1]+', '+m1[2]+', '+m1[3]+', '+m1[4]+')'
                    : 'rgb('+m1[1]+', '+m1[2]+', '+m1[3]+')'
                );
            };
            r.boxShadow = boxShadow;
            r.boxShadowColor = boxShadowColor;
            r.boxShadowSliders = boxShadowSliders;
        };
        
        if (typeof $el.css('textShadow')=='string' && $el.css('textShadow')!=='') {
            //debugger;
            for (var j=0; j < ts.length; j++) {
                if (j > 0) ts[j] = 'rgb'+ts[j];
                //console.log (bs[j]);
                var m1 = typeof ts[j] !== 'string' || ts[j]==='' 
                    ? ts[j] 
                    : ts[j].match(re3a) 
                        ? ts[j].match(re3a) 
                        : ts[j].match(re3b);

                if (m1===null) textShadowSliders.push ([ 2, 2, 2, 2 ])
                else if (m1[7]) textShadowSliders.push([ 
                    parseInt(m1[5].replace('px','')),
                    parseInt(m1[6].replace('px','')),
                    parseInt(m1[7].replace('px','')) 
                ])
                else if (typeof m1==='string') sliders.push('ERROR - '+ts[j])
                else textShadowSliders.push([
                    parseInt(m1[5].replace('px','')),
                    parseInt(m1[6].replace('px',''))
                ]);

                if (ts[j]=='none') textShadowColor.push( 'rgba(0,0,0,0.8)' )
                else {
                    textShadow.push (ts[j]);
                    textShadowColor.push(
                        ts[j].match(re3a)
                        ? 'rgba('+m1[1]+', '+m1[2]+', '+m1[3]+')'
                        : 'rgb('+m1[1]+', '+m1[2]+')'
                    );
                }
            };
            r.textShadow = textShadow;
            r.textShadowColor = textShadowColor;
            r.textShadowSliders = textShadowSliders;
        };
        
        if (typeof b=='string' && b!=='') {
            var borderColor =
                b.match(re2a)
                ? 'rgba('+m2a[3]+', '+m2a[4]+', '+m2a[5]+', '+m2a[6]+')'
                : b.match(re2b)
                    ? 'rgb('+m2b[3]+', '+m2b[4]+', '+m2b[5]+')'
                    : 'lime';
            r.borderColor = borderColor;
        };
            
        return r;
    },
    
    selectBorderSettings : function (event) {
        var ct = $('#btnSelectBorderSettings')[0];
        if ($(ct).is('.disabled')) return false;
        na.te.onclick(ct);
        na.te.s.c.selectedSetting = 'border';
        $('.themeEditor_colorPicker').next().css ({ width : 230 });
        var w1 = $('#siteToolbarThemeEditor .vividDialogContent').width();
        var h1 = 
            $('#siteToolbarThemeEditor .vividDialogContent').height() 
            - $('.sds_dialogTitle').outerHeight() 
            - $('#specificitySettings').outerHeight() 
            - ( 4 * $('.flexBreak').outerHeight() );
        $('.themeEditorComponent').css({ width : w1/*, height : h1 */});
        //$('#borderSettings').children().css({ width : w1 });
        $('.themeEditorComponent').not('#borderSettings').fadeOut('fast');
        $('.themeEditor_colorPicker').next().fadeOut('fast');
        $('#borderSettings').fadeIn('fast', 'swing');/*, function () {
            $('#borderSettings > .themeEditorComponent_containerDiv > *')
                .not('.boxSettings_label_containerDiv, #borderColorpicker, .sp-container')
                .css({width:320-135,verticalAlign:'middle',display:'inline-block'});
        });*/
        $('#borderColorpicker').spectrum ({
            color : na.te.s.c.borderColor, 
            type: "flat", 
            showAlpha : true,
            showPalette : false, 
            clickoutFiresChange : false, 
            change : na.te.borderSettingsSelected
        });
        $('#borderColorpicker').next().css ({
            display : 'inline-block'
        });
        var evt2 = { currentTarget : $('#'+na.te.s.c.forDialogID)[0] };
        na.te.borderSettingsSelected (evt2, false); //event.currentTarget === ct
    },
    borderSettingsSelected : function (color) {
        if (color) na.te.s.c.borderColor = color; else color = na.te.s.c.borderColor;
        if (typeof color=='object') color = 'rgba('+color._r+', '+color._g+', '+color._b+', '+color._a+')'; // firefox bugfix
        var 
        bg = $('#'+na.te.s.c.forDialogID),
        newBorder = $('#borderWidth').val() + 'px ' + $('#borderType').val() + ' ' + color,
        newBorderRadius = parseInt($('#borderRadius').val());
        
        $(bg).css({ border : newBorder, borderRadius : newBorderRadius });
        $('#'+na.te.s.c.forDialogID).css({borderRadius : Math.round((newBorderRadius/4)*3) });
        $('.boxShadow').css({ border : newBorder, borderRadius : newBorderRadius });
        /*if (na.te.s.c.fireSaveTheme) */na.site.saveTheme();
    },
    
    selectBoxShadowSettings : function (event, updateHTML) {
        if (updateHTML!==false) updateHTML = true;
        var ct = $('#btnSelectBoxShadowSettings')[0];
        if ($(ct).is('.disabled')) return false;
        na.te.onclick(ct);
        na.te.s.c.selectedSetting = 'boxShadow';
        $('.themeEditor_colorPicker').next().css ({ width : 230 });
        var w1 = $('#siteToolbarThemeEditor .vividDialogContent').width();
        var h1 = $('#siteToolbarThemeEditor .vividDialogContent').height() - $('.nate_dialogTitle').outerHeight() - $('#specificitySettings').outerHeight() - ( 4 * $('.flexBreak').outerHeight() );
        //$('.themeEditorComponent').css({ width : w1, height : h1 });
        //$('#boxShadowSettings').children().css({ width : w1 });
        $('.themeEditorComponent').css({ width : w1 });
        $('.themeEditorComponent').not('#boxShadowSettings').fadeOut('fast');
        $('.themeEditor_colorPicker').next().fadeOut('fast');
        $('#boxShadowSettings').css({display:'inline-block',height:h1}).fadeIn('fast', 'swing', function () {
            var
            div = $('#'+na.te.s.c.forDialogID),
            bg = $('#'+na.te.s.c.forDialogID+' .vdBackground'),
            bg1 = $(bg).css('background').replace(/"/g, '\''),
            bs = $(div).css('boxShadow').split(', rgb');
            opacity = bg1.indexOf('url(')!==-1 ? bg.css('opacity') : 1,
            border = $('#borderWidth').val()+'px '+$('#borderSettings select').val()+' '+$('#borderColorpicker').val(),//na.te.s.c.borderColor,
            br = parseInt($('#borderRadius').val());
            
            for (var i=1; i<bs.length; i++) { 
                bs[i] = 'rgb'+bs[i]; 
            };
            if (updateHTML) $('.boxShadow_containerDiv').remove();
            for (let i=0; i<bs.length; i++) {
                //var html = '<div id="boxShadow_'+i+'_containerDiv" class="boxShadow_containerDiv"><div id="boxShadow_'+i+'" i="'+i+'" class="boxShadow" onclick="na.te.boxSettingsSelected(event)" style="position:relative;"><div id="boxShadow_'+i+'_bg" class="boxShadow_bg" style="border:'+border+';background:'+bg1+';opacity:'+opacity+';border-radius:'+br+'px;box-shadow:'+bs[i]+'"></div><span class="boxShadow_label" style="vertical-align:middle;text-align:center;display:table-cell;">abc XYZ</span></div></div>';
                var html = '<div id="boxShadow_'+i+'_containerDiv" class="boxShadow_containerDiv"><div id="boxShadow_'+i+'" i="'+i+'" class="boxShadow" onclick="na.te.boxSettingsSelected(event)" style="position:relative;"><div class="boxShadow_label" style="border:'+border+';background:'+bg1+';opacity:'+opacity+';border-radius:'+br+'px;box-shadow:'+bs[i]+';vertical-align:middle;text-align:center;padding:5px;margin:8px;">abc XYZ</div></div>';
                
                if (updateHTML) $('#boxShadowControls').append(html);
                
                setTimeout (function () { 
                    if (na.te.s.c.selectedBoxShadowID=='boxShadow_'+i) {
                        na.te.s.c.selectedBoxShadowID = 'boxShadow_'+i;
                        
                        var evt2 = { currentTarget : $('#'+na.te.s.c.selectedBoxShadowID)[0] };
                        na.te.boxSettingsSelected (evt2, false); //event.currentTarget === ct
                    };
                    
                    /*
                    $('#boxShadow_'+i+'_containerDiv, #boxShadow_'+i+'_bg, #boxShadow_'+i+' span').css({ 
                        width : $('#boxShadow_'+i).width(),
                        height : $('#boxShadow_'+i+' span').height()
                    });*/
                }, 10 + (i * 25));
            };
            /*
            $('#boxShadowSettings > .themeEditorComponent_containerDiv > *')
                .not('#boxShadowInset, .boxSettingsLabel_containerDiv, #boxShadowControls, #boxShadowColorpicker, .sp-container')
                .css({width:290-150,verticalAlign:'middle',display:'inline-block'});
            */

        });
    },
    boxSettingsSelected : function (event, saveTheme) {
        //debugger;
        if (event.currentTarget.id!==na.te.s.c.forDialogID) na.te.s.c.selectedBoxShadowID = event.currentTarget.id;
        if (saveTheme!==false) saveTheme = true;
        
        var bc = $('#borderColorpicker').val();
        $('.boxShadow .boxShadow_bg').css ({ borderColor : 'grey' });
        $('.boxShadow_bg', event.currentTarget).css ({ borderColor : bc });
        
        $('.boxShadow_containerDiv').removeClass('selected');
        $('#'+event.currentTarget.id+'_containerDiv').addClass('selected');
        
        na.te.s.c.borderColor = $('#borderColorpicker').val();
        
        var 
        bs = $('div.boxShadow_label', event.currentTarget).css('boxShadow'),
        b = $('div.boxShadow_label', event.currentTarget).css('border');
        
        if (b && b.indexOf('none')!==-1) 
            b = $(event.currentTarget).css('borderTopWidth')+' '
            +$(event.currentTarget).css('borderTopStyle')+' '
            +$(event.currentTarget).css('borderTopColor');
        
        if (bs == 'none') {
            var
            cssExtract = {
                boxShadowSliders : [ [ 2, 2, 4, 2 ] ],
                boxShadowColor : [ '2px 2px 4px 2px rgba(0, 0, 0, 0.7)' ]
            },
            ctI = 0;
            $('#boxShadowInset')[0].checked = false;
        } else {
            if (bs && b) {
                if (bs.match('inset')) $('#boxShadowInset')[0].checked = true; else $('#boxShadowInset')[0].checked = false;

                var 
                cssExtract = na.te.cssExtract(na.te.s.c.forDialogID),
                ctI = parseInt($(event.currentTarget).attr('i'));
                
                na.te.s.c.boxShadowColor = cssExtract.boxShadowColor[ctI];
                $('#boxShadowXoffset').val(cssExtract.boxShadowSliders[ctI][0]);
                $('#boxShadowYoffset').val(cssExtract.boxShadowSliders[ctI][1]);
                $('#boxShadowSpreadRadius').val(cssExtract.boxShadowSliders[ctI][2]);
                $('#boxShadowBlurRadius').val(cssExtract.boxShadowSliders[ctI][3]);
                $('#boxShadowColorpicker').spectrum ({
                    color : na.te.s.c.boxShadowColor
                });
            }
        };
        
        na.te.s.c.boxShadowColor = cssExtract.boxShadowColor[ctI];
        if ($('#boxShadowSettings .sp-container').length > 0)
            $('#boxShadowColorpicker').spectrum('set', na.te.s.c.boxShadowColor);
        else $('#boxShadowColorpicker').spectrum ({
            color : na.te.s.c.boxShadowColor, 
            type: "flat", 
            showAlpha : true,
            showPalette : false, 
            clickoutFiresChange : false, 
            change : na.te.boxSettingsChanged_shadowColor
        });
        
        if (saveTheme) na.te.boxSettingsChanged (boxShadowColor);
        /*
        var
        b = $('div.boxShadow_bg', event.currentTarget).css('border'),
        br = $('div.boxShadow_bg', event.currentTarget).css('borderRadius');
        if (!b) 
            b = $('div.boxShadow_bg', event.currentTarget).css('borderTopWidth')+' '
            +$('div.boxShadow_bg', event.currentTarget).css('borderTopStyle')+' '
            +$('div.boxShadow_bg', event.currentTarget).css('borderTopColor');
        
        if (b.indexOf('none')!==-1) {
            var bw = b.match(/^\d+/)[0];
            $('#borderWidth').val(parseInt(bw));
        }
        if (br!=='') {
            $('#borderRadius').val(parseInt(br));
        }*/
    },
    
    boxSettingsChanged : function (color) {
        if (color) $('#'+na.te.s.c.selectedBoxShadowID)[0].style.boxShadowColor = color; 
        else {
            color = $('#'+na.te.s.c.selectedBoxShadowID+' div').css('boxShadow');
            if (color && color.match('#')) color = color.match(/#.*\s/)[0];
            if (color && color.match('rgba')) color = color.match(/rgba\(.*\)/)[0];
            else if (color && color.match('rgb')) color = color.match(/rgb\(.*\)/)[0];
        };
        if (typeof color=='object') color = 'rgba('+color._r+', '+color._g+', '+color._b+', '+color._a+')'; 
        na.te.s.c.boxShadowColor = color;
        
        var
        newBoxSetting = 
            ( $('#boxShadowInset')[0].checked ? 'inset ' : '' )
            + $('#boxShadowXoffset').val() + 'px '
            + $('#boxShadowYoffset').val() + 'px '
            + $('#boxShadowSpreadRadius').val() + 'px '
            + $('#boxShadowBlurRadius').val() + 'px '
            + color;
        $('#'+na.te.s.c.selectedBoxShadowID+' > .boxShadow_label').css ({ boxShadow : newBoxSetting });
    //debugger;
        newBoxSetting = '';
        $('.boxShadow').each(function(idx,el) {
            if (newBoxSetting!=='') newBoxSetting += ', ';
            newBoxSetting += $('#'+el.id+' div').css('boxShadow');
        });
        $('#'+na.te.s.c.forDialogID).css ({ boxShadow : newBoxSetting });

        na.site.saveTheme();
        
    },
    boxSettingsChanged_shadowColor : function (color) {
        na.te.boxSettingsChanged(color);
    },
    addBoxShadow : function () {
        var last = 0;
        $('.boxShadow').each(function(idx,el) {
            var idx2 = parseInt(el.id.replace('boxShadow_',''));
            if (idx2 > last) last = idx2;
        });

        var
        div = $('#'+na.te.s.c.forDialogID),
        bg =  $('#'+na.te.s.c.forDialogID+' .vdBackground'),
        bg1 = bg.css('background').replace(/\'/g, '\\\'').replace(/"/g, '\''),
        opacity = bg1.indexOf('url(')!==-1 ? bg.css('opacity') : 1,
        border = div.css('border'),
        borderRadius = bg.css('borderRadius'),
        i = last + 1,
        //html = '<div id="boxShadow_'+i+'_containerDiv" class="boxShadow_containerDiv"><div id="boxShadow_'+i+'" i="'+i+'" class="boxShadow" onclick="na.te.boxSettingsSelected(event)" style="height:1.5em;margin:5px;padding:5px;position:relative;"><div id="boxShadow_'+i+'_bg" class="boxShadow_bg" style="border:'+border+';background:'+bg1+';opacity:'+opacity+';border-radius:'+br+'px;;position:absolute;"></div><span class="boxShadow_bg" style="position:absolute;padding:5px;vertical-align:middle;text-align:center;display:table-cell;">abc XYZ</span></div></div>';
        html = '<div id="boxShadow_'+i+'_containerDiv" class="boxShadow_containerDiv"><div id="boxShadow_'+i+'" i="'+i+'" class="boxShadow" onclick="na.te.boxSettingsSelected(event)" style="position:relative;"><div class="boxShadow_label" style="border:'+border+';background:'+bg1+';opacity:'+opacity+';border-radius:'+br+'px;box-shadow:2px 2px 2px 2px rgba(0,0,0,0.8);vertical-align:middle;text-align:center;padding:5px;margin:8px;">abc XYZ</div></div>';
        
        $('#boxShadowControls').append(html);
        /*
        setTimeout (function () { 
            $('#boxShadow_'+i+'_bg, #boxShadow_'+i+' span').css({ 
                width : $('#boxShadow_'+i).width(),
                height : $('#boxShadow_'+i).height()
            });
        }, 50);*/
        
        na.te.s.c.boxSettings = $('#boxShadow_'+(last+1))[0];
        $('#boxShadowXoffset').val(2);
        $('#boxShadowYoffset').val(2);
        $('#boxShadowSpreadRadius').val(2);
        $('#boxShadowBlurRadius').val(2);
    },
    deleteBoxShadow : function(evt) {
        $('#'+na.te.s.c.boxSettingsID+'_containerDiv').remove();
        
        $('.boxShadow_containerDiv').each(function(idx,el){
            el.id = 'boxShadow_'+idx+'_containerDiv';
            $('div.boxShadow', el)[0].id = 'boxShadow_'+idx;
            $('div.boxShadow_bg', el)[0].id = 'boxShadow_'+idx+'_bg';
        });
        
        na.te.s.c.selectedBoxShadowID = 'boxShadow_0';
        var evt2 = { currentTarget : $('#'+na.te.s.c.selectedBoxShadowID)[0] };
        na.te.boxSettingsSelected (evt2, false); //event.currentTarget === ct

        na.te.boxSettingsChanged();
    },
    
    selectBackground_color : function (event) {
        var ct = $('#btnSelectBackgroundColor')[0];
        if ($(ct).is('.disabled')) return false;
        na.te.onclick(ct);
        na.te.s.c.selectedSetting = 'backgroundColor';
        $('.themeEditorComponent').not('#themeEditor_backgroundColor').fadeOut('fast', function () {
            $('.themeEditor_colorPicker').next().css ({ width : 230 });
            if ($('#themeEditor_backgroundColor').css('display')==='none')
                $('#themeEditor_backgroundColor').css({top:8,opacity:1}).fadeIn('fast', function() {
                    $('#themeEditor_backgroundColor .sp-container').fadeIn('slow', 'swing', function() {
                        var 
                        bg =  $('#'+na.te.s.c.forDialogID+' .vdBackground'),
                        bg1 = bg.css('backgroundColor');
                        if (bg1)
                            if ($('#themeEditor_backgroundColor  .sp-container').length > 0)
                                $('#colorpicker').spectrum('set', bg1);
                            else $('#colorpicker').spectrum ({
                                color : bg1, 
                                type: "flat", 
                                showAlpha : true,
                                showPalette : false, 
                                clickoutFiresChange : false, 
                                change : na.te.boxSettingsChanged_shadowColor
                            });
                    });
                });
        });
    },

    selectBackground_folder : function (event) {
        var ct = $('#btnSelectBackgroundFolder')[0];
        if ($(ct).is('.disabled')) return false;
        na.te.onclick(ct);
        na.te.s.c.selectedSetting = 'backgroundFolder';
        $('.themeEditorComponent').not('#themeEditor_jsTree').fadeOut('fast');
        $('.themeEditor_colorPicker').next().fadeOut('fast');
        $('#themeEditor_jsTree').fadeIn('fast');
        setTimeout(na.te.onresize,250);
    },
    
    selectBackground_image : function (event) {
        var ct = $('#btnSelectBackgroundImage')[0];
        if ($(ct).is('.disabled')) return false;
        na.te.onclick(ct);
        na.te.s.c.selectedSetting = 'backgroundImage';

        $('.themeEditorComponent').not('#themeEditor_photoAlbum, #themeEditor_photoAlbum_specs').fadeOut('fast');
        setTimeout (function () {
            $('.themeEditor_colorPicker').next().fadeOut('fast');
            $('#themeEditor_photoAlbum, #themeEditor_photoOpacity, #themeEditor_photoAlbum_specs').fadeIn('fast');
            setTimeout(function() {
                $('#themeEditor_photoAlbum_specs').css({
                    display : 'flex',
                    flexWrap : 'wrap',
                    boxSizing: 'border-box',
                    width : '97%'
                });
                //$('.labelthemeEditor').css ({ width : 170, flexShrink : 0, flexGrow : 0 });
                
                $('#label_themeEditor_photoOpacity').css ({ top : 4, position : 'absolute' });
                $('#themeEditor_photoOpacity').css({
                    display : 'block',
                    width : $('#siteToolbarThemeEditor').width() - 180,
                    left : 150
                });

                $('#label_themeEditor_photoScaleX').css ({ top : 37, position : 'absolute' });
                $('#themeEditor_photoScaleX').css({
                    display : 'block',
                    width:$('#siteToolbarThemeEditor').width() - 180,
                    left : 150
                }).val(na.te.s.c.scaleX).fadeIn('fast');
                
                $('#label_themeEditor_photoScaleY').css ({ top : 66, position : 'absolute' });
                $('#themeEditor_photoScaleY').css({
                    display : 'block',
                    width:$('#siteToolbarThemeEditor').width() - 180,
                    left : 150
                }).val(na.te.s.c.scaleX).fadeIn('fast');
                
                setTimeout(na.te.onresize,100);
            }, 100);
        }, 100);
            
    },
    
    opacityChange : function (evt) {
        var 
        bg = $(evt.currentTarget).parents('.vividDialog')[0],
        rgbaRegEx = /rgba\((\d{1,3})\,\s*(\d{1,3})\,\s*(\d{1,3})\,\s*([\d.]+)\)(.*)/,
        rgbRegEx = /rgb\((\d{1,3})\,\s*(\d{1,3})\,\s*(\d{1,3})\)(.*)/,
        opacity = $(evt.currentTarget).val()/100;
        
        if (bg && $(bg).children('.vdBackground')[0]) bg = $(bg).children('.vdBackground');
        
        var bg1 = $(bg).css('background');        
        
        if (typeof bg1=='string' && bg1!=='' && !bg1.match('url')) {
            var bg2 = '', bg2a = bg1.match(rgbaRegEx), bg2b = bg1.match(rgbRegEx);
            if (bg2a) {
                $(bg).add('.boxShadow_bg, .textShadow_bg').css({ background : 'rgba('+bg2a[1]+', '+bg2a[2]+', '+bg2a[3]+', '+opacity+')'+bg2a[5] });
            } else {
                $(bg).add('.boxShadow_bg, .textShadow_bg').css({ background : 'rgba('+bg2b[1]+', '+bg2b[2]+', '+bg2b[3]+', '+opacity+')'+bg2b[4] });
            }
        } else { 
            $(bg).add('.boxShadow_bg, .textShadow_bg').css({ opacity : opacity });
        }
        /*if (na.te.s.c.fireSaveTheme) */na.site.saveTheme();
    },
    
    imageSelected : function (el) {
        na.te.s.c.selectedImage = el;
        let 
        bg = $('.vdBackground', $('#'+na.te.s.c.forDialogID)[0]),
        src = el.src.replace('thumbs/','');

        /*var bgSrc = $(bg).css('backgroundImage');
        bgSrc = bgSrc.replace('url("', '');
        bgSrc = bgSrc.replace('")', '');
        bgSrc = bgSrc.replace("url'", '');
        bgSrc = bgSrc.replace("')", '');*/
        var bgEl = document.createElement('img');
        bgEl.onload = function () {
            na.te.s.c.scaleX = (parseInt($('#themeEditor_photoScaleX').val()) * bgEl.naturalWidth) / 100;
            na.te.s.c.scaleY = (parseInt($('#themeEditor_photoScaleY').val()) * bgEl.naturalHeight) / 100;
            if ($('#themeEditor_photoSpecificity_dialog')[0].checked) {
                $(bg).css({ 
                    background : 'url("'+src+'") repeat', 
                    opacity : parseInt($('#themeEditor_photoOpacity').val())/100, 
                    backgroundSize : na.te.s.c.scaleX+'px '+na.te.s.c.scaleY+'px' 
                });
            } else {
                na.backgrounds.next ('#siteBackground', na.site.globals.backgroundSearchKey, src);
            }
            /*if (na.te.s.c.fireSaveTheme) */na.site.saveTheme();
        };
        bgEl.src = src;
    },
    
    selectTextSettings : function () {
        var ct = $('#btnSelectTextSettings')[0];
        if ($(ct).is('.disabled')) return false;
        na.te.onclick(ct);
        na.te.s.c.selectedSetting = 'text';
        $('.themeEditor_colorPicker').next().css ({ width : 230 }).fadeOut('fast');;
        $('.themeEditorComponent').not('#textSettings').fadeOut('fast', function () {
            if ($('#textSettings').css('display')==='none')
                $('#textSettings').fadeIn('fast', 'swing', function () {
                    
                    na.te.s.c.textColor = $('#'+na.te.s.c.forDialogID).css('color');
                    $('#textColorpicker').spectrum ({
                        color:na.te.s.c.textColor, 
                        type: "flat", 
                        showAlpha : true,
                        showPalette : false, 
                        clickoutFiresChange : false, 
                        change : na.te.textSettingsSelected_textColor
                    });
                    var evt2 = { currentTarget : $('#textSettings')[0] };

                    if (!na.site.settings.menus['#textFontFamily'])
                    na.site.settings.menus['#textFontFamily'] = new naVividMenu($('#textFontFamily')[0], true, function(menu) {
                    });


                    na.te.updateTextSettingsControls(evt2);

                    
                });
            
        });
    },
    
    selectTextShadowSettings : function (updateHTML) {
        if (updateHTML!==false) updateHTML = true;
        var ct = $('#btnSelectTextShadowSettings')[0];
        if ($(ct).is('.disabled')) return false;
        na.te.onclick(ct);
        na.te.s.c.selectedSetting = 'textShadow';
        $('.themeEditorComponent').not('#textShadowSettings').fadeOut('fast', function () {
        
            //$('.themeEditor_colorPicker').next().fadeOut('fast');
            if ($('#textShadowSettings').css('display')==='none')
                $('#textShadowSettings').fadeIn('fast', 'swing', function() {
                    var
                    div = $('#'+na.te.s.c.forDialogID),
                    bg =  $('#'+na.te.s.c.forDialogID+' .vdBackground'),
                    bg1 = bg.css('background').replace(/\'/g, '\\\'').replace(/"/g, '\''),
                    opacity = bg1.indexOf('url(') !== -1 ? bg.css('opacity') : 1,
                    border = div.css('border'),
                    br = bg.css('borderRadius'),
                    ts = $(div).css('textShadow').split(', rgb');
                    if (updateHTML) $('.textShadow_containerDiv').remove();
                    for (var i=1; i<ts.length; i++) { 
                        ts[i] = 'rgb'+ts[i]; 
                    };
                    for (let i=0; i<ts.length; i++) {
                        var
                        j = i,
                        fw = div.css('fontWeight'),
                        font = div.css('fontFamily').replace(/"/g, '\''),
                        html = '<div id="textShadow_'+j+'_containerDiv" class="textShadow_containerDiv"><div id="textShadow_'+j+'" i="'+j+'" class="textShadow" onclick="na.te.textSettingsSelected(event)" style="position:relative;"><div id="textShadow_'+j+'_bg" class="textShadow_bg" style="border:'+border+';background:'+bg1+';opacity:'+opacity+';border-radius:'+br+';font-weight:'+fw+';font-family:'+font+';vertical-align:middle;text-align:center;display:table-cell;text-shadow:'+ts[i]+';padding:10px;">abc XYZ</div></div>';
                        
                        if (updateHTML) $('#textShadowControls').append(html);
                    };

                    if (!na.te.s.c.selectedTextShadowID)
                        na.te.s.c.selectedTextShadowID = 'textShadow_0';
                    var cssExtract = na.te.cssExtract(na.te.s.c.forDialogID);
                    na.te.s.c.textShadowColor = cssExtract.textShadowColor;
                    $('#textShadowColorpicker').spectrum ({
                        color:na.te.s.c.textShadowColor, 
                        type: "flat", 
                        showPalette : false, 
                        showAlpha : true,
                        clickoutFiresChange : false, 
                        change : na.te.textSettingsSelected_textShadowColor
                    });
                    na.te.updateTextSettingsControls();
                    na.te.textSettingsSelected();
                });
        });
    },

    updateTextSettingsControls : function () {
        var
        el = $('#'+na.te.s.c.forDialogID),
        el2 = $('#'+na.te.s.c.forDialogID+' .vividDialogContent'),
        el3 = $('#'+na.te.s.c.forDialogID+' td'),
        ts = $(el).css('textShadow').split(', rgb');
        for (var i=1; i<ts.length; i++) {
            ts[i] = 'rgb'+ts[i];
        };
        var        
        selID = parseInt(na.te.s.c.selectedTextShadowID.match(/\d+$/)[0]),
        el_ts = $(el).css('fontSize'),
        el2_ts = $(el2).css('fontSize'),
        el3_ts = $(el3).css('fontSize'),
        el_fw = $(el).css('fontWeight'),
        el2_fw = $(el2).css('fontWeight'),
        el3_fw = $(el3).css('fontWeight'),
        re1a = /^rgba\((\d+),\s*(\d+),\s*(\d+),\s*([\d\.]+)\)\s+(\-?\d+px)\s+(\-?\d+px)\s+(\-?\d+px)$/,
        re1b = /^rgb\((\d+),\s*(\d+),\s*(\d+)\)\s+(\-?\d+px)\s+(\-?\d+px)\s+(\-?\d+px)$/,
        re2a = /^rgba\((\d+),\s*(\d+),\s*(\d+),\s*([\d\.]+)\)$/,
        re2b = /^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/,
        test1a = ts[selID] ? ts[selID].match(re1a) : null,
        test1b = ts[selID] ? ts[selID].match(re1b) : null,
        test2a = $(el).css('color').match(re2a),
        test2b = $(el).css('color').match(re2b),
        newTextShadowColor = 
            test1a 
            ? 'rgba('+test1a[1]+', '+test1a[2]+', '+test1a[3]+', '+test1a[4]+')'
            : test1b
                ? 'rgb('+test1b[1]+', '+test1b[2]+', '+test1b[3]+')'
                : 'black',
        newTextColor = test2a ? test2a[0] : test2b ? test2b[0] : 'white',
        newFontFamily = 
            el3[0]
            ? $(el3).css('fontFamily')
            : el2[0]
                ? $(el2).css('fontFamily')
                : el[0]
                    ? $(el).css('fontFamily')
                    : 'ABeeZee',
        newFontFamily = newFontFamily.split(', ')[0].replace(/"/g,'');
        na.te.s.c.selectedFontFamily = newFontFamily;

        $('#textFontFamily')
            //.css({width:$('#textSettings').width() - $('#labelTextFontFamily').width() - 20 })
            .val(newFontFamily);
        $('#textSize')
            //.css({width:$('#textSettings').width() - $('#labelTextSize').width() - 20 })
            .val(typeof el3_ts == 'string' && el3_ts!=='' 
                    ? parseInt(el3_ts.replace('px','')) 
                    : typeof el2_ts == 'string' && el2_ts!==''
                        ? parseInt(el2_ts.replace('px',''))
                        : typeof el_ts == 'string' && el_ts!==''
                            ? parseInt(el_ts.replace('px'))
                            : 12
                );
        var tw = parseInt((el3_fw!=='' ? el3_fw : el2_fw!=='' ? el2_fw : el_fw!=='' ? el_fw : 500))/100;
        $('#textWeight')
            //.css({width:$('#textSettings').width() - $('#labelTextWeight').width() - 20 })
            .val (tw);
        $('#textShadowXoffset')
            .css({width:$('#textSettings').width() - $('#labelTextShadowXoffset').width() - 40 })
            .val(test1a ? parseInt(test1a[5].replace('px','')) : test1b ? parseInt(test1b[4].replace('px','')) : 2);
        $('#textShadowYoffset')
            .css({width:$('#textSettings').width() - $('#labelTextShadowYoffset').width() - 40 })
            .val(test1a ? parseInt(test1a[6].replace('px','')) : test1b ? parseInt(test1b[5].replace('px','')) : 2);
        $('#textShadowBlurRadius')
            .css({width:$('#textSettings').width() - $('#labelTextShadowBlurRadius').width() - 40 })
            .val(test1a ? parseInt(test1a[7].replace('px','')) : test1b ? parseInt(test1b[6].replace('px','')) : 4);
            
        var 
        ts = $(el).css('textShadow');
        
        if (ts == 'none') {
            var
            cssExtract = {
                textShadowSliders : [ [ 2, 2, 1 ] ],
                textShadowColor : [ 'rgba(0, 0, 0, 0.7)' ]
            },
            ctI = 0;
        } else {
            if (ts) {
                var 
                cssExtract = na.te.cssExtract(na.te.s.c.forDialogID);
                
                na.te.s.c.textShadowColor = cssExtract.boxShadowColor[0];
                //$('#textShadowColorpicker').spectrum('set', cssExtract.textShadowColor[ctI]);
                $('#textShadowXoffset').val(cssExtract.textShadowSliders[0][0]);
                $('#textShadowYoffset').val(cssExtract.textShadowSliders[0][1]);
                $('#textShadowBlurRadius').val(cssExtract.textShadowSliders[0][2]);
            }
        };
    },

    addTextShadow : function (evt) {
        var last = 0;
        $('.textShadow').each(function(idx,el) {
            var idx2 = parseInt(el.id.replace('textShadow_',''));
            if (idx2 > last) last = idx2;
        });
        
        var
        div = $('#'+na.te.s.c.forDialogID),
        bg =  $('#'+na.te.s.c.forDialogID+' .vdBackground'),
        bg1 = bg.css('background').replace(/\'/g, '\\\'').replace(/"/g, '\''),
        opacity = bg1.match(/url\(/) ? bg.css('opacity') : 1,
        border = div.css('border'),
        br = bg.css('borderRadius'),
        fw = div.css('fontWeight'),
        font = div.css('fontFamily'),
        j = last + 1,
        html = '<div id="textShadow_'+j+'_containerDiv" class="textShadow_containerDiv"><div id="textShadow_'+j+'" i="'+j+'" class="textShadow" onclick="na.te.textSettingsSelected(event)" style="position:relative;"><div id="textShadow_'+j+'_bg" class="textShadow_bg" style="border:'+border+';background:'+bg1+';opacity:'+opacity+';border-radius:'+br+';font-weight:'+fw+';font-family:'+font+';vertical-align:middle;text-align:center;display:table-cell;text-shadow:2px 2px 2px rgba(0,0,0,0.7);padding:5px;">abc XYZ</div></div>';

        $('#textShadowControls').append(html);

        setTimeout (function () { 
            $('#textShadow_'+j+'_containerDiv, #textShadow_'+j+', #textShadow_'+j+'_bg, #textShadow_'+j+' span').css({ 
                width : $('#textShadow_'+j).width(),
                height : $('#textShadow_'+j+' span').height()
            });

            na.te.s.c.selectedTextShadowID = 'textShadow_'+j;

            var 
            el = $('#textShadow_'+j)[0],
            evt2 = { currentTarget : el };
            
            na.te.s.c.selectedTextShadow = el;
            na.te.textSettingsSelected_updateDialog();
            na.te.textSettingsSelected(evt2,false);
            na.te.selectTextShadowSettings(false);
            //na.site.saveTheme();
        }, 100);
        
    },
    deleteTextShadow : function (evt) {
        var 
        toDel = $('#'+na.te.s.c.selectedTextShadowID),
        nextSelected = toDel.next('.textShadow_containerDiv');
        if (!nextSelected[0]) nextSelected = toDel.prev('.textShadow_containerDiv');
        
        $(toDel).remove();
        na.te.s.c.selectedTextShadowID = nextSelected.id;        
            na.te.textSettingsSelected_updateDialog();
            na.te.textSettingsSelected(evt2);
            na.te.selectTextShadowSettings(false);

        //na.te.updateTextSettingsControls(evt);
    },

    textSettings_changeFont : function (evt, newFontFamily) {
        na.te.textSettingsSelected (evt, newFontFamily)
    },

    textSettingsSelected : function (evt, newFontFamily) {
        if (
            evt
            && (
                $(evt.currentTarget).is('.textShadow')
                || $(evt.currentTarget).is('.textShadow_containerDiv')
            )
        ) na.te.s.c.selectedTextShadowID = evt.currentTarget.id;
//debugger;
        var
        el = $('#'+na.te.s.c.forDialogID),
        el2 = $('#'+na.te.s.c.forDialogID+' .vividDialogContent'),
        el3 = $('#'+na.te.s.c.forDialogID+' td'),
        newTextShadow =
            $('#textShadowXoffset').val()+'px '
            +$('#textShadowYoffset').val()+'px '
            +$('#textShadowBlurRadius').val()+'px '
            +na.te.s.c.textShadowColor,
        newFontSize = $('#textSize').val(),
        newFontWeight = parseInt($('#textWeight').val()) * 100,
        newFontFamily = newFontFamily ? newFontFamily : na.te.s.c.selectedFontFamily, //$('#textFontFamily').val(),//.replace(/ /g, '+'),
        els = $('#'+na.te.s.c.selectedTextShadowID+' > div')
                .add(el).add(el2).add(el3);
        debugger;
        if (newFontFamily) na.te.s.c.selectedFontFamily = newFontFamily;

        els.css ({
            textShadow : newTextShadow,
            fontWeight : newFontWeight,
            fontSize : newFontSize+'px',
            fontFamily : newFontFamily
        });
        na.site.saveTheme();

        $('.textShadow_containerDiv').removeClass('selected');
        $('#'+na.te.s.c.selectedTextShadowID+'_containerDiv').addClass('selected');
        //na.te.s.c.textShadowColor = cssExtract.textShadowColor[0];
        if ($('#textShadowSettings .sp-container').length > 0)
            $('#textShadowColorpicker').spectrum('set', na.te.s.c.textShadowColor);
        else $('#textShadowColorpicker').spectrum ({
            color : na.te.s.c.textShadowColor,
            type: "flat",
            showAlpha : true,
            showPalette : false,
            clickoutFiresChange : false,
            change : na.te.boxSettingsChanged_shadowColor
        });

        na.te.textSettingsSelected_updateDialog(evt);
    },
    
    textSettingsSelected_updateDialog : function () {
        var
        el = $('#'+na.te.s.c.forDialogID),
        el2 = $('#'+na.te.s.c.forDialogID+' .vividDialogContent, #'+na.te.s.c.forDialogID+' td'),
        newFontSize = $('#textSize').val(),
        newFontWeight = parseInt($('#textWeight').val()) * 100,
        newFontFamily = na.te.s.c.selectedFontFamily,//$('#textFontFamily').val(),//.replace(/ /g, '+'),
        newTextShadow = '';
        
        $('.textShadow')
            //.css({ fontWeight : newFontWeight, fontSize : newFontSize+'px', fontFamily : newFontFamily })
            .each(function(idx,el) {
                if (newTextShadow!=='') newTextShadow+=', ';
                newTextShadow += $('#'+el.id+' > div').css('textShadow');
            });
            
        $(el).add(el2).css({ fontWeight : newFontWeight, fontSize : newFontSize+'px', fontFamily : newFontFamily });
        $(el).add(el2).css({ textShadow : newTextShadow });
        /*if (na.te.s.c.fireSaveTheme) */na.site.saveTheme();
        window.dispatchEvent(new Event('resize'));        
    },
    
    textSettingsSelected_textColor : function (color) {
        if (color) na.te.s.c.textColor = color; else color = na.te.s.c.textColor;
        if (typeof color=='object') color = 'rgba('+color._r+', '+color._g+', '+color._b+', '+color._a+')'; // firefox bugfix
        var
        el = $('#'+na.te.s.c.forDialogID),
        el2 = $('#'+na.te.s.c.forDialogID+' .vividDialogContent'),
        el3 = $('#'+na.te.s.c.forDialogID+' td');
        $(el).add(el2).add(el3).css ({ color : color });
        /*if (na.te.s.c.fireSaveTheme) */na.site.saveTheme();
    },
    
    textSettingsSelected_textShadowColor : function (color) {
        if (color) {
            na.te.s.c.textShadowColor = color;
            na.te.textSettingsSelected();
        }
    },
    
    textBackgroundOpacityChange : function (evt) {
        var 
        fncn = 'na.themeEditor.textBackgroundOpacityChange(evt)->na.site.saveTheme(*callback*)',
        opacityValue = $('#btnOptions_menu input.sliderOpacityRange').val() / 100;
        
        na.te.s.c.textBackgroundOpacity = opacityValue;
        /*$('li span, p, h1, h2, h3').css ({
            background : 'rgba(0,0,0,'+opacityValue+')'
        });*/
        
        na.site.saveTheme(function() {
            na.site.loadTheme (function () { // also calls ajax_get_pageSpecificSettings.php
                var
                btn = $('#'+na.te.s.c.selectedButtonID)[0],
                evt = { currentTarget : $('#specificity')[0] };

                na.te.specificitySelected(evt);
                //na.te.onclick(btn, false);
                var tabPage = na.te.s.c.selectedSetting;
                na.te.whichSettingSelected(tabPage);
            });
            /*
            var
            state = History.getState(),
            url = state.url.replace(document.location.origin,'').replace('/apps/', ''),
            url2 = url.replace(document.location.origin,'').replace(document.location.host,'').replace('/apps/', ''),
            url3 = '/NicerAppWebOS/logic.AJAX/ajax_get_pageSpecificSettings.php',
            ac2 = {
                type : 'GET',
                url : url3,
                data : {
                    apps : url2
                },
                success : function (data, ts, xhr) {
                    $('#cssPageSpecific, #jsPageSpecific').remove();
                    $('head').append(data);
                    setTimeout(function () {
                        na.site.loadTheme (function () {
                            var 
                            btn = $('#'+na.te.s.c.selectedButtonID)[0],
                            evt = { currentTarget : $('#specificity')[0] };
                            
                            na.te.specificitySelected(evt);
                            //na.te.onclick(btn, false);
                            var tabPage = na.te.s.c.selectedSetting;
                            na.te.whichSettingSelected(tabPage);
                        }); 
                    }, 250);
                },
                error : function (xhr, textStatus, errorThrown) {
                    na.site.ajaxFail(fncn, url3, xhr, textStatus, errorThrown);
                }                
            };*/
            //setTimeout (function() { 
                $.ajax(ac2);
            //}, 250);
        });
        
    }
};
na.te.s = na.te.settings;
na.te.s.c = na.te.s.current;
