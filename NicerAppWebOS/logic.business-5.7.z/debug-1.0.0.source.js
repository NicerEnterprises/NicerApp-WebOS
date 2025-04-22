$(document).ready(function() {
    $('.vividButton4, .vividButton, .vividButton_icon_50x50_siteTop, .vividButton_icon_50x50').each(function(idx,el){
        if (!na.site.settings.buttons['#'+el.id]) na.site.settings.buttons['#'+el.id] = new naVividButton(el);
    });

    //na.backgrounds.next('#siteBackground');
    if (!na.site.globals.themes) na.site.onload(event);

    $('.naLogEntry').css({ width : ($(window).width() - 200) / 2 });

    var id = window.location.hash.replace('#','');
    if (id!=='') {
        var $el = $('#entry_'+id);
        //$el[0].scrollIntoView(true);
        setTimeout (function() {
            scrollParentToChild($('#siteContent .vividScrollpane')[0], $el[0]);
        }, 500);
        $el.css ({ border : '3px ridge lime', boxShadow : '2px 2px 6px 4px rgba(0,0,0,0.75), 0px 0px 3px 2px rgba(0,50,0,0.7)' });
    }

});
function scrollParentToChild(parent, child) {
// thanks go to https://stackoverflow.com/questions/45408920/plain-javascript-scrollintoview-inside-div
// for providing this function.

  // Where is the parent on page
  var parentRect = parent.getBoundingClientRect();
  // What can you see?
  var parentViewableArea = {
    height: parent.clientHeight,
    width: parent.clientWidth
  };

  // Where is the child
  var childRect = child.getBoundingClientRect();
  // Is the child viewable?
  var isViewable = (childRect.top >= parentRect.top) && (childRect.bottom <= parentRect.top + parentViewableArea.height);

  // if you can't see the child try to scroll parent
  if (!isViewable) {
        // Should we scroll using top or bottom? Find the smaller ABS adjustment
        const scrollTop = childRect.top - parentRect.top;
        const scrollBot = childRect.bottom - parentRect.bottom;
        if (Math.abs(scrollTop) < Math.abs(scrollBot)) {
            // we're near the top of the list
            parent.scrollTop += scrollTop;
        } else {
            // we're near the bottom of the list
            parent.scrollTop += scrollBot;
        }
  }

}
