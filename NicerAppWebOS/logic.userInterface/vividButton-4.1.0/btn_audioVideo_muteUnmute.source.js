if (!na || !na.ui || !na.ui.vividButton) debugger;
na.ui.vividButton.buttonTypes['btn_audioVideo_muteUnmute'] = {
    buttonType : 'btnMuteUnmute',
    handlesOwnHighlighting : false,

    startupState : 'unmuted',
    selectedState : 'muted',

    startupCircumstance : 'normal',    
    circumstances : {
        normal : {
            layers : {
                circleIcon_background : {
                    layerID : 'b.btnCode.circumstances.normal.layers.circleIcon_background',
                    animType : 'css : radial-gradient',
                    shape : 'circle',
                    position : 'center',
                    size : 'closest-side',
                    linearColorStops : [
                        { color : 'rgba(0,255,0,0)', length : [0, 0] },
                        { color : 'rgba(0,0,0,0.7)', length : [1, 100] }
                    ]
                }
            }
        },
        hover : {
            layers : {
                circleIcon_background : {
                    layerID : 'b.btnCode.circumstances.hover.layers.circleIcon_background',
                    animType : 'css : radial-gradient',
                    shape : 'circle',
                    position : 'center',
                    size : 'closest-side',
                    linearColorStops : [
                        { color : 'rgba(0,255,0,0.3)', length : [0, 92] },
                        { color : 'rgba(0,255,0,0.7)', length : [100, 100] }
                    ]
                }
            }
        }
    },
    layers : {
        circleIcon_svg : {
            layerID : 'b.btnCode.layers.circleIcon_svg',
            animType : 'svg',
            src : '/NicerAppWebOS/logic.userInterface/vividButton-4.1.0/btn_audioVideo_muteUnmute.svg',
            onclick : function (evt) {
                var
                b = na.ui.vb.settings.buttons['#'+$(evt.currentTarget)[0].id],
                t = b.t,
                c = b.btnCode.states[b.state].circumstances,
                scl = b.btnCode.states[b.state].circumstances[b.circumstance].layers.circleIcon_background,
                l = t.getLayer(b, scl.layerID),
                ato = scl.animTo[b.to.circumstance];
                if (!ato) debugger;

                ato.step = 0;
                if (
                    !$(evt.currentTarget).is('.muted')
                ) {
                    l.animDirection = 'increase';
                    t.anim_increaseGradient(b, l, ato);
                    b.handlesOwnHighlighting = true;
                } else {
                    l.animDirection = 'decrease';
                    t.anim_decreaseGradient(b, l, ato);
                    b.handlesOwnHighlighting = false;
                }
                if ($(evt.currentTarget).is('.muted')) {
                    $('#path4020, #path4022, #path4024, #path4007, #path4009').show();
                    $('#path4020, #path4022, #path4024').css('stroke', '#FFF');
                    $('#path4005, #path4007, #path4009').css('stroke', '#333').css('stroke-width', 1.7);
                } else {
                    $('#path4022, #path4024, #path4007, #path4009').hide();
                    $('#path4005').css('stroke', 'navy').css('stroke-width', 3);
                }
            },
            onmouseover : function (evt) {
                if ($(evt.currentTarget).is('.muted')) {
                    $('#path4020, #path4022, #path4024, #path4007, #path4009').show();
                    $('#path4020, #path4022, #path4024').css('stroke', '#FFF');
                    $('#path4005, #path4007, #path4009').css('stroke', '#333').css('stroke-width', 1.7);
                } else {
                    $('#path4022, #path4024, #path4007, #path4009').hide();
                    $('#path4005').css('stroke', 'navy').css('stroke-width', 3);
                }
            },
            onmouseout : function (evt) {
                if (!$(evt.currentTarget).is('.muted')) {
                    $('#path4020, #path4022, #path4024, #path4007, #path4009').show();
                    $('#path4020, #path4022, #path4024').css('stroke', '#FFF');
                    $('#path4005, #path4007, #path4009').css('stroke', '#333').css('stroke-width', 1.7);
                } else {
                    $('#path4022, #path4024, #path4007, #path4009').hide();
                    $('#path4005').css('stroke', 'navy').css('stroke-width', 3);
                }
            }
        }
    },
    states : {
        unmuted : {
            circumstances : {
                normal : {
                    layers : {
                        circleIcon_background : {
                            layerID : 'b.btnCode.circumstances.normal.layers.circleIcon_background', 
                            animTo : {
                                hover : {
                                    animDuration : 500,
                                    animInterval : 10,
                                    steps : [ ]
                                }
                            }
                        },
                        circleIcon_svg : {
                            layerID : 'b.btnCode.layers.circleIcon_svg',
                            animTo : {
                                hover : {
                                    animDuration : 500
                                }
                            }
                        }
                    }
                },
                hover : {
                    layers : {
                        circleIcon_background : {
                            layerID : 'b.btnCode.circumstances.hover.layers.circleIcon_background',
                            animTo : {
                                normal : {
                                    animDuration : 500,
                                    animInterval : 10,
                                    steps : [ ]
                                }
                            }                            
                        },
                        circleIcon_svg : {
                            layerID : 'b.btnCode.layers.circleIcon_svg',
                            animTo : {
                                normal : {
                                    animDuration : 500
                                }
                            }
                        }
                    }
                }
            }
        },
        muted : {
            circumstances : {
                normal : {
                    layers : {
                        circleIcon_background : {
                            layerID : 'b.btnCode.circumstances.normal.layers.circleIcon_background', 
                            animTo : {
                                hover : {
                                    animDuration : 500,
                                    animInterval : 10,
                                    steps : [ ]
                                }
                            }
                        },
                        circleIcon_svg : {
                            layerID : 'b.btnCode.layers.circleIcon_svg',
                            animTo : {
                                hover : {
                                    animDuration : 500
                                }
                            }
                        }
                    }
                },
                hover : {
                    layers : {
                        circleIcon_background : {
                            layerID : 'b.btnCode.circumstances.hover.layers.circleIcon_background',
                            animTo : {
                                normal : {
                                    animDuration : 500,
                                    animInterval : 10,
                                    steps : [ ]
                                }
                            }                            
                        },
                        circleIcon_svg : {
                            layerID : 'b.btnCode.layers.circleIcon_svg',
                            animTo : {
                                normal : {
                                    animDuration : 500
                                }
                            }
                        }
                    }
                }
            }
        }
    }
};

