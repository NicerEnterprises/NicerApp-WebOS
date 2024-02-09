
na.apps = {
    loaded : {}
};

na.m = {
    globals : {
        debugEvents : false
    },

    settings : {
        debugLevel : 1099,// max level shown, use the following to show all msgs (leads to cluttering of console.log) : //'show all',
        debugCategoriesVisible : [ 'all' ],
        waitForCondition : {},
		cloneObject : {
			circulars : []
		},
		cloneObjectAsync : {
			commands : []
		}
    },

    handleGalleryLinkClick : function(e){
        e.preventDefault();
        const $thisLink = e.currentTarget;
        const linkID = $thisLink.dataset.id;
        let curStorage = localStorage.getItem("visitedItems");
        if (curStorage) {
            //ADD:
            //create an array from comma separated string
            //(i.e. 'item1,item2,item3')
            curStorage = curStorage.split(",");
        } else {
            //ADD:
            curStorage = []; //create new array
        }
        //ADD:
        if (!curStorage.includes(linkID)) { //if ID is not in storage...
            curStorage.push(linkID); //add it...
            //then resubmit the local storage entry as a string...
            localStorage.setItem("visitedItems", curStorage.toString());
        }
    },

    adjustColorOpacity : function (el, opacityValue) {
        var
        rgbaRegEx = /rgba\((\d{1,3})\,\s*(\d{1,3})\,\s*(\d{1,3})\,\s*([\d\.]+)\)(.*)/,
        rgbRegEx = /rgb\((\d{1,3})\,\s*(\d{1,3})\,\s*(\d{1,3})\)(.*)/,
        bg = $(el).css('background');
        if (bg.match(rgbRegEx)) {
            var x = bg.match(rgbRegEx);
            if (x)
                var rgba = 'rgba('+x[1]+','+x[2]+','+x[3]+','+opacityValue+')';
            else
                var rgba = false;
            return rgba;
        } else {
            if (x)
                var rgba = 'rgba('+x[1]+','+x[2]+','+x[3]+','+opacityValue+')';
            else
                var rgba = false;
            return rgba;
        }
    },

	preventScreenLock : function () {
		// Create the root video element
		var video = document.createElement('video');
		video.setAttribute('loop', '');
		// Add some styles if needed
		video.setAttribute('style', 'position: fixed;');

		// A helper to add sources to video
		function addSourceToVideo(element, type, dataURI) {
    			var source = document.createElement('source');
    			source.src = dataURI;
    			source.type = 'video/' + type;
    			element.appendChild(source);
		}

		// A helper to concat base64
		var base64 = function(mimeType, base64) {
    			return 'data:' + mimeType + ';base64,' + base64;
		};

		// Add Fake sourced
		addSourceToVideo(video,'webm', base64('video/webm', 'GkXfo0AgQoaBAUL3gQFC8oEEQvOBCEKCQAR3ZWJtQoeBAkKFgQIYU4BnQI0VSalmQCgq17FAAw9CQE2AQAZ3aGFtbXlXQUAGd2hhbW15RIlACECPQAAAAAAAFlSua0AxrkAu14EBY8WBAZyBACK1nEADdW5khkAFVl9WUDglhohAA1ZQOIOBAeBABrCBCLqBCB9DtnVAIueBAKNAHIEAAIAwAQCdASoIAAgAAUAmJaQAA3AA/vz0AAA='));
		addSourceToVideo(video, 'mp4', base64('video/mp4', 'AAAAHGZ0eXBpc29tAAACAGlzb21pc28ybXA0MQAAAAhmcmVlAAAAG21kYXQAAAGzABAHAAABthADAowdbb9/AAAC6W1vb3YAAABsbXZoZAAAAAB8JbCAfCWwgAAAA+gAAAAAAAEAAAEAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIAAAIVdHJhawAAAFx0a2hkAAAAD3wlsIB8JbCAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAIAAAACAAAAAABsW1kaWEAAAAgbWRoZAAAAAB8JbCAfCWwgAAAA+gAAAAAVcQAAAAAAC1oZGxyAAAAAAAAAAB2aWRlAAAAAAAAAAAAAAAAVmlkZW9IYW5kbGVyAAAAAVxtaW5mAAAAFHZtaGQAAAABAAAAAAAAAAAAAAAkZGluZgAAABxkcmVmAAAAAAAAAAEAAAAMdXJsIAAAAAEAAAEcc3RibAAAALhzdHNkAAAAAAAAAAEAAACobXA0dgAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAIAAgASAAAAEgAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABj//wAAAFJlc2RzAAAAAANEAAEABDwgEQAAAAADDUAAAAAABS0AAAGwAQAAAbWJEwAAAQAAAAEgAMSNiB9FAEQBFGMAAAGyTGF2YzUyLjg3LjQGAQIAAAAYc3R0cwAAAAAAAAABAAAAAQAAAAAAAAAcc3RzYwAAAAAAAAABAAAAAQAAAAEAAAABAAAAFHN0c3oAAAAAAAAAEwAAAAEAAAAUc3RjbwAAAAAAAAABAAAALAAAAGB1ZHRhAAAAWG1ldGEAAAAAAAAAIWhkbHIAAAAAAAAAAG1kaXJhcHBsAAAAAAAAAAAAAAAAK2lsc3QAAAAjqXRvbwAAABtkYXRhAAAAAQAAAABMYXZmNTIuNzguMw=='));

		// Append the video to where ever you need
		document.body.appendChild(video);

		// Start playing video after any user interaction.
		// NOTE: Running video.play() handler without a user action may be blocked by browser.
		var playFn = function() {
			if (!video.playing) {
    				video.play();
				delete video.playing;
    				this.removeEventListener('touchend', playFn);
				delete this.hasTouch;
			}
		};
		setInterval (function() {
			$('div').each(function(idx,div) {
				if (!div.hasTouch) {
					div.addEventListener('touchend', playFn);
					div.hasTouch = true;
				}
			});
		}, 1000);
	},

    base64_encode_url : function (str) {
        var str2 = btoa(str);
        str2 = str2.replace (/=/g, '');
        str2 = str2.replace ('+', '-');
        str2 = str2.replace ('/', '_');
        return str2;
    },

    base64_decode_url : function (str) {
        var str2 = str;
        str2 = str2.replace ('-', '+');
        str2 = str2.replace ('_', '/');
        try {
            var r = atob(str2);
        } catch (error) {
            var r = '{-- na.m.base64_decode_url() : str is not valid base64 data when URL decoded. str='+str+', error.message='+error.message + ' --}';
        };
        return r;
    },

    is_null : function (val) {
        return (val === null);
    },

    is_string : function (val) {
        return typeof val == 'string' && val !== '';
    },

    cookieOptions : function () {
        var d = new Date();
        return {
            expires : new Date(d.getTime() + 10 * 365 * 24 * 60 * 60 * 1000), // 10 years from now
            path : '/'
        };
    },

    clearCookies : function () {
        var fncn = 'na.site.clearCookies()';
        $.cookie('AuthSession', null, na.m.cookieOptions());
        $.cookie('siteBackground_search', 'landscape', na.m.cookieOptions());
        var defaultBG = '/NicerAppWebOS/siteMedia/backgrounds/tiled/grey/cracked-surface-seamless-gray-background.jpg';
        $.cookie('siteBackground_url', defaultBG, na.m.cookieOptions());
        //$.cookie('cdb_loginName', 'Guest', na.m.cookieOptions());
        $.cookie('selectedBoxShadowID', 'boxShadow_0', na.m.cookieOptions());
        $.cookie('visible_siteToolbarTop','', na.m.cookieOptions());
        $.cookie('visible_siteToolbarLeft','', na.m.cookieOptions());
        $.cookie('visible_siteToolbarRight','', na.m.cookieOptions());
        $.cookie('visible_siteContent','true', na.m.cookieOptions());
        $.cookie('visible_siteStatusbar','true', na.m.cookieOptions());
        $.cookie('visible_siteSiteDateTime','true', na.m.cookieOptions());
        $.cookie('visible_siteBtnOptions','true', na.m.cookieOptions());
        $.cookie('visible_siteBtnLoginLogout','true', na.m.cookieOptions());
        $.cookie('visible_siteBtnBackground','true', na.m.cookieOptions());
        $.cookie('haveShownTutorial', 0, na.m.cookieOptions());
        var
        url2 = document.location.href.replace(document.location.origin,'').replace(document.location.host,'').replace('/apps/', ''),
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
                setTimeout(function() {
                    var evt = { currentTarget : $('#specificity')[0] };

                    if (na.site.globals.themesDBkeys) na.te.specificitySelected(evt);

                    na.site.loadTheme(function() {
                        var btn = $('#'+na.te.settings.current.selectedButtonID)[0];

                        $('.vividDialog'/*, vdc[0]*/).each(function(idx,el){
                            na.site.settings.dialogs['#'+el.id] = new naVividDialog(el);
                        });
                        //na.te.onclick(btn, false);

                        //debugger;
                        if (
                            typeof $.cookie('cdb_loginName')=='string'
                            && $.cookie('cdb_loginName')=='Guest'
                        ) {
                                na.site.globals.backgroundSearchKey = $.cookie('siteBackground_search');
                                na.site.globals.background = $.cookie('siteBackground_url');
                        } ;
                        na.backgrounds.next (
                            '#siteBackground',
                            na.site.globals.backgroundSearchKey,
                            na.site.globals.background,
                            false
                        );

                        na.site.success ('Site reverted to factory settings');

                        if (typeof callback=='function') callback (themeData, data);
                    });
                }, 50);//250
            },
            error : function (xhr, textStatus, errorThrown) {
                na.site.ajaxFail(fncn, url3, xhr, textStatus, errorThrown);
            }
        };
        setTimeout (function() {
            $.ajax(ac2);
        }, 50);
    },

    randomString : function () {
        return Math.random().toString(36).substr(2, 20);
    },

	secondsToTime : function (secs) {
		//thx
		// http://codeaid.net/javascript/convert-seconds-to-hours-minutes-and-seconds-%28javascript%29
		//and
		// http://stackoverflow.com/questions/175554/how-to-convert-milliseconds-into-human-readable-form
		var days = Math.floor(secs / (60 * 60 * 24));
		var hours = Math.floor(secs / (60 * 60));
		var divisor_for_minutes = secs % (60 * 60);
		var minutes = Math.floor(divisor_for_minutes / 60);
		var divisor_for_seconds = divisor_for_minutes % 60;
		var seconds = Math.floor(divisor_for_seconds);
		var milliSeconds = Math.round((secs - Math.floor(secs)) * 1000);

		var obj = {
			days : days,
			hours: hours,
			minutes: minutes,
			seconds: seconds,
			milliSeconds : milliSeconds
		};

		return obj;
	},

	secondsToTimeString : function (secs) {
		var d = na.m.secondsToTime(secs);
		var s = '';
		if (d.days>0) {
			s += d.days + 'd';
		};
		if (d.hours>0) {
			if (s!='') s+=', ';
			s += d.hours + 'h';
		};
		if (d.minutes>0) {
			if (s!='') s+=', ';
			s += d.minutes + 'm';
		};
		if (d.seconds>0) {
			if (s!='') s+=', ';
			s += d.seconds + 's';
		};
		if (d.milliSeconds>0) {
			if (s!='') s+=', ';
			s += d.milliSeconds + 'ms';
		};
		return s;
	},

    dateObj_toDateString : function (dateObj, includeTimezone) {
        var dns = Date.locale.en.day_names;

        //includeTimezone = false; // uncomment this if you want to reduce console.log line length
        if (includeTimezone !== false) includeTimezone = true;


        return dateObj.getFullYear() + "-" +
            ("0" + (dateObj.getMonth()+1)).slice(-2) + "-" +
            ("0" + dateObj.getDate()).slice(-2) + "(" + dns[dateObj.getDay()] + ') ' +
            ("0" + dateObj.getHours()).slice(-2) + ":" +
            ("0" + dateObj.getMinutes()).slice(-2) + ":" +
            ("0" + dateObj.getSeconds()).slice(-2) +
            (
                includeTimezone
                    ? ' (UTC' + (-1*dateObj.getTimezoneOffset())+'m)'
                    : ''
            );
    },

    log : function (level, msg, includeBacktrace) {
        if (!na.m.settings.siteStartTime) {
            var date = new Date();
            na.m.settings.siteStartTime = date.getTime();
        };
        if (msg && msg.msg) msg = msg.msg;

        if (includeBacktrace!==false) includeBacktrace = true;

        if (msg.indexOf('startup :')!==-1) includeBacktrace = false;


        var
        date = new Date(),
        timeInMilliseconds = date.getTime(),
        appRunTime = timeInMilliseconds - na.m.settings.siteStartTime,

        timeString_runningPage = na.m.secondsToTimeString (appRunTime / 1000),
        timeString_now = na.m.dateObj_toDateString (date),
        timeString = timeString_now+' (@'+timeString_runningPage+' now)',
        stacktrace = na.m.stacktrace();

        if (!na.m.settings.logLine) na.m.settings.logLine = 1; else na.m.settings.logLine++;

        if (na.m.settings.debugLevel == 'show all') na.m.settings.debugLevel = 0;
        if (level <= na.m.settings.debugLevel) {
            if (typeof msg=='object') {
                //msg.runtimeInMilliseconds = appRunTime;
                msg.line = na.m.settings.logLine;
                msg.time = timeString;
                if (includeBacktrace) msg.stacktrace = stacktrace;
                if (na.m.settings.debugCategoriesVisible.includes('all')) {
                    console.log (msg);
                } else {
                    var writtenAlready = false;
                    for (var cat in msg.categories) {
                        if (na.m.settings.debugCategoriesVisible.includes(cat)
                            && !writtenAlready
                        ) {
                            console.log (msg);
                            writtenAlready = true
                        }
                    }
                }
            } else if (typeof msg=='string') {
                if (includeBacktrace) {
                    var msgOriginal = msg;
                    msg = 'line'+na.m.settings.logLine+':'+timeString + ' : ('+level+') '+msg+'\n'+stacktrace;
                    console.log (msg);
                    msg = {
                        time : timeString,
                        level : level,
                        msg : msg,
                        stacktrace : stacktrace
                    };
                } else {
                    var msgOriginal = msg;
                    msg = 'line'+na.m.settings.logLine+':'+timeString + ' : ('+level+') '+msg;
                    console.log (msg);
                    msg = {
                        time : timeString,
                        level : level,
                        msg : msg
                    };
                }
            }
        };

        return msg;
    },


	padNumber : function (number, characterPositions, paddingWith) {
		var
		r = '' + number,
		padding = '';
		for (var i=0; i<characterPositions-r.length; i++) {
			padding += paddingWith;
		};
		r = padding + number;
		return r;
	},

	userDevice : {
		isPhone :
                navigator.userAgent === 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1' // iPhone 8 and iPhone 8 Plus
                || navigator.userAgent === 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1' // iPhone 7 and iPhone 7 Plus
                || navigator.userAgent === 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36' // iPhoneX and iPhoneX Plus
                || navigator.userAgent.match(/Moto/)
				|| navigator.userAgent.match(/iPhone/i)
				|| navigator.userAgent.match(/iPad/i)
				|| navigator.userAgent.match(/Mobile Safari/i)
				|| navigator.userAgent.match(/BlackBerry/i)
				|| navigator.userAgent.match(/PlayStation/i)
				|| navigator.userAgent.match(/IEMobile/i)
				|| navigator.userAgent.match(/Windows CE/i)
				|| navigator.userAgent.match(/Windows Phone/i)
				|| navigator.userAgent.match(/SymbianOS/i)
				|| navigator.userAgent.match(/Android/i)
				|| navigator.userAgent.match(/PalmOS/i)
				|| navigator.userAgent.match(/PalmSource/i)
				|| navigator.userAgent.match(/SonyEricsson/i)
				|| navigator.userAgent.match(/Opera Mini/i)
				|| navigator.userAgent.match(/Vodafone/i)
				|| navigator.userAgent.match(/DoCoMo/i)
				|| navigator.userAgent.match(/AvantGo/i)
				|| navigator.userAgent.match(/J-PHONE/i)
				|| navigator.userAgent.match(/UP.Browser/i)
	},

    waitForCondition_blacklisted (label) {
		var
		_fncn = 'na.m.waitForCondition(): ',
		blacklistedEntries = [
            /na.desktop.masterCallback/,
            /ready to animate next DIV/
		];
        for (var i=0; i < blacklistedEntries.length; i++) {
            var ble = blacklistedEntries[i];
            if (label.match(ble)) return true;
        }
        return false;
    },

	waitForCondition : function (label, condition, callback, frequency, context) {
		var
		_fncn = 'na.m.waitForCondition(): ',
		blacklistedEntries = [
            /na.desktop.masterCallback/,
            /ready to animate next DIV/
		];
		if (typeof label!=='string') { na.m.log (1, _fncn+' : invalid label' ); return false;};
		if (typeof condition!=='function') { na.m.log (1, _fncn+' : invalid condition' ); return false; };
		if (typeof callback!=='function') { na.m.log ( 1, _fncn+' : invalid callback' ); return false; };

        // keep your condtions() REAL fast to execute, and you'll be fine with the following enforced defaults.
        // these defaults keep the entire system as a whole nice & fast :)
        if (typeof frequency=='undefined' || frequency<20) frequency = 20;
        //if (frequency > 30) frequency = 30;

        /*
        if (!na.m.settings.waitForCondition_reportsIssued) na.m.settings.waitForCondition_reportsIssued = setInterval (function () {
            if (!blacklistedEntries.includes(label)) na.m.waitForCondition_report_whatAmIwaitingFor(blacklistedEntries);
        }, 200); // report every 200 milli-seconds, if there's anything to report
        */

		var r = condition(context);


        if (!r && !condition.listed && !na.m.waitForCondition_blacklisted(label)) {
            condition.listed = true;
            na.m.log (554, 'na.m.waitForCondition() : ADDED : "'+label+'"', false);
        }

		if (r) {
            // condition()==true, we're done waiting
            if (!na.m.waitForCondition_blacklisted(label)) {
                na.m.log (554, 'na.m.waitForCondition() : SATISFIED : "'+label+'"', false);
            }

			clearTimeout (na.m.settings.waitForCondition[label]);
			delete na.m.settings.waitForCondition[label];
			callback();

            var r = na.m.waitForCondition_report_whatAmIwaitingFor(blacklistedEntries);
            if (r) na.m.log (555, r, false);
		} else {
            // condition()==false, more waiting
            var
            now = new Date().getTime(),
            startTime = na.m.settings.startTime,
            lastMsg = na.m.settings.lastMsg_waitForCondition;



            var currentMsg = na.m.waitForCondition_report_whatAmIwaitingFor(blacklistedEntries);

            if (currentMsg !== lastMsg) {
                na.m.settings.lastMsg_waitForCondition = currentMsg;

                if (!na.m.settings.timeLapsed_sinceLastWaitForConditionsReportChange)
                    na.m.settings.timeLapsed_sinceLastWaitForConditionsReportChange = now;

                if (na.m.settings.timeLapsed_sinceLastWaitForConditionsReportChange > now - 5 * 1000)
                    if (currentMsg) na.m.log (555, currentMsg, false);

                na.m.settings.timeLapsed_sinceLastWaitForConditionsReportChange = now;
            }



            if (na.m.settings.waitForCondition[label]) clearTimeout(na.m.settings.waitForCondition[label]);
			//if (!na.m.settings.waitForCondition[label]) { // prevents double checks & activations of callback().
				na.m.settings.waitForCondition[label] = setTimeout (function () {
					clearTimeout (na.m.settings.waitForCondition[label]);
					delete na.m.settings.waitForCondition[label];
					na.m.waitForCondition (label, condition, callback, frequency, context);
				}, frequency);
			//}
		}
		return r;
	},

    waitForCondition_report_whatAmIwaitingFor : function (blacklistedEntries) {
        //if (!na.site.settings.current.timeout_waitForCondition_reporting)
        //na.site.settings.current.timeout_waitForCondition_reporting = setTimeout (function() {
                var
                entries = [],
                allKeys = Object.keys(na.m.settings.waitForCondition);
                for (var i=0; i < allKeys.length; i++) {
                    var k = allKeys[i];
                    if (!blacklistedEntries.includes(k)) entries.push(k);
                };
                delete na.site.settings.current.timeout_waitForCondition_reporting;

                if (entries.length > 0)
                    return 'na.m.waitForCondition() : currently waiting for conditions '+JSON.stringify(entries, null, 4);
                else return false;
                    //na.m.log (555, 'na.m.waitForCondition() : currently waiting for conditions '+JSON.stringify(entries, null, 4), false );
        //}, 500);
    },

    conditionExists : function (label) {
        return label in na.m.settings.waitForCondition;
    },

    walkArray : function (rt, a, keyCallback, valueCallback, callKeyForValues, callbackParams, k, level, path) {
        if (!path) path = '';
        if (typeof a !== 'object') {
            //debugger;
        } else {
            for (var k in a) {
                var
                v = a[k],
                cd = {
                    type : 'key',
                    path : path,
                    level : level,
                    root : rt,
                    at : a,
                    k : k,
                    v : v,
                    params : callbackParams
                };
                if (typeof v=='object' && v!==null && typeof v.length=='number') continue;
                if (typeof keyCallback=='function' && (callKeyForValues || typeof v==='object')) keyCallback (cd);
                if (typeof v==='object') {
                    cd.type = 'value';
                    if (typeof valueCallback=='function') valueCallback(cd);
                    na.m.walkArray (rt, a[k], keyCallback, valueCallback, callKeyForValues, callbackParams, k, level+1, path+'/'+k);
                } else {
                    cd.type = 'value';
                    if (typeof valueCallback=='function') valueCallback(cd);
                }
            }
        }
    },

    chaseToPath : function (wm, path, create) {
        var
        nodes = path.split('/');

        return na.m.chase (wm, nodes, create);
    },

    chase : function (arr, indexes, create) {
        var
        r = arr;

        for (var i=0; i<indexes.length; i++) {
            var idx = indexes[i];
            if (
                typeof r === 'object'
                && (
                    create === true
                    || r[idx]
                )
            ) {
                if (create===true && !r[idx]) r[idx]={};
                r = r[idx];
            }
        }

        return r;
    },

	negotiateOptions : function () {
		// na.m.negotiateOptions() can't handle functions, and I dont trust $.extend
		var r = {};
		for (var i = 0; i < arguments.length; i++) {
			var a = arguments[i];
			if (typeof a=='object' && a!==null && typeof a.length=='number') r =[];
			if (a===null || typeof a==='undefined') continue;
			for (k in a) {
				if (typeof a[k] == 'object') {
					r[k] = na.m.negotiateOptions(r[k], a[k]);
				} else {
					r[k] = a[k];
				}
			}
		}
		return r;
	},

    extend : function () {
		var r = arguments[0];
		for (var i = 1; i < arguments.length; i++) {
			var a = arguments[i];
			if (typeof a=='object' && a!==null && typeof a.length=='number') r =[];
			if (a===null || typeof a==='undefined') continue;
			for (k in a) {
				if (typeof a[k] == 'object') {
                    if (!r[k]) r[k] = {};
					r[k] = na.m.extend(r[k], a[k]);
				} else {
					r[k] = a[k];
				}
			}
		}
		return r;
    },

    changedDateTime_current : function () {
        var
        d = new Date(),
        r = d.getFullYear()
            + ('0' + (d.getMonth()+1)).slice(-2)
            + ('0' + d.getDate()).slice(-2)
            + ('0' + d.getHours()).slice(-2)
            + ('0' + d.getMinutes()).slice(-2)
            + ('0' + d.getSeconds()).slice(-2);
        return r;
    },

	elapsedMilliseconds: function () {
		//thanks to http://www.web-source.net/javascript_tutorial2.htm
		var n = new Date();
		var s = n.getTime(); // Grab current millisecond #
		var diff = s - na.m.settings.startTime;
		return diff;
	},

	hookScrollwheel : function (el, handler, useCapture, add) {
		if (add) {
            if (el.addEventListener) {
				var r = el.addEventListener ('DOMMouseScroll', handler, true);
				var r = el.addEventListener ('mousewheel', handler, true);
				var r = el.addEventListener ('wheel', handler, true);
			} else {
				el.onmousewheel = handler;
			}
		} else {
			if (el.removeEventListener) {
				//el.removeEventListener ('scroll', handler, true);
				el.removeEventListener ('DOMMouseScroll', handler, true);
				el.removeEventListener ('mousewheel', handler, true);
				el.removeEventListener ('wheel', handler, true);
			} else {
				el.onmousewheel = null;
			}
		}
	},

    stacktrace : function () {
        return (function () { return (new Error().stack); })().replace(/Error\s*\n*\r*/,'');
    },




