<?php
    global $naWebOS;
    require_once ($naWebOS->basePath.'/NicerAppWebOS/documentation/pageHeader.php');
?>

    <h1 class="contentSectionTitle2">NicerApp WebOS Development Direction</h1><br/><br/>
    <ol class="todoList">
        <li class="todoList"><div>(DONE) (2021-2022) Create a Theme Editor.</div></li>

        <li class="todoList"><div>(DONE) (2022) Automatic site background rotations via #btnOptions dialog's first 'setting'.</div></li>

        <li class="todoList"><div>(DONE) (2022) Better error display features (list full error details in seperate dialog on the site itself).</div></li>

        <li class="todoList"><div>(DONE) (2022-Sept) Allow Guest users to use the Theme Editor (by storing theme settings per IP address + User-Agent in the database's existing theme_settings table).</div></li>

        <li class="todoList"><div>(DONE) (2022-Sept) Restore the old links, like the 3D WebGL (component) demos.</div></li>

        <li class="todoList"><div>(DONE) (2022-Sept) Improve the database access diversity.</div></li>

        <li class="todoList releaseDate"><div>(DONE) (2022 Nov 7th) : the emerging of <a href="https://said.by" class="noPushState noVividText" target="saidDotBy" style="margin:0 !important;">https://said.by</a> as an online blogging platform for end-users</a>.</li>


        <li class="todoList"><div>(2023-Jan-Feb) Show a small error window for a short time when a page can't load. Revert the location-bar to it's old location afterward.</div></li>

        <!--
        <li class="todoList"><div>
            <p>
            (UNDER CONSTRUCTION) (2023-Feb-Mar) Version 5.1 : Upgrade the Content Management System (blogging) features.<br/>
            Published at <a href="https://said.by" class="noPushState noVividText" target="saidDotBy" style="margin:0 !important;">https://said.by</a>.<br/>
            </p>

            <p>
            it should be noted that NicerApp will not support automated natural language analysis for a very long time to come, i've got sooo many other base layers to properly build into code first.<br/>
            this means that things like anti-spammer and anti-bot control are left up to the operators of a social media site based on NicerApp will have to write up basic automated processing to keep spam bots out, themselves.<br/>
            such functionality won't appear in NicerApp until the year 2027 or so.<br/>
            i do have basic ideas for a computer languages and natural language processing code set.
            </p>

            <ol class="todoList_l1">
                <li><div>(DONE) (2022-Oct) Render username+dataID into a filled-out view : "data_by_users" table settings need to be placed in $view.</div></li>

                <li><div>(DONE) (2022-Oct) Correctly apply theme settings to all views.</div></li>

                <li><div>(DONE) Add new dataSet 'data_by_users' :<br/>
                Example records are :
<pre>
{
  "_id": "8f7b3d86191843d308811cbf54004bfb",
  "seo": "Site-Birth",
  "viewSettings": {
    "/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS/cmsText": {
        "dataSetID": "said_by___cms_documents__user__rene__ajm__veerman",
        "dataSubSetID" : "zoZZoUfumC"
    }
  },
  "user": "Rene AJM Veerman"
}
</pre>
and :
<pre>
{
  "_id": "8f7b3d86191843d308811cbf54004bfc",
  "seo": "Hello-World",
  "viewSettings": {
    "/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS/cmsText": {
        "dataSetID": "said_by___cms_documents__role__guests",
        "dataSubSetID" : "zoZZoAfemD"
    }
  },
  "user" : "Jan Klaassen",
  "role": "guests"
}
</pre>
                </div></li>

                <li><div>(2022-Nov) Add new dataSet 'data_permissions' :<br/>
<pre>
{
  "_id": "8f7b3d86191843d308811cbf54004baa",
  "dataSetID": "cms_documents__user__rene__ajm__veerman",
  "dataSubSetID": "zoZZoUfumC",
  "user": "Rene AJM Veerman",
  "permissions" : "find,see,view,edit,archive,delete"
}
</pre>
or : (
<pre>
    {
        "_id": "8f7b3d86191843d308811cbf2c007bab",
        "dataSetID": "cms_documents__role__guests",
        "dataSubSetID": "zoZZoAfemD",
        "role": "guests",
        "permissions" : "find,see,view"
    }
</pre>
&nbsp;&nbsp;&nbsp;&nbsp;and :
<pre>
    {
        "_id": "8f7b3d86191843d30af33s1cbf55002fde",
        "dataSetID": "cms_documents__role__guests",
        "dataSubSet": {
            "selector" : {
                "id" : "zoZZoAfemD"
            },
            "fields" : [ '_id', '

        },
        "user": "Jan Klaassen",
        "permissions" : "find,see,view,edit,archive,delete"
    }
</pre>
)
                </div></li>

                <li><div>(2022-Nov) Copy '/NicerAppWebOS/apps/NicerAppWebOS/content-management-systems/NicerAppWebOS/blogEditor' to '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/dataSetsExplorer' (which accesses and edits data from the database and/or the filesystem) and abandon the 'blogEditor' app (rename it to 'blogEditor.DEPRACATED') in favor of the new 'dataSetsExplorer' app.</div></li>

                <li><div>(DONE) (2022-Nov-8th to 11th) Let apps provide desktop layouts other than the default one that gets listed in /NicerAppWebOS/domainConfigs/MYDOMAIN.TLD/desktop.source.js.<br/>
                The main problem here is the dynamic nature of the desktop layout.<br/>
                This will require a new approach to assembling desktop layouts and showing&amp;hiding main vividDialogs : the factory supplied but user-defined desktop layout,<br/>
                stored in a database connection as pure JSON with some specialized syntax that does not require an eval() at any stage of processing,<br/>
                but rather careful regexp match operations followed by a set of specific allowed js calls once the data in the desktop layout has passed the filtering stage.<br/>
                At a later stage, this will also enable desktop layouts to be re-arranged by drag-and-drop and mouse resizing of windows as you would do in an Operating System desktop environment.</div></li>

                <li><div>(2023) Build a vividDialog #siteToolbarPermissions and list that in /NicerAppWebOS/na.desktop-5.y.z.js, for '/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/dataSetsExplorer' to specify 'permissions' on any given 'dataSubSet' ('table row' in SQL, 'database document' in couchdb) (and especially the Content Management System, Blogging System, related dataSets), a feature that is lacking in the base layers of any database server system and thus left to business logic code supplied by me.<br/>
                </div></li>

            <li><div>(2023) Enforce the permissions system in all scripts that edit or display dataSubSets (table rows/database documents).
                <ol class="todoList_l2">
                    <li><div>(2023) Modify the editDataSubSet() functions in /NicerAppWebOS/logic.databases/generalizedDatabasesAPI-1.0.0/class.database_API.php and /NicerAppWebOS/logic.databases/generalizedDatabasesAPI-1.0.0/connectors/class.couchdb-3.2.2_1.0.1.php to check for permissions.<br/>
                    Route all calls to edit the data through this function.
                    </div></li>

                    <li><div>(2023) Add functions viewDataSubSet() in /NicerAppWebOS/logic.databases/generalizedDatabasesAPI-1.0.0/class.database_API.php and /NicerAppWebOS/logic.databases/generalizedDatabasesAPI-1.0.0/connectors/class.couchdb-3.2.2_1.0.1.php and let it check for permissions at the 'connector' level.<br/>
                    Route all calls to view such data through this function.</div></li>
                </ol>
                </div></li>

                <li><div>(2023) for the dataSetsExplorer, move the contents of #siteToolbarLeft into the new #siteToolbarExplorer, and build a new vividDialog #siteToolbarShortcuts and list both in /NicerAppWebOS/na.desktop-5.y.z.js, fill it with a jstree component and allow drag and drop between #siteToolbarExplorer for the blogEditor/dataSetsExplorer and #siteToolbarShortcuts.</div></li>

                <li><div>(2023) Allow automatic reloading of the blogging interface, to support multiple people editing a single set of documents/pages (dataSubSets) in parallel.<br/>
                Allow access to the version history of dataSubSets.<br/>
                </div></li>
            </ol>
        </div></li>
                -->

        <li class="todoList"><div>(2023) Version 5.1 : Restore the automatic retrieval of new backgrounds download routines for nicerapp via free to use methods of delivery at Google image search and (TODO :)Bing image search.</div></li>

        <!--
        <li class="todoList"><div>(2023) Version 5.2 : Upgrade the way themes and specificities work.<br/>
            <ol class="todoList_l1">
                <li><div>NicerApp Web-OS should by default supply the following :<br/>
                    <ol class="todoList_l2">
                        <li><div>default css themes in factory supplied 'dark-birth' and 'light-birth' css files (in the folder-file-formats used by the import-export features of NicerApp WebOS), which are to be used in case no database server can be reached.</div></li>
                        <li><div>vividTextThemes (this is a piece of JSON with CSS embeded into it) must start to support rgba(x,y,z,a) notation.</div></li>
                        <li><div>supply the proper finalized theme in the HTML output of each new page load.</div></li>
                    </ol>
                </div></li>
                <li><div>and an end-user should be able to :<br/>
                    <ol class="todoList_l2">
                        <li><div>assign any background and theme to be used (or force them into such a theme) on first view of any content that is owned by them, by unknown end-users, certain groups, or certain individuals,<br/>
                        via the logic.userInterface/photoAlbum/5.0.0, or via the Theme Editor.</div></li>
                        <li><div>import and export of a theme or several themes at the same time (a theme is a simple JSON data piece, around 1Kb to 5Kb large).</div></li>
                    </ol>
                </div></li>
                <li><div> ... </div></li>
            </ol>
        </li>

        <li class="todoList"><div>(2023) Version 5.3 : Upgrade the Theme Editor : 2 new tab pages :<br/>
            <ol class="todoList_l1">
                <li><div>pick (with a custom mouse cursor, or by entering a jQuery or CSS selector) a 'focus' for any number of 'themes' for any given 'specificity' on a NicerApp powered website.</div></li>
                <li><div>adds the ability to define several 'vividTextSubTheme' settings, which become part of the theme being saved for some specificity, by the end-user, who is a part of certain groups.</div></li>
            </ol>
        </div>
        </li>
        -->

        <li class="todoList"><div>(2023) Version 5.3 : Start work on a custom HTML WYSIWYG rich-text editor component of my own, since tinymce is not compatible with CSS animations or editing of any CSS properties, or the addition of js components to a given HTML selector.<br/>
            <ol class="todoList_l1">
                <li><div>supply data from a HTML+CSS form into <a href="https://github.com/NicerEnterprises/NicerApp-WebOS-dev/blob/main/NicerAppWebOS/logic.business/class.core.WebsiteOperatingSystem-5.y.z.php#L1088" class="noPushState" target="naGH_wos1088">css_keyframes_to_array() and css_animation_template_to_animation()</a>.</div></li>
            </ol>
        </li>

        <li class="todoList"><div>(2023) Upgrade the news app and vividDialog : add siteToolbarLeft functionality :<br/>
            <ol class="todoList_l1">
                <li><div>add/enable/disable/remove any URL to a combination of lists that are each given a name, which get stored in several database-stored dataSubSets (records/documents) inside a dataSet (table/couchdb-database).<br/>
                </li>
                <li><div>the ability to assign specific 'theme' and 'sub-theme' settings to such a URL.</div></li>
                <li><div>the ability to do keyphrase searches (perhaps later with 'or' and 'and' logic support) on the news content gatered, and paint that content with specific 'theme' and/or 'sub-theme' settings.<br/>
                (putting all of this in siteToolbarLeft and the rest in the siteThemeEditor, and that those can already be shown at the same time, means you can edit *all* user-interface settings for *any* app or service on any HD screen or pad screen.</div></li>
                <li><div>let vividDialog have a vividMenu, with vividButton icons that will lead to vividMenus and vividDialogs and vividDialogPopups, at the top-right of it's borders.<br/>
                the contents of this menu should be defined in a &lt;UL&gt; structure (that can, if needed, get loaded with fresh content via AJAX), much like the vividMenu already is today.</div></li>
            </ol>
        </div>
        </li>

        <li class="todoList"><div>(2023) Full server backup facilities within NicerApp WebOS. Currently this is only needed for couchdb data and IMAP Maildir data), to other servers on the LAN or even outside the LAN of the web server, <b>and</b> to zip files (by using the php7.4-zip ubuntu OS library, <b>with</b> progress bar for the zip file creation processes, and also with restore functionality built right into the browser.</div></li>

        <li class="todoList"><div>(2023) Version 6.0 : upgrade the na.desktop component to it's next major version (a complete rewrite, but one that enhances the old feature set by a significant degree.<br/>This version will allow for dialogs to be repositioned and resized by drag and drop.</div></li>

        <li class="todoList"><div>(2023) Figure out a way to store the width and height of each background found in the filesystem in the output of .../NicerAppWebOS/domainConfigs/DOMAIN.TLD/ajax_backgrounds_recursive.php and .../NicerAppWebOS/domainConfigs/DOMAIN.TLD/ajax_backgrounds.php.<br/>
        (NOT DONE) Then use this information in the backgrounds menu to select only elligible backgrounds, and popup an error message 'No backgrounds found, reverting to search key = {$someSearchKey}' when no backgrounds are found for the current search / menu-option.</div></li>

        <li class="todoList"><div>(2023) Build a view port into <a href="https://wikipedia.org" target="wikipedia">https://wikipedia.org</a> data, whose content one may re-use without legal consequences, and which is *great*. :D</li>

        <li class="todoList"><div>(2023) Facebook-like timeline features with it's own look, feel and artwork.</div></li>

        <li class="todoList"><div>(2024) Integration of payment platforms (as plugins) for paypal.com, creditcards, and the Dutch banking system iDeal.</div></li>

        <li class="todoList"><div>(2024) Webshop functionality</div></li>

        <li class="todoList"><div>(2024) Basic Google Drive like facilities (to facilitate large attachments in email).</div></li>

        <li class="todoList"><div>(2024) Forums features.</div></li>

        <li class="todoList"><div>(2025) Integration of oAuth (Google and Facebook authentication systems).</div></li>

        <li class="todoList"><div>(2025) Webshop features.</div></li>

        <li class="todoList"><div>(2025) Small business administration features.</div></li>

        <li class="todoList"><div>(2025) Webmail features that can hopefully work with another IMAP data provider like Gmail and Hotmail as the primary email (backup) provider, IF Gmail and/or Hotmail still allow this.</div></li>

        <li class="todoList"><div>(2026-2028) Music production app via linux commandline app sonic-pi, integration of that app with payment modules and musicPlayer.</div></li>

        <!--
        <li class="todoList"><div><p>(2022-Nov to 2023-Feb-10) Version 6.0 : improve the vividMenu, vividDialog and vividButton components.</p>
            <ol class="todoList_l1">
                <li><div>from now on, the NicerApp desktop will consist of :<br/>
                    <ol class="todoList_l2">
                        <li><div>na.desktop with na.desktop.resize() calling first na.desktop.gotoPreProcessor.parse(globalSettings, settingsForAppInUse) and then na.desktop.goto().</div></li>
<li><pre class="json">
template rendering engine N+1 :

na.vividUI.buttons.templates = [
    {
        "findCommand_template" : {
            "dataSetID" : "couchdbDatabaseNameSuffix",
            "dataSubSetID" : {
                "keyA" : 1,
                "keyB" : "abc21.2"
            }
        },
        "code" : "na.vividUI.buttons.someButtonClassName",
        "findCommand_templateTheme" : {
            "dataSetID" : "couchdbDatabase2nameSuffix",
            "dataSubSetID" : {
                "keyC" : 354,
                "keyD" : "77abc"
            }
        },
        "preRendering" : {
            "template" : { ... },
            "theme" : { ... }
        },
        "rendered" : {
            "template" : { ... },
            "theme" : { ... }
        }
    },
    { ... }
];
</pre>
<br/>
<div>
this data is stored as couchdb documents in a couchdb database with a prefix of the site's domain name, and a specific suffix.<br/>
it is fetched and parsed by NicerAppWebOS/db_init.php (in the db connector code) from raw JSON files in [to be decided folder path].<br/>

they are stored in the database to make it easier later on to write a Theme Editor tab page for copied templates.<br/>
<br/>
and what we do for buttons here, we can also do for dialogs and menus.
</div></li>
                    </ol>
                </div></li>




                <li><div>merge #btnOptions, #btnLoginLogout, #btnChangeBackground into #siteMenu.</div></li>
                <li><div>turn all menu items into vividButton instances, if they're not that already.</div></li>
                <li><div>let na.site.resize_doContent() determine if menu-items get a text rendered next to the icon if there is an icon for the menu item in question.</div></li>
                <li><div>add a 'pick the central rainbow color' vividMenu option, with a color-deviation range setting, to #btnOptions_menu</div></li>
                <li><div>improve menu display features :<br/>
                    <ol class="todoList_l2">
                        <li><div>restore the opacity features of the old much slower menu code.</div></li>
                        <li><div>add the ability to move from a menu-item into a vividDialogPopup component.</div></li>
                        <li><div>add the ability to toggle an on/off state (in combination with a 'hover' state(class)) for any menu item.</div></li>
                    </ol>
                </li>
                <li><div>upgrade the vividButton to it's final version 5 code :
                    <ol class="todoList_l2">
                        <li><div>add the ability for disabled or enabled, normal or selected, hoverOn or hoverOff extra class names to any vividButton html element. and respond accordingly to those classes in the vividButton js, of course.</div></li>
                        <li><div>for text menu items : add the ability to automatically determine height (at a minimum label font size) of the menu-item.</div></li>
                        <li><div>for icon and text menu items : add the ability to add any number of ordered layers in CSS, Canvas, SVG or even WebGL. as seperate files that get referenced from a centralized core of vividButton5 code.</div></li>
                        <li><div>retain the ability to use both an icon and a text menu item together.</div></li>
                    </ol>
                </li>
            </ol>
        </div></li>
        -->
    </ol>
