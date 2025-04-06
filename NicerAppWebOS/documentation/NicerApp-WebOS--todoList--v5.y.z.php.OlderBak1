<?php
    global $naWebOS;
    require_once ($naWebOS->basePath.'/NicerAppWebOS/domainConfigs/'.$naWebOS->domain.'/pageHeader.php');
?>

<h1 class="contentSectionTitle2"><span class="contentSectionTitle2_span">NicerApp WebOS Development Direction</span></h1><br/><br/>

<p class="todoList">FYI : major release time is Christmas Day each year.</p>

<ol class="todoList">
    <li class="todoList"><div>(CURRENT) (2024) Write the <a class="nomod noPushState" href="https://new.nicer.app" target="nna">next major version</a>.
        <ol class="todoList_l1">
            <li class="todoList_l1"><div>how to run multiple web apps with changing DIV contents in a single tab</div></li>
            <li class="todoList_l1"><div>(DONE) how to load web apps as a module into a DIV on demand (lazy loading of ThreeJS -240Kb- for instance)</div></li>
            <li class="todoList_l1"><div>(NEARLY DONE) how to do canvas animations of DIV borders</div></li>
            <li class="todoList_l1"><div>(CURRENT) how to display 3D content and menus without taking up too much screen real-estate (see <a href="https://nicer.app/3D-data" class="nomod noPushState" target="3dfm1">3D file manager on nicer.app</a> for a demo of a filetree browser in 3D, using ThreeJS)</div></li>
            <li class="todoList_l1"><div>how to move DIV dialogs/windows in and out of view on a screen that may change it's orientation at any time, on demand.</div></li>.
        </ol>
    </li>
    <li class="todoList"><div>(CURRENT) (Jan 2024) Fix bugs in the Theme Editor and page loading mechanism of v5.y.z</div></li>


    <li class="todoList"><div>(CURRENT) (2023 Oct,Nov,Dec) Upgrade the blogging features.
        <ol class="todoList_l1">
            <li class="todoList_l1"><div>(STALLED) Create a custom HTML WYSIWYG rich-text editor component of my own, that ties into the NicerApp Theme Editor.<br/>
            This is stalled because browser makers need to start supporting a window.getSelection() that returns a .anchorOffset and .extentOffset that works on the .innerHTML instead of the .innerText of any given element (usually the .commonAncestorElement).<br/>
            UPDATE : I can strip the code that I need[1] from the way tinymce does the work for it's link-dialog and color highlighting dropdown dialog, but this will not be easy; due to the many work arounds needed at the browser level, tinymce is about 27500 lines of code, much of which comes into play during simple tasks like this.<br/>
            <br/>
            [1] I need 'id' and 'classNames' input fields in the tinymce toolbar (to tie edited content into my universal web theme editor for my CMS/WebOS), creating a tinymce-4.9.11-na-1.0.0 branch of the <a href="https://www.tiny.cloud/" class="noPushState" target="tinymce">tinymce</a> MIT licensed v4.9 code.<br/>
            I've taken the liberty of web form contacting the tinymce sales team to ask if they can implement this for universal web theme editor builders for free.
            </div></li>

            <li class="todoList_l1"><div>(STALLED, awaiting completion of item 3.1 on this list)<br/>
            Supply data from a HTML+CSS form (as a tabpage in the universal web theme editor) into <a href="https://github.com/NicerEnterprises/NicerApp-WebOS/blob/main/NicerAppWebOS/logic.business/class.core.WebsiteOperatingSystem-5.y.z.php#L1374" class="noPushState" target="naGH_wos1088">css_keyframes_to_array() and css_animation_template_to_animation()</a>.
                <ol class="todoList_l2">
                    <li class="todoList_l2"><div>Write 'vividRangeFinder' (a percentage bar -input field really- with 2 percentage stops)</div></li>
                </ol>
            </div></li>

            <li class="todoList_l1"><div>(CURRENT) (2023 Nov,Dec) Extend the current limited permissions system to a full CMS, Web User Interfaced, permissions system for the WebOS.
                <ol class="todoList_l2">
                    <li class="todoList_l2"><div>(CURRENT) (2023 Nov,Dec) Extend vividButton to bring up vividDialogs and vividMenus when hovered over. In fact, it shouldn't matter anymore whether you've hovering from a vividMenu through a vividDialog filled with vividButtons to a goal either anymore.<br/>So I need to create a new 'vividUI' (vividUserInterface) component, that will direct all of this.<br/>
                    I've already started on this, and it seems to be easy going :)</div></li>
                </ol>
            </div></li>
        </ol>
    </div></li>

    <li class="todoList"><div>(CURRENT) Expand functionality of the 3D file and data browser/viewer app
        <ol class="todoList_l1">
            <li class="todoList_l1"><div>Perhaps one day write a 3D tree generator, like the ThreeJS cube generator, that produces a ThreeJS model that actually looks like a tree, with figurines representing the folders sitting at strategic spots along the branches of that tree. possibly use animal figurines.
            </div></li>
        </ol>
    </div></li>

    <li class="todoList"><div>Make the musicPlayer app work on smartphone vertical screens as well.</div></li>

    <li class="todoList"><div>Add the next set of animations to .todoList p, span, h1, h2, and h3 HTML elements (config data for which is to be visualized and interacted with in the theme editor by the way).<br/>
    These will be javascript + PHP generated visualizations for SVG (animated) graphics.<br/>
    I promise to bring you all some level of CSS animations in the generation config language :)<br/>
    Maybe even a real translation of CSS animations (they're easy to parse), into SVG color and transparency animations! :D</div></li>

    <li class="todoList"><div>Create a webshop app with a subscription model (that i'll publish as https://nicer.app/shop), in collaboration with paypal.com</div></li>

    <li class="todoList"><div>Create a donations button (again, in collaboration with paypal.com), with monthly goal indicator, for the news app.</div></li>

    <li class="todoList"><div>Create an app-store app that links into an eCommerce app component set (a bunch of javascript, svg, css and html snippet files).</div></li>

    <li class="todoList"><div>Implement bandwidth throttling for my webserver.</div></li>

    <li class="todoList"><div>Add a checkbox in the Theme Editor to select backgrounds and stretch instead of tile them for any DIV.</div></li>

    <li class="todoList"><div>Work my WebOS to be more Windows(tm)(r) compatible in terms of it's user-interface.<br/>
    Specifically, I want to move the date-time indicator on my web-pages to the bottom-right of the screen.<br/>
    The only downside of this is that i'll lose pixel space for content/apps. But there's ways around that, like only showing the time indicator when the page is F11-ed, shown fullscreen without browser menus.
    </div>
    </li>



    <li class="todoList"><div>Restore the automatic retrieval of new backgrounds download routines for nicerapp via free to use methods of delivery at Google image search and (TODO :)Bing image search.</div></li>

    <li class="todoList">
    <div><pre class="todoList">
    rewrite the backgrounds analysis and automatic resizing routines;
    - put all of the backgrounds in a DOMAIN_TLD___backgrounds dataSet with relative filepath (starting at siteMedia/backgrounds) and image size.
    - let users search for backgrounds based on filepath, then save those searches in their account settings and make them viewable as photoalbums.
    </pre></div>
    </li>

    <li class="todoList"><div>Upgrade the news app and vividDialog : add siteToolbarLeft functionality :<br/>
        <ol class="todoList_l1">
            <li class="todoList_l1"><div>add a 'translate' dropdown box (language selection) and button to each news item</div></li>
            <li class="todoList_l1"><div>add French news sources</div></li>
            <li class="todoList_l1"><div>add/enable/disable/remove any URL to a combination of lists that are each given a name, which get stored in several database-stored dataSubSets (records/documents) inside a dataSet (table/couchdb-database).<br/>
            </li>
            <li class="todoList_l1"><div>the ability to assign specific 'theme' and 'sub-theme' settings to such a URL.</div></li>
            <li class="todoList_l1"><div>the ability to do keyphrase searches (perhaps later with 'or' and 'and' logic support) on the news content gatered, and paint that content with specific 'theme' and/or 'sub-theme' settings.<br/>
            (putting all of this in siteToolbarLeft and the rest in the siteThemeEditor, and that those can already be shown at the same time, means you can edit *all* user-interface settings for *any* app or service on any HD screen or pad screen.</div></li>
            <li class="todoList_l1"><div>let vividDialog have a vividMenu, with vividButton icons that will lead to vividMenus and vividDialogs and vividDialogPopups, at the top-right of it's borders.<br/>
            the contents of this menu should be defined in a &lt;UL&gt; structure (that can, if needed, get loaded with fresh content via AJAX), much like the vividMenu already is today.</div></li>
        </ol>
    </div>
    </li>

    <li class="todoList"><div>Build a comments engine and user-interface (again).</div></li>

    <li class="todoList"><div>Figure out a way to store the width and height of each background found in the filesystem in the output of .../NicerAppWebOS/domainConfigs/DOMAIN.TLD/ajax_backgrounds_recursive.php and .../NicerAppWebOS/domainConfigs/DOMAIN.TLD/ajax_backgrounds.php.<br/>
    (NOT DONE) Then use this information in the backgrounds menu to select only elligible backgrounds, and popup an error message 'No backgrounds found, reverting to search key = {$someSearchKey}' when no backgrounds are found for the current search / menu-option.</div></li>

    <li class="todoList"><div>Integration of payment platforms (as plugins) for paypal.com, creditcards, and the Dutch banking system iDeal.</div></li>

    <li class="todoList"><div>Music production app via linux commandline app sonic-pi, integration of that app with payment modules and musicPlayer.</div></li>

    <li class="todoList"><div>Add MySQL and PostgreSQL to the list of supported database architectures (via .../NicerAppWebOS/3rd-party/adodb5), currently only couchdb is supported.<br/>
    </div></li>


</ol>
<script type="text/javascript">
    na.site.bindTodoListAnimations (
        '.todoList > li, '
        +'.contentSectionTitle3, '
        +'p.todoList, h1.todoList, h2.todoList, h3.todoList, '
        +'.todoList > lI > div, '
        +'.todoList > lI > pre, '
        +'.todoList_l1 > li, '
        +'.todoList_l1 > lI > div, '
        +'.todoList_l1 > lI > pre, '
        +'.todoList_l2 > li, '
        +'.todoList_l2 > lI > div, '
        +'.todoList_l2 > lI > pre '
    );
</script>