/*
     BEGIN newEventChain()

     newEventChain() and runFunctions() and it's affiliate functions are used by
     na.site.loadContent() and it's affiliate functions.

     (1) a chain holds multiple events.

     (2) an event holds multiple functions.

     (3) all functions for an event are fired near-simultaneously, in-order, waiting for each other
     by means of na.m.waitForCondition().

     (4) all functions for an event must complete, for the next event to be fired.

*/
    newEventChain : function (dt, rootEventData, displayStatusUpdates) {
        // this returns a NicerApp WCS event chain, which may *include* HTML event data,
        // but which is also in total far more data than a single HTML event.

        if (displayStatusUpdates!==false) displayStatusUpdates = true;

        var r = {
            about : { whatsThis : 'NicerApp WCS event chain data' },
            displayStatusUpdates : displayStatusUpdates,
            dt : { created : dt },
            events : [ na.m.newEvent(dt, rootEventData) ]
        };
        return r;
    },

    runFunctions : function (naEventsChain, updateEvent_returnValue) {
        var functionsAdded = false;
        for (var eventID in updateEvent_returnValue) {
            var naEventData = updateEvent_returnValue[eventID];
            if (!naEventData.newFunctions && typeof naEventData.functions=='object') naEventData.newFunctions= naEventData.functions;

            if (naEventData && naEventData.newFunctions && naEventData.newFunctions.length > 0) {
                for (var i=0; i < naEventData.newFunctions.length; i++) {
                    var ed = naEventData.newFunctions[i];
                    ed.labels = naEventData.labels;

                    var naEvent = na.m.findEvent (naEventsChain, eventID);
                    naEvent.completed = false;
                    naEvent.runningNow = false; // MUST BE !!!! FALSE !!!!
                    if (naEvent) {
                        functionsAdded = true;
                        naEvent.functions.push (ed);
                    }

                    /*
                    if (!naEvent)
                        naEventsChain.events.push (naEventData);
                    else
                        naEvent = $.extend(naEvent, naEventData);
                    */
                }
            }
        };

        if (na.m.settings.timeout_runFunctions) clearTimeout (na.m.settings.timeout_runFunctions);
        na.m.settings.timeout_runFunctions = setTimeout (function(naEventsChain, functionsRecentlyAdded) {
            var
            crv = na.m.continueRunningEvents (naEventsChain),
            r = functionsRecentlyAdded || crv;
        }, 250, naEventsChain, functionsAdded);

        //return r; // CAN'T USE THIS ANYWHERE! NOT A PROBLEM THOUGH..
    },

    updateEvent : function (dt, naNewEventData) {
        return na.m.newEvent (dt, naNewEventData);
    },

    newEvent : function (dt, naEventData) { // dt is the date and time in dateObj and timeString format
        // this returns a NicerApp WCS event, not a HTML event.
        var
        r = {},
        st = na.m.stacktrace();
        if (typeof naEventData!=='object') debugger;
        for (var eventID in naEventData) {
            var evd = naEventData[eventID];
            if (typeof evd!=='object' || !evd.newFunctions || !evd.newFunctions.length) {
                if (typeof evd=='object' && typeof evd.functions=='object') evd.newFunctions = evd.functions; else {debugger;return false;};
            };
            if (!evd || !evd.newFunctions || typeof evd.newFunctions.length!=='number') debugger;

            if (!r[eventID]) r[eventID] = {
                labels : evd.labels,
                functions : [],
                params : evd.params,
                dt : {
                    created : dt,
                    start : {},
                    completed : {}
                },
                reports : { plaintext : [] },
                ecEventID : eventID
            };


            // yes, evd.newFunctions lists naEvents, not naEventFunctions :
            for (var functionCollectionIdx=0; functionCollectionIdx < evd.newFunctions.length; functionCollectionIdx++) {
                var fData = evd.newFunctions[functionCollectionIdx];
                if (!fData) debugger;

                for (var functionCollectionID in fData) {
                    var fd = fData[functionCollectionID];

                    for (var functionIdx=0; functionIdx < fd.length; functionIdx++) {
                        var fData = fd[functionIdx];
                        if (!fData) fData = {};

                        if (!evd.labels) debugger;
                        fData.labels = evd.labels;
                        fData.labels.marker.whatsThis
                            += ' : eventID='+eventID+ ', functionCollectionIdx='+functionCollectionIdx+', '
                            +'functionCollectionID='+functionCollectionID+', functionIdx='+functionIdx;
                        fData.labels.marker.stacktrace = st;
                        r[eventID].functions.push(fData);
                    }
                }
            };
        };
        return r;
    },

    newEventFunction : function (fnc, params) {
        var r = {
            fnc : fnc
        };
        if (typeof params=='object') r.params = params;
        if (typeof fnc!=='function') r.completed = true;
        return r;
    },

    continueRunningEvents : function (ec) {
        var
        er = ec.events[0].root,
        r = false;

        for (var evIdx=0; evIdx < ec.events.length; evIdx++) {
            var ecev = ec.events[evIdx];
            for (var ecEventID in ecev) {
                if (ecEventID=='about' || ecEventID=='fncn') continue;
                if (ecEventID=='marker') continue;

                var naEventData = ecev[ecEventID];

                if (naEventData.reports) {
                    report = naEventData.reports.plaintext;
                    //if (naEventData.reports) report.push (
                        //na.m.log (22, 'na.m.runEvents() : called (or called again for this ecEventID='+ecEventID+').', false);
                    //}
                };

                if (naEventData.completed) {
                    na.m.closeEvent (ec, evIdx);
                    continue;
                }

                if (!naEventData.completed && naEventData.runningNow) {
                    if (na.m.globals.debugEvents)
                    na.m.log(
                        31, 'na.m.runEvents() : already running ec.labels.marker.whatsThis="'+er.labels.marker.whatsThis+'", ecEventIdx='+evIdx+', ecEventID='+ecEventID,
                        false
                    )
                }

                if (!naEventData.completed && !naEventData.runningNow) {
                    naEventData.runningNow = true;
                    na.m.log(
                        22,'na.m.runEvents() : now starting ec.labels.marker.whatsThis="'+er.labels.marker.whatsThis+'", ecEventIdx='+evIdx+', ecEventID='+ecEventID,
                        false
                    )

                    na.m.startEvent (ec, evIdx, naEventData);
                    var doneForNow = !na.m.eventFunctionsCheck (ec, evIdx, naEventData);
                    if (doneForNow) {
                        naEventData.runningNow = false;
                        naEventData.completed = true;
                    }
                    //return true;
                    break;
                }
            }
            //break;
        };
        na.m.eventChainCheck (ec);
        return false;
    },

    eventDescriptor : function (ec, eventIdx, eventID, fncIdx, f) {
        //if (!f.fnc.name) debugger;
        var ts = (
            ec.events[0].root.dt.created
            ? ec.events[0].root.dt.created.timeString
            : ec.events[0].root.dt.timeString
        );
        return ec.events[0].root.labels.marker.whatsThis
            +' : event created '+ts
            +', eventIdx='+eventIdx+', eventID='+eventID+', fncIdx='+fncIdx+', fncName='+f.fnc.name
    },

    startEvent : function (ec, eventIdx, ev) {
        var e = ec.events[eventIdx];
        for (var eventID in e) {
            var ev = e[eventID];
            if (ev.functions && ev.functions.length) {
                ev.runningNow = true;
                if (ev.functions.length === 0) {
                    ev.completed = true;
                    setTimeout (function () {
                        na.m.continueRunningEvents (ec);
                    }, 100);
                } else {
                    var allCompleted = true;
                    for (var i=0; i < ev.functions.length; i++) {
                        let
                        f = ev.functions[i],
                        fnc = f.fnc,
                        p = f.params ? f.params : {};

                        if (typeof f.fnc=='function' && f.runningNow) allCompleted = false;
                        if (typeof f.fnc=='function' && !f.completed) allCompleted = false;

                        if (typeof f.fnc=='function' && !f.runningNow && !f.completed) {
                            f.isCurrentEventChain_for__na_site_loadContent = ec.isCurrentEventChain_for__na_site_loadContent;
                            f.na_site_settings_current_loadContent_recentIdx = ec.na_site_settings_current_loadContent_recentIdx;
                            f.ec = ec;
                            f.ecEventIdx = eventIdx;
                            f.ecEventID = eventID;
                            f.fncIdx = i;
                            f.runningNow = true;
                            f.completed = f.fnc (ec, eventIdx, p, f);
                            na.m.log (24,
                                'na.m.startEvent() : now starting '+na.m.eventDescriptor(ec,eventIdx,eventID,i,f)
                                +' : f.completed='+(f.completed?'true':'false')
                            );
                            if (f.completed) f.runningNow = false;
                        }
                    };
                    if (allCompleted) ev.completed = true;
                    //if (ev.completed) na.m.closeEvent (ec, eventIdx, f);
                }
            } else {
                ev.completed = true;
                //na.m.closeEvent (ec, eventIdx, f);
            }
        }
    },

    eventFunctionsCheck : function (ec, i, naEventData) {
        if (naEventData && naEventData.newFunctions && !naEventData.functions) naEventData.functions = naEventData.newFunctions;
        if (naEventData && naEventData.functions && naEventData.functions.length) {
            for (var evIdx=0; evIdx < naEventData.functions.length; evIdx++) {
                var evf = naEventData.functions[evIdx];
                if (!evf.completed) return false;
            }
        }
        return true;
    },

    endEvent : function (ec, eventIdx, p, f) {
        debugger;
        f.runningNow = false;
        f.completed = true;
        ec.events[eventIdx].completed = true;
        return true;
    },

    closeEvent : function (ec, eventIdx, f) {
        if (f && f.completed) f.runningNow = false;
        //na.m.eventChainCheck (ec);
    },

    eventChainCheck : function (ec) {
        var
        numRootEvents = ec.events.length,
        numRootCompletedEvents = 0,

        numRootFunctions = 0,
        numFunctions = 0,
        numCompletedFunctions = 0,

        numEvents = 0,
        numCompletedEvents = 0,

        validFunctions = [],
        invalidFunctions = [],

        dateObj = new Date(),
        timeInMilliseconds = dateObj.getTime(),
        appRunTime = timeInMilliseconds - na.m.settings.siteStartTime,
        timeString_runningPage = na.m.secondsToTimeString (appRunTime / 1000),
        timeString_now = na.m.dateObj_toDateString (dateObj),
        timeString = timeString_now+' (@'+timeString_runningPage+' now)',
        dt = { dateObj : dateObj, timeString : timeString };

        for (var i=0; i < ec.events.length; i++) {
            for (var eventID in ec.events[i]) {
                var
                e = ec.events[i][eventID],
                evs = e.events;

                if (e.functions && e.functions.length)
                for (var j=0; j < e.functions.length; j++) {
                    var f = e.functions[j];
                    //if (typeof f.fnc=='function') {
                        numRootFunctions++;
                    //}
                }
            }
        }

        //debugger;
        for (var i=0; i < ec.events.length; i++) {

            for (var eventID in ec.events[i]) {
                numEvents++;

                var
                e = ec.events[i][eventID],
                evs = e.events,
                validFunctions = [],
                invalidFunctions = [];

                if (e.functions && e.functions.length) {
                    var eventNumCompletedFunctions = 0;
                    for (var j=0; j < e.functions.length; j++) {
                        var f1 = e.functions[j];

                        if (typeof f1.fnc=='function') {
                            validFunctions.push ({
                                ec : ec,
                                eventIdx : i,
                                eventID : eventID,
                                f1 : f1
                            });
                        } else {
                            invalidFunctions.push ({
                                ec : ec,
                                eventIdx : i,
                                eventID : eventID,
                                f1 : f1
                            });
                        };
                        if (
                            f1.ignoreThis
                            || f1.completed
                            || ( f1.fnc && f1.fnc.completed )
                        ) {
                            if (!f1.dt) f1.dt = {};
                            f1.dt.completed = dt;
                            numCompletedFunctions++;
                            eventNumCompletedFunctions++;
                        }

                        if (eventNumCompletedFunctions === e.functions.length) {
                            //debugger;
                            e.dt = dt;
                            e.completed = true;
                            numCompletedEvents++;
                        }
                    };
                } else {
                    numCompletedEvents++;
                }
            }
        };

        //na.m.log (30, 'na.m.eventChainCheck() : report=\n'+na.m.makePlaintextReportForEventChain(ec));
        //na.m.log (33, 'na.m.eventChainCheck() : numCompletedFunctions='+numCompletedFunctions+', numRootFunctions='+numRootFunctions, false);
        //na.m.log (33, 'na.m.eventChainCheck() : numCompletedFunctions='+numCompletedFunctions+', validFunctions.length='+validFunctions.length, false);

        var debugMe = false;
        if (!na.m.settings.completedFunctions) na.m.settings.completedFunctions = 0;
        if ( numCompletedFunctions === numRootFunctions ) {
            if (debugMe) debugger;
            setTimeout (function() {
                na.m.closeEventChain (ec);
            }, 50);
        } else if (
            numCompletedFunctions < validFunctions.length
            && numCompletedFunctions >= na.m.settings.completedFunctions
        ) {
            if (debugMe) debugger;

            setTimeout (function() {
                na.m.settings.completedFunctions++;
                na.m.continueRunningEvents (ec);
            }, 100);
        } else {
            if (debugMe) debugger;
            // functions are still running
            if (na.m.settings.timeout_checkChainAgain) clearTimeout (na.m.settings.timeout_checkChainAgain);
            na.m.settings.timeout_checkChainAgain = setTimeout (function(ec) {
                var
                //msg = 'endless loop whatsThis='+ec.events[0].root.labels.marker.whatsThis+', stacktrace=\n'+ec.events[0].root.labels.marker.stacktrace,
                msg = 'endless loop whatsThis='+ec.events[0].root.labels.marker.whatsThis;
                //console.log ('na.m.eventChainCheck() : '+msg);

                na.m.eventChainCheck(ec);
            }, 333, ec);
        }
    },

    closeEventChain : function (ec) {
        /*
        var
        report = {
            plaintext : na.m.makePlaintextReportForEventChain (ec),
            html : na.m.makeHTMLreportForEventChain (ec)
        };
        */
        ec.completed = true;
        na.site.settings.current.loadContent.current.ec = null;
    },

    findEvent : function (ec, eventID) {
        for (var evIdx=0; evIdx < ec.events.length; evIdx++) {
            var  ev = ec.events[evIdx];

            for (var evID in ev) {
                if (eventID===evID) return ec.events[evIdx][evID];
            }
        };
        return false;
    },

    makeEventsChain_theCurrentOne : function (lc, ec) {
        var
        lcr = lc.recent,
        lcc = lc.current;

        if (lcc && lcc.ec) {
            var ec = lcc.ec;
            delete ec.isCurrentEventChain_for__na_site_loadContent;
            ec.na_site_settings_current_loadContent_recentIdx = lcr.length;

            for (var ecEventIdx=0; ecEventIdx < ec.events.length; ecEventIdx++) {
                var e = ec.events[ecEventIdx];
                for (var eventID in e) {
                    var ev = e[eventID];
                    if (ev.functions && ev.functions.length)
                    for (var i=0; i < ev.functions.length; i++) {
                        var f = ev.functions[i];
                        for (var fncID in f) {
                            delete f.isCurrentEventChain_for__na_site_loadContent;
                            f.na_site_settings_current_loadContent_recentIdx = lcr.length;
                        }
                    }
                }
            };

            lcr.push ({ ec : lcc.ec });
            lcc.ec = ec;
            return true;
        } else {
            lcc.ec = ec;
            return false;
        };
    },

    makePlaintextReportForEventChain : function (ec) {
        var txt = '';
        for (var ecEventIdx=0; ecEventIdx < ec.events.length; ecEventIdx++) {
            var e = ec.events[ecEventIdx];
            for (var eventID in e) {
                var
                ev = e[eventID],
                fc = 0;

                if (ev.functions && ev.functions.length)
                for (var i=0; i < ev.functions.length; i++) {
                    var
                    f = $.extend( {}, ev.functions[i]);

                    na.m.walkArray (f, f,
                        null,
                        na.m.walkArray_makePlaintextReportFor_eventChainFunction__value
                    );

                    if (txt !== '') txt += '\n';
                    txt += '#'+ecEventIdx+' : f='+JSON.stringify(f, null, 4);
                    fc++;
                }
            }
        };
        return txt;
    },
    walkArray_makePlaintextReportFor_eventChainFunction__key : function(cd) {
        if (typeof cd.v=='function') return false;
        if (typeof cd.v=='object' && cd.v!==null && typeof cd.v.length=='number') debugger;
        if (cd.v) {
            var it = cd.v;
        }
    },
    walkArray_makePlaintextReportFor_eventChainFunction__value : function (cd) {
        if (typeof cd.v=='function') return false;
        if (typeof cd.v=='object' && cd.v!==null && typeof cd.v.length=='number') debugger;
        if (cd.v) {
            var it = cd.v;
            if (cd.k=='stacktrace') {
                cd.v = cd.v.replace(/\n/g, '|n');
                cd.v = cd.v.replace(/\r/g, '|r');
                cd.v = cd.v.replace(/\t/g, '|t');
                //debugger;
            }
        }
    },

    findOne : function (haystack, arr) {
        return arr.some(function (v) {
            return haystack.indexOf(v) >= 0;
        });
    },

    makeHTMLreportForEventChain : function (ec) {
        for (var ecEventIdx=0; ecEventIdx < ec.events.length; ecEventIdx++) {
            var e = ec.events[ecEventIdx];
            for (var eventID in e) {
                var ev = e[eventID];
                if (ev.functions && ev.functions.length)
                for (var i=0; i < ev.functions.length; i++) {
                    var f = ev.functions[i];
                    for (var fncID in f) {
                        //debugger;
                    }
                }
            }
        };
    },
