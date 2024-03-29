// Copyright (C) 2002-2023 and All Rights Reserved (R) by Rene AJM Veerman <rene.veerman.netherlands@gmail.com>
NicerApp_WebOS.vt = NicerApp_WebOS.vividText = {
	about : {
		whatsThis : 'nicerapp.vt = nicerapp.vividText = cool color animations for HTML texts',
		copyright : '(c) (r) 2013-2017 by Rene AJM Veerman, Amsterdam, Netherlands, rene.veerman.netherlands@gmail.com',
		license : 'http://nicer.app/LICENSE.txt',
		noWarranty : 'NO WARRANTY EXPRESSED OR IMPLIED. USE ONLY AT YOUR OWN RISK.',
		version : '1.1.0',
		firstReleased : '2013 January 13, 13:28 CET',
		lastUpdated : '2022 May 25, 10:25 CEST'
	},
	globals : {
		animationTypes : [
			/* 'singleColor', 'singleBackgroundColor', 'singleColorBackgroundColor', 'doubleColor', 'doubleBackgroundColor', 'doubleColorBackgroundColor', */
			'animatedDoubleColor', 'animatedDoubleBackgroundColor', 'animatedDoubleColorBackgroundColor']
	},
	settings : {
		masterIdx : 0,
		commands : []
	},

	init : function () {
		
	},
	
	initElement : function (ajtCommand) {

/*
		if (na.m.userDevice.isPhone) {
			na.m.log (1, 'nicerapp.vividText.initElement() : na.m.userDevice.isPhone===true, saving phone CPU resources by not vividTexting this element.');
			return false;
		}
*/
		if ($('span.vt',ajtCommand.el).length>0) {
            //na.m.log (1, 'nicerapp.vividText.initElement(): el.children.length>0! NOT initializing this element for color animations!');
			return false;
		};
		
		delete na.vt.settings.allOnPageFullyInitialized;
		
		var 
		orig = ajtCommand.el.innerHTML,
		html = '',
		extraChars = 5,
		startChr = 0, 
		endChr = -1 + ajtCommand.el.innerHTML.length + (2 * extraChars),
		length = endChr - startChr,
        charLength = ajtCommand.el.innerHTML.length,
		evenCount = Math.floor(length/2)===(length/2),
		cmd = {
			typeOfObject : 'nicerapp.vividText.settings.commands',
            document : ajtCommand.document,
			el : ajtCommand.el, 
			theme : ajtCommand.theme,
			animationType : ajtCommand.animationType,
			animationSpeed : ajtCommand.animationSpeed ? ajtCommand.animationSpeed : 2000,
			animationDirection : 'forward',
            charLength : charLength,
			extraChars : extraChars,
			beginIdx : na.vt.settings.masterIdx,
			startChr : startChr,
			endChr : endChr,
			length : length,
			evenCount : evenCount,
			animatedDoubleMiddleIdx : 1,
			animationData : []
		};
        cmd.animationSpeed = cmd.animationSpeed * 3; // magic 'KnightRider (1980s TV show that i loved as a kid) value
        
		for (var i=0; i<na.vt.settings.commands.length; i++) {
			var it = na.vt.settings.commands[i];
            if (!it) continue;
			if (it.el.id===cmd.el.id) {
                delete na.vt.settings.commands[i];
                i--;
                delete na.vt.settings.allOnPageFullyInitialized;
            }
		};
        
        
        //na.vt.unInitElement(cmd.el);
		for (var i=-1*cmd.extraChars; i<orig.length+cmd.extraChars; i++) {
			var  
			padding = 'padding:0px;background:none;',
			ampstr=orig.substr(i,5),
			ampcheck=(ampstr==='&amp;'),
			c=(ampcheck? ampstr : (i >= 0 && i < orig.length ? orig.substr(i,1) : '&nbsp;')), 
			id=na.vt.settings.masterIdx++;
			if(ampcheck) {
				i += 4;
				cmd.endChr-=4;
			}
			
			//debugger;
			//$(cmd.el).parent().parent().css({ padding : '8px !important' });
			//$(cmd.el).parent().css({ padding : '8px !important' });
			html += '<span class="vt" id="SA_ajt_'+id+'" '
				+ (
					c==='&nbsp;'
					? 'style="'+padding+';position:absolute;width:0px;"'
					: 'style="'+padding+'"'//'style="'+padding+';font-family:'+ajtCommand.el.style.fontFamily.replace('"','')+';font-size:'+ajtCommand.el.style.fontSize+'"'
				)
				+ '>'+c+'</span>';
		};

		cmd.el.innerHTML = html;
        //debugger;
		cmd.endIdx = na.vt.settings.masterIdx - 1;
		//na.vt.settings.commands[cmd.el.id] = cmd;
		na.vt.settings.commands[na.vt.settings.commands.length] = cmd;
		
		//debugger;
		/*na.m.waitForCondition ('vividText for #'+cmd.el.id+' waiting for na.m.settings.initialized.site', 
			function () {
				//return na.m.settings.initialized.site
				return na.s.c.settings.vividsInitialized
			}, function () {*/
				//debugger;
                for (var i=0; i<na.vt.settings.commands.length; i++) {
                    if (!cmd.initializing) {
                        cmd.initializing = true;
		
                        na.vt.initAnimationsOnElement(cmd.el);
                    } 
                }
		/*	}, 100
		);*/
		
		return cmd;
	},
	
	findCmd : function (elid) {
		for (var i=0; i<na.vt.settings.commands.length; i++) {
			var it = na.vt.settings.commands[i];
            if (!it) continue;
			if (it.el.id===elid) return i;
		};
		return false;
	},

	unInitElement : function (el) {
		var cmdIdx = na.vt.findCmd(el.id);
		if (cmdIdx===false) {
			na.m.log (1, 'nicerapp.vividText.unInitElement(): no command issued for el.id='+el.id);
			return false;
		};
		var cmd = na.vt.settings.commands[cmdIdx];
		
		for (var i=0; i<el.children.length; i++) {
			var
			html='',
			e=el.children[i];
			
			html += e.innerHTML;
		};
		el.innerHTML = html;
		cmd.deconstructed=true;
	},
	
	initAnimationsOnElement : function (el) {
		var cmdIdx = na.vt.findCmd(el.id);
		if (cmdIdx===false) {
			na.m.log (1, 'nicerapp.vividText.unInitElement(): no command issued for el.id='+el.id);
			return false;
		} else {
			var 
			cmd = na.vt.settings.commands[cmdIdx],
            doc = cmd.document || document;
            
            cmd.idx = cmdIdx;
            //debugger;
            if (!doc.getElementById('SA_ajt_'+(cmd.beginIdx+cmd.startChr))) return false;
            na.vt.animate (cmd, na.vt.linear, na.vt.draw, cmd.animationSpeed);
            
			
		}
	},
    
    animate : function (cmd, timing, draw, duration) {
        let start = performance.now();
        requestAnimationFrame(function animateInnerLoop(time) {
            // timeFraction goes from 0 to 1
            let timeFraction = (time - start) / duration;
            if (timeFraction > 1) timeFraction = 1;

            // calculate the current animation state
            let progress = na.vt.linearActualPerCmd(cmd, timeFraction)
            
            na.vt.draw(cmd, progress); // draw it

            if (timeFraction < 1) {
                requestAnimationFrame(function(){na.vt.animate(cmd, timing, draw, duration)});
            }
        });
    }, 
    
    linear : function (timeFraction) {
        return timeFraction;
    },
    
    linearActualPerCmd : function (cmd, timeFraction) {
        var 
        timeFractionParts = 2,
        timeFractionPerPart = timeFraction / timeFractionParts,
        cl = cmd.charLength,
        direction = cmd.animationDirection,
        part1length = cmd.animatedDoubleMiddleIdx - cmd.startChr,
        part2length = cmd.endChr - cmd.animatedDoubleMiddleIdx,
        cs1 = cmd.colorSteps1,
        cs2 = cmd.colorSteps2,
        l = cmd.length;
        return (timeFractionPerPart * 1000) / cmd.animationSpeed; 
        
    },
    
    draw : function (cmd, progress) {
        na.vt.doAnimation (cmd);
    },
	
	doAnimation : function (cmd) {
		//na.vt.doAnimation_paint_clear (cmd);
        
        var
        doc = cmd.document || document;
        
        if (!doc.getElementById('SA_ajt_'+(cmd.beginIdx+cmd.startChr))) return false;
        		
		if (cmd.animationType.match('animatedDoubleColor')) na.vt.doAnimation_paint_double_animated (cmd);
	},
	
	doAnimation_paint_double_animated : function (cmd) {

		if (cmd.animationDirection=='forward') {
			cmd.animatedDoubleMiddleIdx++;
			if (cmd.animatedDoubleMiddleIdx >= cmd.length  ) {
				cmd.animationDirection = 'backward';
				cmd.animatedDoubleMiddleIdx--;
			}
		} else {
			cmd.animatedDoubleMiddleIdx--;
			if (cmd.animatedDoubleMiddleIdx <= 0 ) {
				cmd.animationDirection = 'forward';
				cmd.animatedDoubleMiddleIdx = 0;
			}
		};

		if (!cmd.animationData[cmd.animatedDoubleMiddleIdx]) {
			cmd.colorSteps1 = na.cg.generateList_basic (cmd.theme, cmd.animatedDoubleMiddleIdx);
			cmd.colorSteps2 = na.cg.generateList_basic (cmd.theme, cmd.length-cmd.animatedDoubleMiddleIdx);

			cmd.colorSteps2.reverse();

			cmd.animationData[cmd.animatedDoubleMiddleIdx] = {
				colorSteps1 : cmd.colorSteps1,
				colorSteps2 : cmd.colorSteps2
			}
		} else {
			var ad = cmd.animationData[cmd.animatedDoubleMiddleIdx];
			cmd.colorSteps1 = ad.colorSteps1;
			cmd.colorSteps2 = ad.colorSteps2;
			cmd.initialized = true;
		};
		
		requestAnimationFrame(function(){
            na.vt.doAnimation_paint_stretch (cmd, cmd.colorSteps1, cmd.startChr, cmd.animatedDoubleMiddleIdx);
        });
        requestAnimationFrame(function(){
            na.vt.doAnimation_paint_stretch (cmd, cmd.colorSteps2, cmd.animatedDoubleMiddleIdx, cmd.endChr);
		});
        
		if (
			cmd.animatedDoubleMiddleIdx > 0
			&& !na.vt.settings.allOnPageFullyInitialized
		) {
			for (var i = 0; i<na.vt.settings.commands.length; i++) {
				var it = na.vt.settings.commands[i];
                if (!it) continue;
				if (!it.initialized && i > 1) {
                    // old way of handling animation timing, very CPU unfriendly compared to requestAnimationFrame()
                    /*setTimeout (function () {
                        na.vt.doAnimation (cmd);
                    }, cmd.animationSpeed/(cmd.length));*/
					break;
				}
				if (cmd.el.id === it.el.id) {
                    /*setTimeout (function () {
                        na.vt.doAnimation (cmd);
                    }, cmd.animationSpeed/(cmd.length));*/
					break;
				}
			}
			if (i==na.vt.settings.commands.length-1) na.vt.settings.allOnPageFullyInitialized = true;
		} else {
			/*setTimeout (function () {
				na.vt.doAnimation (cmd);
			}, cmd.animationSpeed/(cmd.length));*/
		}
	},
	
	doAnimation_paint_stretch : function (cmd, colorSteps, startChr, endChr) {
		var l = endChr - startChr;
		for (var i=0; i<=l; i++) {
			var 
			idx = cmd.beginIdx + startChr + i,
            doc = cmd.document || document;
			e = doc.getElementById ('SA_ajt_'+idx),
			cs = colorSteps[i];
			if (!cs || !e) return false; // debugger might b an idea. some other time.
			if (cmd.animationType=='animatedDoubleColor' || cmd.animationType=='animatedDoubleColorBackgroundColor') {
				e.style.color = cs.color;
			};
			if (cmd.animationType=='animatedDoubleBackgroundColor' || cmd.animationType=='animatedDoubleColorBackgroundColor') {
				e.style.backgroundColor = cs.background;
			}
		}
	},
	
	doAnimation_paint_clear : function (cmd) {
		for (var i=cmd.beginIdx; i<=cmd.endIdx; i++) {
			var 
            doc = cmd.document || document,
            e = doc.getElementById('SA_ajt_'+i);
			if (e) {
				e.style.color = '';
				e.style.backgroundColor = '';
			}
		}
	}
};
