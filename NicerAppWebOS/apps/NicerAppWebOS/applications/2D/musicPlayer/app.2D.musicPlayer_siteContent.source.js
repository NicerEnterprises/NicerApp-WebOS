//na.m.waitForCondition ( 'na.m.desktopInitialized()', na.m.WebOSidle, function () {
        
na.analytics.logMetaEvent ('applications/2D/musicPlayer : init-stage-1');

delete na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'];
na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'] = {
	about : {
		whatsThis : 'Complete application code for the music playback-and-download site on http://nicer.app/musicPlayer',
		copyright : 'Copyrighted (c) 2011-2021 by Rene AJM Veerman - rene.veerman.netherlands@gmail.com',
		license : 'http://nicer.app/LICENSE.txt',
		version : '3.1.1',
		firstReleased : '2011',   
		lastUpdated : '2022-04-28(Thursday) 05:10 Central European Summer Time',
		knownBugs : [
			"None at the moment, i think. Please report any bugs you find.."
		]
	},
    globals : {
        url : '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer/'
    },
	settings : {
		playingIndex : 0,
		paused : false,
		stopped : true,
		repeating : false,
		masterLeftOffset : null,
        onResizeReposition : true,
		dialogs : {},
        firstRun : true,
        
        loadedIn : {
            '#siteContent' : {
                onload : function (settings) {
                    na.site.settings.current.app = '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer';
                    na.analytics.logMetaEvent ("na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].onload() called.");
//debugger;

                    var w = $('#mp3s').width()-25;
                    debugger;
                    na.m.waitForCondition (
                        'na.site.settings.current.desktopIdle for resizing of playlist .vividButton elements (not in a .vividMenu btw)',
                        function () { return na.m.desktopIdle(); },
                        function () {
                            $('#mp3s .vividButton').each(function(idx,el) {
                                //debugger;
                                var
                                label = el.innerHTML,
                                html = '<div id="textCheck" class="vividButton vividButton_text" style="width:'+w+'px;opacity:0.0001">'+label+'</div>';

                                if (!$('#textCheck')[0]) {
                                    $('body').append(html);
                                }
                                var span = $('#textCheck');

                                try {
                                    var h = $(span).outerHeight();
                                } catch (e) {
                                    var h = e;
                                    
                                }
                             //   debugger;
                                $(el).css({
                                    position: 'relative',
                                    display : 'flex',
                                    margin : 10,
                                    width : w,
                                    height : h+10
                                });

                                //debugger;
                            });
                        }, 100); // milliseconds delay number (milliseconds between check of 2nd parameter function call)

                    na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].setupDragNDrop();
                    
                    $('.audioSeekBar_setting').css({ height : $('.audioSeekBar').height() - 4, marginTop : 2, marginLeft : 2, borderRadius:5 });
                    $('.audioVolumeBar_setting').css({ height : $('.audioVolumeBar').height() - 4, marginTop : 2, marginLeft : 2, borderRadius:5 });
                    
                    //setTimeout(function() {
                        $('#siteContent .vividDialog').each(function(idx,el){
                            na.site.settings.dialogs['#'+el.id] = new naVividDialog(el);
                        });
                        $('.audioPlayerUI .vividButton4').each(function(idx,el){
                            var btn = na.ui.vividButton.init(el.id);
                            na.site.settings.buttons['#'+el.id] = btn;
                            var b = na.ui.vb.settings.buttons[el.id];
                            if (el.id=='btnPlayPause') $(el).addClass('disabled');
                            if (el.id=='btnMuteUnmute') na.ui.vb.onclick({currentTarget:el});

                        });
                    //}, 200);
                    
                    $('.lds-facebook').fadeOut('normal');
                    
                    na.desktop.registerProgress ('applications/2D/musicPlayer', function() {
                        var div = $('#siteContent')[0];
                        na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].onWindowResize(div);
                    });
                    na.desktop.registerCallback ('applications/2D/musicPlayer', '#siteContent', function (cb, div, calculationResults, sectionIdx, section, divOrderIdx) {
                        if (div.id=='siteContent') na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].onWindowResize(div);
                        na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.onResizeReposition = false;
                    });
                },
                ondestroy : function (settings) {
                    na.desktop.deleteProgress ('applications/2D/musicPlayer');
                    na.desktop.deleteCallback ('applications/2D/musicPlayer');
                    clearInterval (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.timeDisplayInterval);
                }
            }
        }
	},
	
	queueMP3 : function (id, file) {
		var pl = document.getElementById('playlist');
		var pc = na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].playlistCount++;
		
		var newPlaylistItem = npi = document.createElement('div');
		npi.setAttribute ('file', file);
		npi.id = 'playlist_' + pc;
        npi.file = file;
        //npi.style.padding = '2px';
        //npi.style.height = '25px';
		npi.className = 'mp3 vividButton';
        $(npi).attr('theme','dark');


		npi.innerHTML = 
			'<a href="javascript:na.apps.loaded["applications/2D/musicPlayer"].selectMP3(\'' + npi.id + '\', \'' + file + '\');">'
			+ label
			+ '</a>';
		
        if ($('#textCheck')[0]) var span = $('body').append('<div id="textCheck" class="vividButton vividButton_text" style="width:'+($('#mp3s').width()-50)+'px;opacity:0.0001">'+label+'</div>'); else var span = $('#textCheck');
        try {
            var h = span.height();
        } catch (e) {
            var h = e;
            
        }
        console.log ('#textCheck4 h=',h, label);
        $('#textCheck').remove();                
        var html = '<div id="'+t.el.id+'_'+idx+'" class="vividButton" theme="'+t.t+'" style="opacity:0.0001;height:'+(h+30)+'px">'+$(li).children('a')[0].outerHTML+'</div>';
        $(npi).css({height:h+100});    
            
            
            
		pl.appendChild (npi);
        na.apps.loaded.na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].onWindowResize();
        if (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.stopped) {
            na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].selectMP3 (npi.id, file);
        }
	},
	
	selectMP3 : function (id, file) {
        if (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.ignoreClick) { na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.ignoreClick = false; return false; }
        
        clearInterval (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.timeDisplayInterval);
        
        var firstRun = na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.firstRun;
        if (firstRun) na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.firstRun = false;
        
		na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.activeID = id;
		
        na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.playingIndex = false;
        delete na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.stopped;
		var pl = $('#playlist')[0];
		for (var i=0; i<pl.children.length; i++) {
            if (pl.children[i].id==id || (pl.children[i].children[0] && pl.children[i].children[0].id==id)) na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.playingIndex = i;
		};
        if (!file) debugger;
        
        $('.mp3').removeClass('selected').removeClass('vividButtonSelected').addClass('vividButton');
        $('#'+id).addClass('selected').removeClass('vividButton').addClass('vividButtonSelected');

        var ajaxCommand = {
			type : 'GET',
			url : '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer/music/'+na.site.globals.app['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer']['set']+'/' + file + '.json',
            error: function(l0_jqXHR, l0_textStatus, l0_errorThrown) {
				var html = '';
                html += '<div style="height:15px;">&nbsp;</div>';
                html += '<table>';
				html += '<tr><td colspan="2" style="text-align:center"><a href="' + na.site.globals.url + '/download_mp3.php?file='+file+'">download</a></td></tr>';
				html += '<tr><td><span class="mp3_info_label mp3_title_label">title</span></td><td><span class="mp3_title">'+file+'</span></td></tr>';
                html += '</table>';
                na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].updateDescriptionDiv(id, file, html);
            },
			success : function (json, ts) {
				if (typeof json!=='object') json = eval ('('+json+') ');
                if (json.description) {
                    var html = '';
                    html += '<div style="height:15px;">&nbsp;</div>';
                    html += '<table>';
                    html += '<tr><td colspan="2" style="text-align:center"><a href="' + na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].globals.url + '/download_mp3.php?file='+file+'">download</a></td></tr>';
                    html += '<tr><td><span class="mp3_info_label mp3_title_label">title</span></td><td><span class="mp3_title">'+json.title+'</span></td></tr>';
                    html += '<tr><td><span class="mp3_info_label mp3_album_label">album</span></td><td><span class="mp3_album">' + json.album + '</span></td></tr>';
                    html += '<tr><td><span class="mp3_info_label mp3_length_label">length</span></td><td><span class="mp3_length">' + json.length + '</span></td></tr>';
                    html += '<tr><td><span class="mp3_info_label mp3_year_label">year</span></td><td><span class="mp3_year">'+json.year+'</span></td></tr>';
                    html += '<tr><td colspan="2"><span class="mp3_description">' + json.description + '</span></td></tr>';
                    html += '</table>';
                } else {
                    var html = '';
                    html += '<table>';
                    html += '<tr><td colspan="2" style="text-align:center"><a href="' + na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].globals.url + '/download_mp3.php?file='+file+'">download</a></td></tr>';
                    html += '<tr><td colspan="2" style="text-align:center"><a href="https://youtube.com/watch?v='+json.youtubeID+'" target="_new">youtube link</a></td></tr>';
                    html += '</table>';
                }
                na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].updateDescriptionDiv(id, file, html);
			}
		};
		$.ajax(ajaxCommand);
        na.analytics.logMetaEvent ('appEvent : musicPlayer : selectMP3() file='+file);
	},
    
    updateDescriptionDiv : function (id, file, html) {
        $('#siteIntroText').fadeOut (500, function () {
            $('.mp3').each (function (index,element) {
                if (this.id=='') return false;
                if (this.id==id) var state = 'selected'; else var state='normal';
            });
            $('#mp3descText').fadeOut('fast', function() {
                $('#mp3descText').html (html).fadeIn(1000);
            });            
            
            var 
            mp3 = '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer/music/'+na.site.globals.app['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer']['set']+'/' + file;

            $('#audioTag')[0].src = mp3;
            $('#audioTag')[0].play();
            $('.audioVolumeBarLabel').html ( 'Volume : '+ Math.round($('#audioTag')[0].volume*100) );
            na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.stopped = false;

            if (
                $('#btnPlayPause').is('.disabled') 
            ) {
                $('#btnPlayPause').removeClass('disabled');
                na.ui.vividButton.onclick({currentTarget:$('#btnPlayPause')[0]});
            }
            
            setTimeout(na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].setTimeDisplayInterval,100);
        });

    },
    
    setTimeDisplayInterval : function () {
        clearInterval (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.timeDisplayInterval);
        //if (!na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.timeDisplayInterval)
            na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.timeDisplayInterval = setInterval (function() {
                var 
                length = $('#audioTag')[0].duration, // in seconds
                strLength = na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].convertSecondsToTimeString(length),
                currentTime = $('#audioTag')[0].currentTime, // in seconds
                strCurrentTime = na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].convertSecondsToTimeString(currentTime);
                
                if (currentTime==length) {
                    debugger;
                    clearInterval (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.timeDisplayInterval);
                    na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].next();
                } else {
                    
                    $('.audioSeekBarLabel_length').html(strLength);
                    $('.audioSeekBarLabel_currentTime').html(strCurrentTime);
                    
                    var 
                    widthSeekBar = $('.audioSeekBar').width(),
                    widthPlayBar = Math.floor((widthSeekBar * currentTime)/length);
                    
                    if (!na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.maxPlayBarWidth) na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.maxPlayBarWidth = widthSeekBar;
                    $('.audioSeekBar_setting')[0].style.width = (widthPlayBar <= na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.maxPlayBarWidth ? widthPlayBar : na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.maxPlayBarWidth)+'px';
                }
                
            }, 1000);
    },
    
    convertSecondsToTimeString : function (seconds) {
        var 
        hours = Math.floor(seconds/3600),
        minutes = Math.floor( (seconds-(hours * 3600)) / 60 ),
        secs = Math.floor(seconds - (hours * 3600) - (minutes * 60));
        
        if (hours<10) hours = '0'+hours;
        if (minutes<10) minutes = '0'+minutes;
        if (secs<10) secs = '0'+secs;
        
        return hours+':'+minutes+':'+secs;
    },
	
	playpause : function () {
		if (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.stopped || na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.paused) {
			$('#audioTag')[0].play();
			na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.paused = false;
			na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.stopped = false;
            //$('#from_play_to_pause')[0].beginElement();
            //$('#btnPlayPause').addClass('selected');
            //na.ui.vb.hoverOver(na.ui.vb.settings.buttons['btnPlayPause']);
		} else {
			$('#audioTag')[0].pause();
			na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.paused = true;
			na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.stopped = false;
            //$('#from_pause_to_play')[0].beginElement();
            //$('#btnPlayPause').removeClass('selected');
            //na.ui.vb.hoverOut(na.ui.vb.settings.buttons['btnPlayPause']);
		}
	},
	
	stop : function () {
        na.ui.vividButton.onclick({currentTarget:$('#btnPlayPause')[0]});
        $('#btnPlayPause').addClass('disabled');
		$('#audioTag')[0].pause();
		na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.stopped = true;

        $('.mp3').each (function (index,element) {
			if (this.id=='') return false;
		});
		$('#mp3descText').fadeOut (1000);
		setTimeout (function () {
			$('#siteIntroText').fadeIn (1000);
		}, 1010);
	},
    
    next : function () {
        if (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.playingIndex===false) {
            return false;
        } else {
            var pl = $('#playlist')[0];
            for (var i=0; i<pl.children.length; i++) {
                var newIndex = 'playlist_' + (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.playingIndex + 1);
                if (pl.children[i].id == newIndex) {
                    na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].selectMP3 (newIndex, $(pl.children[i]).attr('file'), false);
                    return true;
                }
                if (pl.children[i].children[0] && pl.children[i].children[0].id== newIndex) {
                    na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].selectMP3 (newIndex, $(pl.children[i].children[0]).attr('file'), false);
                    return true;
                }
            }
            if (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.repeating) {
                debugger;
                var newIndex = 'playlist_0';
                i = 0;
                if (pl.children[i].id == newIndex) {
                    na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].selectMP3 (newIndex, $(pl.children[i]).attr('file'), false);
                    return true;
                }
                if (pl.children[i].children[0] && pl.children[i].children[0].id== newIndex) {
                    na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].selectMP3 (newIndex, $(pl.children[i].children[0]).attr('file'), false);
                    return true;
                }
            }
        };            
    },
	
	mute : function () {
		if (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.muted) {
			$('#audioTag')[0].muted = false;
			na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.muted = false;
		} else {
			$('#audioTag')[0].muted = true;
			na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.muted = true;
		}
	},
    
	toggleRepeat : function () {
		na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.repeating = !na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.repeating;
        if (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.repeating) {
            $('#btnRepeat')[0].src = '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer/repeat_selected_icon.png';
        } else {
            $('#btnRepeat')[0].src = '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer/repeat_icon.png';
        }
	},
    
    seek : function (evt) {
        var 
        length = $('#audioTag')[0].duration, // in seconds
        strLength = na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].convertSecondsToTimeString(length),
        currentTime = $('#audioTag')[0].currentTime;
        
        $('.audioSeekBarLabel_length').html(strLength);
        $('.audioSeekBarLabel_currentTime').html(strCurrentTime);
        
        var 
        widthSeekBar = $('.audioSeekBar').width(),
        widthPlayBar = evt.offsetX;//Math.round((widthSeekBar * evt.offsetX)/length),
        newCurrentTime = Math.round((widthPlayBar * length)/widthSeekBar);

        $('.audioSeekBar_setting')[0].style.width = widthPlayBar+'px';
        $('#audioTag')[0].currentTime = newCurrentTime;
    },
    
    setVolume : function (evt) {
        var 
        widthVolumeBar = $('.audioVolumeBar').width();
        $('#audioTag')[0].volume = evt.offsetX / widthVolumeBar;
        $('.audioVolumeBarLabel').html ( 'Volume : ' + Math.round($('#audioTag')[0].volume * 100) );
        $('.audioVolumeBar_setting').css ({ width : evt.offsetX });
    },
    
    mp3drag : {
        containment : 'window',
        connectToSortable : '#playlist',
        refreshPositions : true,
        drag : function (evt, ui) {
        },
        helper : function (evt, ui) {
            if (this.id.indexOf('playlist_')!==-1) return false;
            if (this.id===na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.resortedItem) return false;
            var div = document.createElement('div');
            $('body').append(div);
            $(this).clone(false,false).appendTo(div).css({position:'relative',zIndex:1100, color:'yellow', marginLeft:40});
            //$(document.body).append(div);
            return div;
        }
    },
    
    mp3sortable : {
            //items : '> div',
            //tolerance : 'pointer',
			revert : true,
			start : function (evt, ui) {
                var x = evt.originalEvent.originalEvent.path[0];
                //if (x.id.match('playlist')) na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.ignoreDrop = true;
                if (evt.detail===1) na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.ignoreClick = true;
			},
			stop : function (evt, ui) {
                setTimeout(na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].reorderPlaylist, 500);
			},
            update : function (evt, ui) {
                na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].reorderPlaylist();
            }
    },
    
	setupDragNDrop : function () {
		var mp3s = $('.mp3');
		mp3s.draggable (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].mp3drag);
		$('#playlist').sortable(na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].mp3sortable);
		$('#playlist').droppable ({
			drop : function (evt, ui) {
                if (!ui.helper[0].children[0]) return false;
                                  
                if (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.ignoreDrop) {
                    na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.ignoreDrop = false;
                    return false;
                } else na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.ignoreDrop = true;
                                  
                var 
                pl = $('#playlist')[0],
                div = $(ui.helper),
                dragged = $(ui.helper[0].children[0]).clone(false,false)[0],
                pc = na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].playlistCount;
                
                let 
                oldID = ui.helper[0].children[0].id,
                original = $('#'+oldID),
                newID = 'playlist_'+pc;
                
                if (oldID.match('playlist_')) return false;
                $(dragged).attr('id', newID);
                $(dragged).attr(
                    'style',
                    $(dragged).attr('style').replace(/;margin-left:30px;/,'')+';margin-left:30px;'
                );
                dragged.evt = evt;
                $(dragged).attr('class', 'mp3 vividButton');// ui-draggable ui-draggable-handle');
                $(dragged).attr('file', original.attr('file'));
                dragged.file = original.attr('file');
                dragged.oldID = oldID;

                $(dragged).attr(
                    'onclick',
                    ''+original[0].onclick
                        .toString()
                        .replace("'"+oldID+"'", "'"+newID+"'")
                        .replace('function onclick(event) {', '')
                        .replace('\n}','')
                        .replace (new RegExp(oldID), dragged.id)
                );

                na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].reorderPlaylist();
                
                if (na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.stopped)
                    na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].selectMP3 (newID, $(dragged).attr('file'));
                                
                na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].onWindowResize();
                na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].playlistCount++;
                
                evt.preventDefault();

                // vital for the 're-ordering' functionality of the #playlist itself :
                $(dragged).draggable({
                    containment : '#playlist',
                    connectToSortable : '#playlist',
                    stack : '.mp3',
                    helper : function (evt, ui) {
                        na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.resortedItem = dragged.oldID;
                        var x= $('#'+newID).parent()[0];
                        var div = document.createElement('div');
                        $(div).css({width:'100%'});
                        $(this).clone(true,true).appendTo(div).css({zIndex:1100, color:'yellow', paddingLeft:30}).attr('id',newID);
                        $('#playlist').append(div);
                        return div;
                    },
                    drag : function (evt, ui) {
                        return true;
                    }
                });

                return dragged;
			}
		});
	},
    
    reorderPlaylist : function () {
        $('.mp3', $('#playlist')[0]).each(function(idx,el){
            let 
            x = $(el).attr('onclick').toString().replace(new RegExp(el.id),'playlist_'+idx),
            x1 = x.replace('javascript:','').trim();
            //debugger;
            
            //el.onclick = function (evt) { eval (x1); };
            $(el).attr('onclick','javascript:'+x1);
            el.id = 'playlist_'+idx;
        });
    },
    
	playlistCount : 0,

	onWindowResize : function (div) {
        if (div && div.id!=='siteContent') return false;
        if (!window.top || !$(window.top.document.getElementById('siteContent'))[0]) return false;
		var 
		myWidth = $('#siteContent').width(),
		myHeight = $('#siteContent').height()- $('#horizontalMover__containmentBox2').height() - $('#horizontalMover__containmentBox2')[0].offsetTop - 50 -$('#titlebar').height() - 10,
		contentWidth = 20 + 240 + 40 + 300 + 20,
        contentInnerWidth = 240 + 40 + 300 - 10,
        sc_scrollpane = $('#siteContent', window.top.document.body),
		sc_scrollpaneContainer = $('#siteContent', window.top.document.body),
		sc_siteContent = $('#siteContent', window.top.document.body);
        
		if (typeof na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.masterLeftOffset == 'number' && !na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.onResizeReposition) {
			var masterLeftOffset = na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.masterLeftOffset;
			if (masterLeftOffset<0) masterLeftOffset=0;
		} else {
			var masterLeftOffset = ((myWidth - contentWidth) / 2);
			if (masterLeftOffset<0) masterLeftOffset=0;
			na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.masterLeftOffset = masterLeftOffset;
		}
		
		var dialogMP3sList = '#mp3s';
		if ($('#infoWindow_mp3desc').length>0) var dialogMP3desc = '#infoWindow_mp3desc'; 
			else var dialogMP3desc = '#infoWindow_mp3desc';
		if ($('#playlist_wrapper').length>0) var dialogPlaylist = '#playlist_wrapper, #playlist_wrapper'; 
			else var dialogPlaylist = '#playlist_wrapper';
		if ($('#player').length>0) var dialogPlayer = '#player, #player, #player__CSS3'; 
			else var dialogPlayer = '#player, #player__CSS3';
            
        var 
        leftOffset = masterLeftOffset + 20,
        playerLeft = (leftOffset + 250 + 20),
		dialogsLeft = Math.round (leftOffset);
        $('#titlebar').css ({
            width : contentInnerWidth,
            left : dialogsLeft,
            top : 27
        });
        $('#titlebar .vividDialogContent').css ({
            overflow : 'hidden'
        });
        
		var 
		timeDelay = 10,
		timeIncrease = 50,
		$dialogHeading = $('#heading_wrapper'),
		$dialogMP3sList = $(dialogMP3sList),
		$dialogMP3desc = $(dialogMP3desc),
		$dialogPlaylist = $(dialogPlaylist),
		$dialogPlayer = $(dialogPlayer),
		centerDialogsWidth = $(dialogMP3sList).width() + $dialogPlaylist.width() + $dialogPlayer.width(),
		dialogsTop = $('#titlebar').position().top + $('#titlebar').height() + 30,
		dialogsHeight = (myHeight - dialogsTop - 40);
        
		$('#horizontalMover__containmentBox2').css({
			left : 15,
            top : 5,
			width : myWidth-30,
			opacity : 0.001,
			display : 'block'
		}).animate ({opacity:0.1},1000);
		$('#horizontalMover__containmentBox1').css({
			left : 15,
            top : 5,
			width : myWidth - 30,
			opacity : 0.001,
			display : 'block'
		}).animate ({opacity:0.3},1300);
		
        $('#player, #player__CSS3').css ({
            left : playerLeft,
            width : 300,
            top : dialogsTop,
            opacity : 1
        });
        $('#player__CSS3').css ({ left : '', top : '', opacity : 0.5 });
        
        $('#infoWindow_mp3desc, #infoWindow_mp3desc__CSS3, #infoWindow_mp3desc__item__0, #infoWindow_mp3desc__item__0__img1, infoWindow_mp3desc__item__0__img2, #infoWindow_mp3desc, #infoWindow_mp3desc').css({
            position : 'absolute',
            width : 300,
            height : (myHeight - 40 - 120) /2                                                                                                                                                                                                                          
        });
        $('#infoWindow_mp3desc').css({
            left : leftOffset + 250 + 20,
            top : dialogsTop + $('#player')[0].offsetHeight + 20,
            width : 300,
            height : ((myHeight - 40 - 120) /2)
        });
        $('#infoWindow_mp3desc__CSS3').css({
            width : 300,
            height : (myHeight - 40 - 120) /2
        });
        $('#mp3descText').css({ marginLeft : 40 });
        
        
        $('#infoWindow_mp3desc > table').css({
            width : '',
            height : ((myHeight - 40 - 120) /2)
        });
	 
        $('#horizontalMover').css({
			left : masterLeftOffset,
            top : 7
		});


        $('#mp3s').css ({
            visibility : 'visible',
            position : 'absolute',
            left : dialogsLeft,
            width : 245,
            height : myHeight ,
            top : dialogsTop
        });
        
        $dialogPlaylist.css ({
            left : leftOffset + 250 + 20,
            width : 300,
            height : (myHeight - 40 - 120 - $('#titlebar').height()) /2,
            top : ($dialogMP3desc[0].offsetTop + $dialogMP3desc.height() + 20) + 'px'
        });
        $('ul', $dialogPlaylist).css ({
            height : 'calc(100% - '+$('h2', $dialogPlaylist).outerHeight()+'px - '+$('h2', $dialogPlaylist).css('marginBottom')+' - '+$('h2', $dialogPlaylist).css('marginBottom')+')'
        });
        
		if (!na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.afterInitializing) {
            na.apps.loaded['/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/musicPlayer'].settings.afterInitializing = true;
            setTimeout (function() {
                $('#horizontalMover').css({
                    width : 610,
                    opacity : 0.001,
                    display : 'block'
                }).animate ({opacity:0.5}, 700);
            }, 100);
        
			$('.vividDialog, .vividScrollpane, #heading_wrapper, #siteIntroText, #mp3s, #player, #player_table, #playlist_wrapper, #infoWindow_help')
				.not ('#siteLoginSuccessful, #siteLoginFailed, #siteLogin, #siteRegistration, #siteDateTime, #infoWindow_info, #infoWindow_tools')
				.animate ({opacity:1}, 'normal');
        }
	}
	
};
//}, 100); // na.m.waitForCondition() (see top of this file)