// END newEventChain()




    borderWidths : function (el) {
        var
        blw1 = $(el).css('borderLeftWidth'),
        blw2 =
            typeof blw1=='string' && blw1!==''
            ? parseInt(blw1.replace('px',''))
            : 0,
        brw1 = $(el).css('borderRightWidth'),
        brw2 =
            typeof brw1=='string' && brw1!==''
            ? parseInt(brw1.replace('px',''))
            : 0,
        btw1 = $(el).css('borderTopWidth'),
        btw2 =
            typeof btw1=='string' && btw1!==''
            ? parseInt(btw1.replace('px',''))
            : 0,
        bbw1 = $(el).css('borderBottomWidth'),
        bbw2 =
            typeof bbw1=='string' && bbw1!==''
            ? parseInt(bbw1.replace('px',''))
            : 0;
        r = {
            top : btw2,
            left : blw2,
            bottom : bbw2,
            right : brw2
        };
        return r;
    },

    txtReport_callStack : function (callStack) {
        var txt = '';
        for (var i=0; i < callStack.length; i++) {
            if (txt!=='') txt += '\n';
            txt += '\t : '+callStack[i];
        }
        return txt;
    },





    extensionsLoaded : function () {
        $('script', $('head')[0]).each (function (idx, script) {
            if (script.innerText==='') {  return false; }
        });
        return true;
    },

    desktopIdle : function (ctx) {
        var r = (
			typeof na === 'object'
			&& typeof na.site === 'object'
            && !na.desktop.settings.animating
		);
        if (!r && ctx && ctx.debugMe) debugger;
        return r;
    },

    HTMLidle : function(ctx) {
		var
		c = na.site.settings.current,
		r = (
            na.m.desktopIdle()

            // no na.apps.loaded[appID].settings.loadedIn[divID] currently has
            //  any <SCRIPT SRC="https://someSite.tld/script.js"> being loaded into my <HEAD> HTML section

            &&
                c.scriptsToLoad > 0
                ? c.scriptsLoaded === true || c.scriptsLoaded <= c.scriptsToLoad
                : c.scriptsLoaded

            && !c.startingApps

            // no na.apps.loaded[appID].settings.loadedIn[divID] currently has
            //  any <SCRIPT SRC="https://someSite.tld/script.js"> with empty content
            && na.m.extensionsLoaded()

		);
        if (!r && ctx && ctx.debugMe) debugger;
        return r;
    },

    WebOSidle : function (ctx) {
        var
        c = na.site.settings.current,
        r = (
			na.m.HTMLidle(ctx)

            // number of na.apps.loaded[appID].settings.loadedIn[divID].onload() busy === 0
            && c.loadingApps === false
            && c.startingApps === false


            // number of na.apps.loaded[appID].settings.loadedIn[divID].onresize() busy === 0
            && (c.numAppsResized === c.numAppsResizing)
        );
        if (!r && typeof ctx=='object' && ctx.debugMe) debugger;
        return r;
    },

	cloneObject : function (v) {
		var cIdx = na.m.settings.cloneObject.circulars.length;
		na.m.settings.cloneObject.circulars[cIdx] = [];
		return na.m.cloneObject_do(cIdx, v, '');
	},

	cloneObject_circularFound : function (cIdx, v) {
		var c = na.m.settings.cloneObject.circulars[cIdx];
		for (var i=0; i<c.length; i++) {
			if (c[i].v===v) return c[i];
		}
		return false;
	},

	cloneObject_addCircular : function (cIdx, v, path) {
		var c = na.m.settings.cloneObject.circulars[cIdx];
		c[c.length] = {
			v : v,
			path : path
		};
	},

	cloneObject_do: function (cIdx, v, path) {

		if (Array.isArray(v)) {
			// JSON / javascrip simple list aka []
			var test = [];
			for (var i=0; i<v.length; i++) {
				if (v[i] === window) {
					test[i] = '-window node skipped-';
				} else if (v[i] && v[i].tagName) {
					test[i] = '-DOM node skipped-';
				} else {
					var cr = na.m.cloneObject_circularFound(cIdx,v[i]);
					if (typeof cr==='object') {
						test[i] = '-Circular reference skipped- ['+cr.path+']';
					} else {
						//na.m.log (1, path+'/'+x);
						if (typeof v[i] == 'object') {
							if (v[i]!==undefined && v[i]!==null) na.m.cloneObject_addCircular (cIdx, v[i], path+'/'+x);
							test[i] = new na.m.cloneObject_do (cIdx, v[i], path+'/'+x);
						} else {
							test[i] = v[i];
						}
					}
				}
			}

		} else {
			// JSON / javascript folders and subfolders aka {}
			var test = {};
			for (var x in v) {
				if (v[x] === window) {
					test[x] = '-window node skipped-';
				} else if (v[x] && v[x].tagName) {
					test[x] = '-DOM node skipped-';
				} else {
					var cr = na.m.cloneObject_circularFound(cIdx,v[x]);
					if (typeof cr==='object') {
						test[x] = '-Circular reference skipped- ['+cr.path+']';
					} else {
						//na.m.log (1, path+'/'+x);
						if (
							x=='context'
							|| x=='parentNode'
							|| x=='panel'
							|| x=='styleSheets'
							|| x=='defaultView'
						) {
							test[x] = '[skipped] ['+x+']';
						} else if (typeof v[x] == 'object') {
							if (v[x]!==undefined && v[x]!==null) na.m.cloneObject_addCircular (cIdx, v[x], path+'/'+x);
							test[x] = new na.m.cloneObject_do (cIdx, v[x], path+'/'+x);
						} else {
							test[x] = v[x];
						}
					}
				}
			}
		}
		return test;
	},

	reAttachUA : function (uaIdx, func) {
		var ua = na.tracer.userActions[uaIdx];
		func.ua = ua;
		return func;
	},

	cloneObjectAsync : function (cmd) {
		var rscc = na.m.settings.cloneObjectAsync.commands;
		var cmdIdx = rscc.length;
		rscc[cmdIdx] = cmd;
		cmd.result = {};
		cmd.lastPause = 0;
		cmd.lastCheck = 0;
		cmd.countKeys=1;
		if (!cmd.cIdx) {
			cmd.cIdx = na.m.settings.cloneObject.circulars.length;
			na.m.settings.cloneObject.circulars[cmd.cIdx] = [];
		};
	    var queue = [{parent:null,source:cmd.original,target:cmd.result,path:''}];

	    var processQueue = function() {
			if (queue.length==0) {
				cmd.resultCallback(cmd);
			} else {
	        	var it = queue.shift();
			var logStr = 'na.m.cloneObjectAsync(): now copying '+it.path;
		    //na.m.log (1, logStr);
			if (cmd.statusUpdateTo) jQuery('#'+cmd.statusUpdateTo).html(logStr);
			/* todo: attempt to copy members of Array in the correct order
			if (it.source instanceof Array) {
				for (var k=0; k<it.source.length) {
					it.target[k] = it.source[k];
				}
			}
			*/
			//debugger;
			for (var k in it.source) {
					if (/*typeof k!=='number' && */ it.source.hasOwnProperty(k)) {
						if (it.source[k] === undefined) {
							it.target[k] = '[undefined]';
						} else if (typeof it.source[k]=='object' && it.source[k]!==null && it.source[k].contentWindow) {
							it.target[k] = '[iframe node skipped]';
						} else if (it.source[k] == window) {
							it.target[k] = '[window node skipped]';
						} else if (it.source[k] && it.source[k].tagName) {
							it.target[k] = '[DOM node skipped] [id="'+it.source[k].id+'" class="'+it.source[k].className+'" style="'+(it.source[k].style?it.source[k].style.cssText:'')+'"]';
						} else if (
							k=='context'
							|| k=='parent'
							|| k=='parentNode'
							|| k=='panel'
							|| k=='styleSheets'
							|| k=='defaultView'
							|| k=='original'
							|| k=='traced'
							|| k=='userActions'
							|| k=='_request'
							|| k=='circulars'
							|| k=='cloneObjectAsync'
							|| k=='entries'
							/*
							|| (
							    it.path.indexOf ('sa')!==false
							    && it.path.indexOf ('settings')!==false
							)
							|| (
							    it.path.indexOf ('sa')!==false
							    && it.path.indexOf ('json' )!==false
							    && it.path.indexOf ('decode')!==false
							    && it.path.indexOf ('contexts')!==false
							)
							|| (
							    it.path.indexOf ('sa')!==false
							    && it.path.indexOf ('jsonviewer')!==false
							    && it.path.indexOf ('options')!==false
							    && it.path.indexOf ('thisCmd')!==false
							)
							|| (
							    it.path.indexOf ('sa')!==false
							    && it.path.indexOf ('jsonViewer')!==false
							    && it.path.indexOf ('settings')!==false
							)
							|| (
							    it.path.indexOf ('sa')!==false
							    && it.path.indexOf ('vividControls')!==false
							    && it.path.indexOf ('settings')!==false
							    && it.path.indexOf ('fadeCmds')!==false
							)
							|| (
							    it.path.indexOf ('sa')!==false
							    && it.path.indexOf ('tracer')!==false
							    && it.path.indexOf ('traced')!==false
							)
							|| (
							    it.path.indexOf ('sa')!==false
							    && it.path.indexOf ('tracer')!==false
							    //&& it.path.indexOf ('userActions')!==false
							)*/

							|| it.path.indexOf(' / na / settings ')!== -1
							|| it.path.indexOf(' / na / json / decode / contexts ')!== -1
							|| it.path.indexOf(' / na / jsonViewer / options / thisCmd ')!== -1
							|| it.path.indexOf(' / na / jsonViewer / settings ')!== -1
							|| it.path.indexOf(' / na / vividControls / settings / fadeCmds ') !== -1
							|| it.path.indexOf(' / na / tracer / traced ') !== -1
							|| it.path.indexOf(' / na / tracer / userActions ') !== -1
							|| it.path.indexOf(' / steps') !== -1
							|| it.path.indexOf(' / backgrounds') !== -1

						) {
							it.target[k] = '[Dangerously large node skipped; k='+k+', it.path='+it.path+']';
						} else {
							var cr = na.m.cloneObject_circularFound(cmd.cIdx,it.source[k]);
							if (typeof cr==='object') {
								it.target[k] = '[Circular reference skipped] ['+cr.path+']';
							} else {
								cmd.countKeys++;
								//jQuery('#rslv_status2').html (cmd.countKeys + ' - ' + queue.length);
								if (typeof it.source[k]=='object' && it.source[k]!==null && it.source[k]!=undefined) {
									 if (it.source[k]!==undefined && it.source[k]!==null) na.m.cloneObject_addCircular (cmd.cIdx, it.source[k], it.path+' / '+k);
									 it.target[k] = (it.source[k] instanceof Array) ? [] : {};
									queue.push({parent:it.source, source:it.source[k], target:it.target[k],path:it.path+' / '+k});
								} else {
									it.target[k] = it.source[k];
								};
							}
						}
					}
		        };
				//jQuery('#rslv_status2').html (cmd.countKeys + ' - ' + queue.length);
				var pauseFactor = cmd.countKeys;
				if (pauseFactor > cmd.lastPause+200) {
					setTimeout (function () {
						cmd.lastPause = pauseFactor;
						cmd.countKeys++;
			            		processQueue();
					}, 250);
				} else {
					processQueue();
				};


			}
	    };
	    processQueue();
	},

    millisecondsHumanReadable : function (ms, htmlYes) {
      if (typeof htmlYes == 'undefined') htmlYes = true;
      if (ms < 1000) {
        var s = ms + ' milliseconds';
      } else {
        var s = na.m.milliseconds_format(size, htmlYes);

        if (htmlYes) s = '<a href="#" class="hmByteSize" title="' + size + ' bytes" onclick="return false;">' + s + '</a>';
      };
      return s;
    },

    milliseconds_format : function (ms, htmlYes) {
        if (typeof htmlYes == 'undefined') htmlYes = true;
        var pre = '';
        var post = '';
        if (htmlYes) {
            pre = '<span class="millisecondsHumanReadable">';
            post = '</span>';
        }
        if (ms >= 1 * 24 * 60 * 60 * 1000) {
            ms= na.m.number_format(ms / 24*60*60*1000, 2, pre + '.', post, '') + ' days';
        } else if (ms >= 60 * 60 * 1000) {
            ms= na.m.number_format(ms / 60*60*1000, 2, pre + '.', post, '') + ' hours';
        } else if (ms >= 60 * 1000) {
            ms = na.m.number_format(filesize / 60*1000, 2, pre + '.', post, '') + ' minutes';
        } else if (ms >= 1000) {
            ms = na.m.number_format(filesize / 60*1000, 2, pre + '.', post, '') + ' seconds';
        } else ms = '[Time\'s up]';
        return ms;
    },

    sizeHumanReadable: function (size, htmlYes) { // sizeHumanReadable
      if (typeof htmlYes == 'undefined') htmlYes = true;
      if (size < 1024) {
        var s = size + ' bytes';
      } else {
        var s = na.m.size_format(size, htmlYes);

        if (htmlYes) s = '<a href="#" class="hmByteSize" title="' + size + ' bytes" onclick="return false;">' + s + '</a>';
      };
      return s;
    },

    size_format: function (filesize, htmlYes) {
      if (typeof htmlYes == 'undefined') htmlYes = true;
      var pre = '';
      var post = '';
      if (htmlYes) {
        pre = '<span class="sizeHumanReadable">';
        post = '</span>';
      }
      if (filesize >= 1073741824) {
        filesize = na.m.number_format(filesize / 1073741824, 2, pre + '.', post, '') + ' Gb';
      } else {
        if (filesize >= 1048576) {
          filesize = na.m.number_format(filesize / 1048576, 2, pre + '.', post, '') + ' Mb';
        } else {
          if (filesize >= 1024) {
            filesize = na.m.number_format(filesize / 1024, 2, pre + '.', post, '') + ' Kb';
          } else {
            filesize = '';
          };
        };
      };
      return filesize;
    },

    number_format: function (number, decimals, dec_point, dec_point_end, thousands_sep) {
      // http://kevin.vanzonneveld.net
      // +	improved by: seductiveapps@gmail.com (2010/01)
      // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
      // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // +     bugfix by: Michael White (http://crestidg.com)
      // +     bugfix by: Benjamin Lupton
      // +     bugfix by: Allan Jensen (http://www.winternet.no)
      // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
      // *     example 1: number_format(1234.5678, 2, '.', '');
      // *     returns 1: 1234.57
      var n = number,
        c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
      var d = dec_point == undefined ? "," : dec_point;
      var t = thousands_sep == undefined ? "." : thousands_sep,
      s = n < 0 ? "-" : "";
      var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;

      return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "jQuery1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) + dec_point_end : "");
    }


}; // na.m

