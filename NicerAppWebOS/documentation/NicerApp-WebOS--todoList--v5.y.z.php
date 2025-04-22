<?php
    global $naWebOS;
    require_once ($naWebOS->basePath.'/NicerAppWebOS/domainConfigs/'.$naWebOS->domainFolder.'/pageHeader.php');
?>

<h1 class="contentSectionTitle2"><span class="contentSectionTitle2_span">NicerApp WebOS Development Direction</span></h1><br/><br/>
<p>
I can not open up this to-do list for "jobs" done by other people yet, simply because the code is still in Alpha Phase. an initial test-phase.<br/>
But eventually yes, this WebOS will be a truly open market (at the technical and company levels).<br/>
</p>

<ol class="todoList">
    <li class="todoList"><div>(2025) Write a forums/posts + replies/posts API for this WebOS, for the v5 and v6 branch, in one go.</div></li>

    <li class="todoList"><div>(2025) Write a notification API for this WebOS, for the v5 and v6 branch, in one go.</div></li>

    <li class="todoList"><div>(2025) Write an in-app tutorial API for this WebOS, for the v5 and v6 branch, in one go.</div></li>

    <li class="todoList"><div>(2025) Start doing daily testruns of all apps and features.</div></li>

    <li class="todoList"><div>(2025 or 2026) Rewrite the YouTube search features to funnel videos into the backgrounds list for a NicerApp site (in addition to playing them via a vividDialog combination).</div></li>

    <li class="todoList"><div>(2024, 2025) Write the <a class="nomod noPushState contentSectionTitle3_a" href="https://new.nicer.app" target="nna"><span class="contentSectionTitle3_span">next major version</span></a>.
        <ol class="todoList_l1">
            <li class="todoList_l1"><div>how to run multiple web apps with changing DIV contents in a single tab</div></li>
            <li class="todoList_l1"><div>(DONE) how to load web apps as a module into a DIV on demand (lazy loading of ThreeJS -240Kb- for instance)</div></li>
            <li class="todoList_l1"><div>(DONE) how to do canvas animations of DIV borders</div></li>
            <li class="todoList_l1"><div>(CURRENT) how to display 3D content and menus without taking up too much screen real-estate (see <a href="https://nicer.app/3D-data" class="nomod noPushState" target="3dfm1">3D file manager on nicer.app</a> for a demo of a filetree browser in 3D, using ThreeJS)</div></li>
            <li class="todoList_l1"><div>how to move DIV dialogs/windows in and out of view on a screen that may change it's orientation at any time, on demand.</div></li>.
        </ol>
    </li>
    <li class="todoList"><div>(DONE) (Dec 2024) Fix bugs in the Theme Editor and page loading mechanism of v5.y.z</div></li>

    <li class="todoList"><div>(2025 or 2026) Start work on a self-healer component for this WebOS, and a lot more Desktop OS level automated security to be installed via the <a href="https://github.com/NicerEnterprises/NicerApp-WebOS/tree/main/NicerAppWebOS/scripts.install" target="mainBashInstallScript_for_NicerAppWebOS" class="nomod noPushState contentSectionTitle3_a"><span class="contentSectionTitle3_span">main Bash install script</span></a>.</div></li>

    <li class="todoList"><div>(2026 or 2027, unless someone wants to pay me 4 hundred euro up front and 2 thousand euro per year to develop this sooner) Add SQL and Linux + Windows file-system JSON storage and retrieval capabilities to .../logic.databases</div></li>

    <li class="todoList"><div>(2025 or 2026) Upgrade the blogging features.
        <ol class="todoList_l1">
            <li class="todoList_l1"><div>(Jan 2025) Create a new HTML WYSIWYG rich-text editor component (that will be entirely created from scratch by me, ensuring i have the copyright and rights reserved for this component), that ties into the NicerApp Theme Editor.<br/>
            This is stalled because browser makers need to start supporting a window.getSelection() that returns a .anchorOffset and .extentOffset that works on the .innerHTML instead of the .innerText of any given element (usually the .commonAncestorElement).<br/>
            <br/>
            [1] I need 'id' and 'classNames' input fields in the tinymce toolbar (to tie edited content into my universal web theme editor for my CMS/WebOS), creating a tinymce-4.9.11-na-1.0.0 branch of the <a href="https://www.tiny.cloud/" class="noPushState" target="tinymce">tinymce</a> MIT licensed v4.9 code.<br/>
            I've taken the liberty of web form contacting the tinymce sales team to ask if they can implement this for universal web theme editor builders for free.
            </div></li>

            <li class="todoList_l1"><div>(STALLED, awaiting completion of item 9.1 on this list)<br/>
            Supply data from a HTML+CSS form (as a tabpage in the universal web theme editor) into <a href="https://github.com/NicerEnterprises/NicerApp-WebOS/blob/main/NicerAppWebOS/logic.business-5.8.z/class.core.WebsiteOperatingSystem-5.y.z.php#L1374" class="noPushState contentSectionTitle3_a" target="naGH_wos1088"><span class="contentSectionTitle3_span">css_keyframes_to_array() and css_animation_template_to_animation()</span></a>, colors to mix will be defined by two 'colorpicker' (3rd-party) pieces of JS.
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
    </div></li>

    <li class="todoList"><div>Make the musicPlayer app work on smartphone vertical screens as well.</div></li>

    <li class="todoList"><div>Add the next set of animations to .todoList p, span, h1, h2, and h3 HTML elements (config data for which is to be visualized and interacted with in the theme editor by the way).<br/>
    These will be javascript + PHP generated visualizations for SVG (animated) graphics.<br/>
    I promise to bring you all some level of CSS animations in the generation config language :)<br/>
    Maybe even a real translation of CSS animations (they're easy to parse), into SVG color and transparency animations! :D</div></li>

    <li class="todoList"><div>Create a webshop app with a subscription model (that i'll publish as https://nicer.app/shop), in collaboration with paypal.com</div></li>

    <li class="todoList"><div>Create a donations button (again, in collaboration with paypal.com), with monthly goal indicator, for the news app.</div></li>

    <li class="todoList"><div>Create an app-store app that links into an eCommerce app component set (a bunch of javascript, svg, css and html snippet files).</div></li>

    <li class="todoList"><div>Implement bandwidth throttling in the <a href="https://github.com/NicerEnterprises/NicerApp-WebOS/tree/main/NicerAppWebOS/scripts.install" target="mainBashInstallScript_for_NicerAppWebOS" class="nomod noPushState">main Bash install script</a>.</div></li>

    <li class="todoList"><div>Add a checkbox in the Theme Editor to select backgrounds and stretch instead of tile them for any DIV.</div></li>

    <li class="todoList"><div>Work my WebOS to be more Windows(tm)(r) compatible in terms of it's user-interface.<br/>
    Specifically, I want to move the date-time indicator on my web-pages to the bottom-right of the screen.<br/>
    The only downside of this is that i'll lose pixel space for content/apps. But there's ways around that, like only showing the time indicator when the page is F11-ed, shown fullscreen without browser menus.
    </div>
    </li>



    <!--<li class="todoList"><div>Restore the automatic retrieval of new backgrounds download routines for nicerapp via free to use methods of delivery at Google image search and (TODO :)Bing image search.</div></li>-->

    <li class="todoList">
    <div><pre class="todoList">
    rewrite the backgrounds analysis and automatic resizing routines;
    - put all of the backgrounds in a DOMAIN_TLD___backgrounds dataSet with relative filepath (starting at siteMedia/backgrounds) and image size.
    - let users search for backgrounds based on filepath, then save those searches in their account settings and make them viewable as photoalbums.
    </pre></div>
    </li>

    <li class="todoList"><div>Upgrade the news app and vividDialog : add siteToolbarLeft functionality :<br/>
        <ol class="todoList_l1">
            <li class="todoList_l1"><div>add a 'translate' dropdown box to the app-specific options menu</div></li>
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

    <li class="todoList"><div>Build a comments engine and user-interface again, this time comments get stored in a database instead of on the server filesystem.</div></li>

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
