<h1>nicerapp couchdb initialization script</h1>
<?php 

// default usage (bookmark this for https://YOURDOMAIN.TLD/NicerAppWebOS/db_init.php?....) :
// http://localhost/NicerAppWebOS/db_init.php?doTree=y&doThemeData=y&doMenu=y&doAPI_imageSearch=y&doApp_news=y&doApp_webmail=y&doApp_3D_fileExplorer=y
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


global $naBypassMainErrorHandler; $naBypassMainErrorHandler = true;
require_once (realpath(dirname(__FILE__)).'/boot.php');

$debug = true; 
global $naLAN;

$ip = (array_key_exists('X-Forwarded-For',apache_request_headers())?apache_request_headers()['X-Forwarded-For'] : $_SERVER['REMOTE_ADDR']);
if (
    $ip !== '::1'
    && $ip !== '127.0.0.1'
    && !$naLAN
) {
    header('HTTP/1.0 403 Forbidden');
    echo '403 - Access forbidden.';
    exit();
}

global $naWebOS;
//echo '<pre>'; var_dump ($naWebOS); exit();

$dbs = [
    'analytics',
    'errorHandling', 'logEntries',
    'data_by_users', 'views',
    'cms_tree',
    'cms_tree__role__guests',
    'cms_tree__user__administrator',
    'cms_tree__user__guest',
    'cms_documents__role__guests',
    'cms_documents__user__administrator',
    'cms_documents__user__guest',
    'data_themes',
    'api_wallpaperscraper__plugin_bingImages',
    'api_wallpaperscraper__plugin_googleImages',
    'app_2D_news__rss_items',
    'app_2D_webmail__accounts',
    'app_3D_fileManager__tree_d_positions'
];
$dbs2 = [];
foreach ($dbs as $i => $db) {
    $dbs2[$db] = false;
}
$dbs = $dbs2;
//echo '<pre style="color:blue">'; var_dump ($dbs); echo '</pre>';

function mustDo ($dbCategoryName) {
    $fncn = '.../NicerAppWebOS/db_init.php::mustDo($dbCategoryName)';

    $key = 'do'.strtoupper(substr($dbCategoryName,0,1)).substr($dbCategoryName,1);
    if (array_key_exists($key, $_GET)) {
        return $_GET[$key]!=='no';

    } elseif (array_key_exists('dbCategoryNames', $_GET)) {
        $mustDoDBs = json_decode(base64_decode_url($_GET['dbCategoryNames']), true);
        $in = in_array($dbCategoryName, $mustDoDBs);
        if ($in && $mustDoDBs[$dbCategoryName]!=='no') return true; else return false;
    }

    return true;
}

function goDo ($dbs, $goDoItems) {
    foreach ($goDoItems as $i => $ii) {
        $dbs[$ii] = true;
    }
    return $dbs;
}

if (mustDo('analytics')) {
    $dbs = goDo ($dbs, [ 'analytics' ]);
}
if (mustDo('log')) {
    $dbs = goDo ($dbs, [ 'errorHandling', 'logEntries' ]);
}
if (mustDo('urlRedirection')) {
    $dbs = goDo ($dbs, [ 'data_by_users', 'views' ]);
}

//echo '<pre style="color:red">'; var_dump (mustDo('cms')); echo '</pre>';
if (mustDo('cms')) {
    $dbs = goDo ($dbs, [
        'cms_tree',
        'cms_tree__role__guests',
        'cms_tree__user__administrator',
        'cms_tree__user__guest',
        'cms_documents__role__guests',
        'cms_documents__user__administrator',
        'cms_documents__user__guest'
    ]);
};
if (mustDo('themeData')) {
    $dbs = goDo ($dbs, [ 'data_themes' ]);
};
if (mustDo('api_imageSearch')) {
    $dbs = goDo ($dbs, [
        'api_wallpaperscraper__plugin_googleImages',
        'api_wallpaperscraper__plugin_bingImages'
    ]);
};
if (mustDo('app_news')) {
    $dbs = goDo ($dbs, [ 'app_2D_news__rss_items' ]);
};
if (mustDo('app_webmail')) {
    $dbs = goDo ($dbs, [ 'app_2D_webmail__accounts' ]);
};
if (mustDo('app_fileManager')) {
    $dbs = goDo ($dbs, [ 'app_3D_fileManager__tree_d_positions' ]);
};
//echo '<pre style="color:blue">'; var_dump ($dbs); echo '</pre>';

$allDBs = $naWebOS->dbsAdmin->getAllDatabases ();
//echo '<pre style="color:green">'; var_dump ($allDBs); echo '</pre>'; die();
//echo '<pre style="color:green">'; var_dump ($dbs); echo '</pre>'; die();
echo $naWebOS->dbsAdmin->listDatabases ($allDBs, $dbs);

$naWebOS->dbsAdmin->createUsers();
$naWebOS->dbsAdmin->clearOutDatabases ($dbs);
$naWebOS->dbsAdmin->createDatabases ($dbs);
?>