Date.prototype.getMonthName = function(lang) {
	lang = lang && (lang in Date.locale) ? lang : 'en';
	return Date.locale[lang].month_names[this.getMonth()];
};

Date.prototype.getMonthNameShort = function(lang) {
	lang = lang && (lang in Date.locale) ? lang : 'en';
	return Date.locale[lang].month_names_short[this.getMonth()];
};

Date.prototype.getDayName = function(lang) {
	lang = lang && (lang in Date.locale) ? lang : 'en';
	return Date.locale[lang].day_names[this.getDay()];
};

Date.prototype.getDayNameShort = function(lang) {
	lang = lang && (lang in Date.locale) ? lang : 'en';
	return Date.locale[lang].day_names_short[this.getDay()];
};

Date.locale = {
	en: {
		month_names: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		month_names_short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        day_names : ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        day_names_short : ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
	}
};

Date.prototype.stdTimezoneOffset = function() {
	var jan = new Date(this.getFullYear(), 0, 1);
	var jul = new Date(this.getFullYear(), 6, 1);
	return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
};

Date.prototype.tet = function() {
	return (this.getTimezoneOffset() < this.stdTimezoneOffset());
};

arrayRemove = function(t) {
    var what, a = arguments, L = a.length, ax;
    while (L && t.length) {
        what = a[--L];
        if (what===t) continue;
        while ((ax = t.indexOf(what)) !== -1) {
            t.splice(ax, 1);
        }
    }
    return t;
};

/*Array.prototype.include = function (x) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] === x) {
            return true;
        }
    }
    return false;
};*/
/*
window.onerror = function (msg, url, lineno, colno, error) {
    var err = msg+'\n'+url+'\n'+lineno+' - '+colno+'\n'+error;
    //alert (err);
    na.analytics.logMetaEvent (err);
    console.log (err);
    debugger;
};
*/
const getCircularReplacer = () => {
  const seen = new WeakSet();
  return (key, value) => {
    if (typeof value === "object" && value !== null) {
      if (seen.has(value)) {
        return;
      }
      seen.add(value);
    }
    return value;
  };
};
