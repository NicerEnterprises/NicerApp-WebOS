class vividUserInterface_2D_dialog {
    constructor (cmd) {
        var t = this;
        t.cmd = cmd;

        t.cmd.el[0].vividUserInterface_2D_dialog = this;
        if (!$('canvas',t.cmd.el)[0]) {
            var c = document.createElement('canvas');
            $(c).css({
                position : 'absolute',
                height : '100%',
                width : '100%',
                top : 0,
                left : 0

            });
            t.cmd.el.append(c);
            t.canvas = c;
        } else {
            t.canvas = $('canvas',t.cmd.el)[0];
        }
        t.borderVideo = $('video',t.cmd.el)[0];
        t.backgroundVideo = $('video',t.cmd.el)[1];
        if (
            navigator.connection.downlink < 2
            || navigator.connection.type == 'bluetooth'
            || navigator.connection.type == 'cellular'
            || navigator.connection.saveData
        ) {
            // todo : display a tiled background for this div.
            return this;
        } else if (t.borderVideo) {
            t.init_borderVideo(t);
            t.init_vividUserInterface_2D_dialogBorder_lavaLamp(t);
        };
        return this;
    }

    init_vividUserInterface_2D_dialogBorder_lavaLamp (t) {
        const ctx = t.canvas.getContext('2d');
        ctx.canvas.width = t.cmd.el.width();
        ctx.canvas.height = t.cmd.el.height();
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        const w = ctx.canvas.width;

        const h = $('#siteTaskbar').height();
        const dlw = 3;

        ctx.strokeStyle = ctx.createPattern(t.borderVideo,'no-repeat');
        ctx.lineWidth = dlw;
    }

    init_borderVideo (t) {
        if (t.borderVideo) {
            t.backgroundVideo.onloadstart = function (evt) {
                if (t.canvas) {
                    t.canvasInterval = window.setInterval(() => {
                        t.drawImage (t);
                    }, 1000 / 30);
                    t.borderVideo.play();
                    t.backgroundVideo.play();
                }
            };
            t.borderVideo.load();
            t.backgroundVideo.load();
        }
    }

    drawImage (t) {
        //requestAnimationFrame (function(p) { t.drawImage(t) } );
        const ctx = t.canvas.getContext('2d');
        ctx.canvas.width = $('#siteTaskbar').width();
        ctx.canvas.height = $('#siteTaskbar').height();
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        const w = ctx.canvas.width;

        const h = $('#siteTaskbar').height();
        const dlw = 3;

        ctx.strokeStyle = ctx.createPattern(t.borderVideo,'no-repeat');
        ctx.lineWidth = dlw;

        var
        borderRadius = 10,
        x = 4, y = 4, // these determine the width and height of the video borders
        width = ctx.canvas.width-(x*2),
        height = ctx.canvas.height-(y*2);

        ctx.beginPath();
        ctx.moveTo(x + borderRadius, y);
        ctx.lineTo(x + width - borderRadius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + borderRadius);
        ctx.lineTo(x + width, y + height - borderRadius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - borderRadius, y + height);
        ctx.lineTo(x + borderRadius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - borderRadius);
        ctx.lineTo(x, y + borderRadius);
        ctx.quadraticCurveTo(x, y, x + borderRadius, y);
        ctx.stroke();
        ctx.closePath();

        ctx.beginPath();
        ctx.moveTo(x + borderRadius, y);
        ctx.lineTo(x + width - borderRadius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + borderRadius);
        ctx.lineTo(x + width, y + height - borderRadius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - borderRadius, y + height);
        ctx.lineTo(x + borderRadius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - borderRadius);
        ctx.lineTo(x, y + borderRadius);
        ctx.quadraticCurveTo(x, y, x + borderRadius, y);
        ctx.closePath();

        ctx.clip();
        ctx.drawImage (t.backgroundVideo, x, y, ctx.canvas.width, ctx.canvas.height);
    }

    hide (cmd) {
        var t = this;
        setTimeout (function() {
            if (t.cmd.naSite.settings.heldUp[cmd.checkHeldUp]) return false;
            $(cmd.checkHeldUp).removeClass('shown').addClass('hidden');
        }, 500);

    }
}

class vividUserInterface_2D_borderVideo extends HTMLVideoElement {
    constructor (cmd) {
        super ({});
        var t = this;
        t.cmd = cmd;

        $('video source', t.cmd.el).last().on('error', function(e) {
            t.failed(e);
        });
    }
    failed(e) {
   // video playback failed - show a message saying why
        switch (e.target.error.code) {
            case e.target.error.MEDIA_ERR_ABORTED:
            alert('You aborted the video playback.');
            break;
            case e.target.error.MEDIA_ERR_NETWORK:
            alert('A network error caused the video download to fail part-way.');
            break;
            case e.target.error.MEDIA_ERR_DECODE:
            alert('The video playback was aborted due to a corruption problem or because the video used features your browser did not support.');
            break;
            case e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
            alert('The video could not be loaded, either because the server or network failed or because the format is not supported.');
            break;
            default:
            alert('An unknown error occurred.');
            break;
        }
    }
}
