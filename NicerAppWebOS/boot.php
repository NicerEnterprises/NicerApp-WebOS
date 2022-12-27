<?php 
/*
THIS FILE MAY NOT BE CHANGED BY ANYONE EXCEPT The Owner OF
HTTPS://GITHUB.COM/NICERAPP AND HTTPS://NICERAPP.
IF YOU DO NEED THIS FILE CHANGED, EMAIL THE COMPLETE AND CHANGED FILE 
TO THE Current Owner AT THE FOLLOWING EMAIL ADDRESS :
rene.veerman.netherlands@gmail.com

NicerApp WCS (Website Control System) from Nicer Enterprises
*/
    define ("SESSION_ERRORS_ID", "NicerAppWebOS_errors_PHP");
    define ("SEID", SESSION_ERRORS_ID);

    define ("FILE_FORMATS_photos", "/^(.*\.png)|(.*\.gif)|(.*\.jpg)|(.*\.jpeg)$/");
    define ("FILE_FORMATS_mp3s", "/^(.*\.mp3)$/");
    define ("FILE_FORMATS_texts", "/^(.*\.txt)$/");
    define ("FILE_FORMATS_photos_texts", "/^(.*\.png)|(.*\.gif)|(.*\.jpg)|(.*\.jpeg)|(.*\.txt)$/");

    $rootPath_na = realpath(dirname(__FILE__).'/..');
    require_once($rootPath_na.'/NicerAppWebOS/lib_duration.php');
    require_once($rootPath_na.'/NicerAppWebOS/functions.php');
    require_once($rootPath_na.'/NicerAppWebOS/logic.business/class.NicerAppWebOS.errorHandler.php');
    require_once($rootPath_na.'/NicerAppWebOS/logic.business/class.NicerAppWebOS.log.php');

    $rootPath_na_dbs = $rootPath_na.'/NicerAppWebOS/logic.databases/generalizedDatabasesAPI-1.0.0';
    require_once ($rootPath_na_dbs.'/class.database_API.php');
    require_once ($rootPath_na_dbs.'/connectors/forFuture_design_coding_debugging_and_usage/class.fileSystemDB-1.0.0.php');

    require_once ($rootPath_na_dbs.'/connectors/forFuture_design_coding_debugging_and_usage/class.adodb5_1.0.0.php');
    require_once ($rootPath_na.'/NicerAppWebOS/3rd-party/adodb5/adodb.inc.php');

    require_once ($rootPath_na_dbs.'/connectors/class.couchdb-3.2.2_1.0.1.php');
    // Sag, the business code layer that i use towards the couchdb.apache.org database system.
    require_once($rootPath_na.'/NicerAppWebOS/3rd-party/sag/src/Sag.php');
    require_once ($rootPath_na.'/NicerAppWebOS/Sag-support-functions.php');



    //require_once ($rootPath_na.'/NicerAppWebOS/apps/NicerAppWebOS/application-programmer-interfaces/technology/codeTranslationSystems/boot.php');

    //require_once($rootPath_na.'/NicerAppWebOS/3rd-party/vendor/autoload.php'); // loads up a whole bunch of PHP libraries, including birke-rememberme.
    //require_once($rootPath_na.'/NicerAppWebOS/3rd-party/birke/rememberme/src/LoginResult.php'); // small change of my own in the birke-rememberme modern encrypted login system for web 4.0.

    // the main() class
    require_once($rootPath_na.'/NicerAppWebOS/logic.business/class.core.WebsiteOperatingSystem-5.y.z.php');

    global $naIP;
    if (
        function_exists('apache_request_headers')
        && array_key_exists('X-Forwarded-For',apache_request_headers())
    ) {
        $naIP = apache_request_headers()['X-Forwarded-For'];
    } elseif (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        $naIP = $_SERVER['REMOTE_ADDR'];
    } else {
        $naIP = 'OS commandline probably';
    }

    $naDebugAll = true;
    global $naDebugAll;
    if ($naDebugAll) {
        //TODO 1-0a
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        global $naBypassMainErrorHandler;
        if (!isset($naBypassMainErrorHandler) || $naBypassMainErrorHandler)
            $old_error_handler = set_error_handler ('mainErrorHandler');

        /*
        global $mainErrorLogFilepath; global $mainErrorLogLastWriteFilepath;
        $mainErrorLogFilepath = realpath(dirname(__FILE__)).'/siteLogs/error.'.date('Y-m-d_H.i.s').'.html.log';
        $mainErrorLogLastWriteFilepath = realpath(dirname(__FILE__)).'/siteLogs/error.'.date('Y-m-d_H.i.s').'.lastModified.txt';
        */
    }
    ini_set ('log_errors', true);
    global $error_log_filepath;
//echo '<pre>'; var_dump ($_SERVER); die();
    if (
        isset($_SERVER)
        && is_array($_SERVER)
        && array_key_exists('SERVER_NAME', $_SERVER)
        && array_key_exists('SERVER_PORT', $_SERVER)
    )   $error_log_filepath = '/var/log/apache2/NicerEnterprises-NicerApp-WebOS-'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'.log';
    else
        $error_log_filepath = '/var/log/apache2/NicerEnterprises-NicerApp-WebOS-cli.log';
    ini_set ('error_log', $error_log_filepath);


    if (php_sapi_name() !== 'cli') {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', 3600 * 24 * 7);
            session_start();
            /*
            if (isset($_COOKIE) && is_array($_COOKIE) && array_key_exists('cdb_loginName', $_COOKIE) && array_key_exists('cdb_authSession_cookie', $_COOKIE)) {
                $_SESSION['cdb_authSession_cookie'] = $_COOKIE['cdb_authSession_cookie'];
                $_SESSION['cdb_loginName'] = $_COOKIE['cdb_loginName'];
            } else {
                $_SESSION['cdb_authSession_cookie'] = null;
                $_SESSION['cdb_loginName'] = 'Guest';
            }*/
        } else session_start();
        $_SESSION['naErrors'] = [];
        $_SESSION['naErrors_startup'] = [];
        $_SESSION['naErrors_js'] = [ 'bootup' => [] ];
    }
    
    global $filePerms_ownerUser;
    global $filePerms_ownerGroup;
    global $filePerms_perms_publicWriteableExecutable;
    global $filePerms_perms_readonly;
    global $filePerms_perms_readWrite;

    $filePerms_ownerUser = 'rene';
    $filePerms_ownerGroup = 'www-data'; 
    $filePerms_perms_readonly = 0640;
    $filePerms_perms_readWrite = 0640;
    $filePerms_perms_publicWriteableExecutable = 0770; // note : these are the file permissions for PUBLICLY ACCESSIBLE FILES only!

    global $naWebOS;
    $naWebOS = new NicerAppWebOS();
    $naWebOS->initializeDatabases();
    $naWebOS->initializeGlobals();

    // at the *bottom* of this file (that's for good reasons), 
    // you will find : require_once(dirname(__FILE__).'/apps/nicer.app/api.paymentSystems/boot.php');
    
    
    // 8G maximum working memory for index.php and all AJAX script calls in PHP land *is* the ideal number. 
    // OR : maybe 4G or 2G or 1G. BECAUSE you *do* want to give the apps themselves enough room to process huge amounts of data in PHP land.
    // OR : you could go "dictatorial"/"supreme commander" on your PHP environment (app/library), and restrict to 100M, 200M, 400M, or 500M.
    // 100M = 100 megabyte
    // 8G = 8 gigabyte, half the available RAM on a modern PC.
    // The best place to be overriding the following values (up to 'error_log') is in .../NicerAppWebOS/apps/YOURCOMPANYNAME.TLD/boot.php,
    // which you then require_once() from all of your products' pages and AJAX scripts.
    ini_set('memory_limit','8G'); // [MARKETING SLOGAN 1] NicerApp WCS : a tiny daily memory consumption among all WCS systems already out there. 
    set_time_limit(2 * (60 * 60)); // 2 hours, in seconds
    

    //echo '<pre>'; var_dump ($_SERVER); exit();
    

    $lanConfigFilepath = realpath(dirname(__FILE__)).'/domainConfigs/'.$naWebOS->domain.'/naLAN.json';
    $lanConfigExampleFilepath = realpath(dirname(__FILE__)).'/domainConfigs/'.$naWebOS->domain.'/naLAN.EXAMPLE.json';
    if (!file_exists($lanConfigFilepath)) 
        trigger_error ('"'.$lanConfigFilepath.'" does not exist. See "'.$lanConfigExampleFilepath.'" for a template.', E_USER_ERROR);
    $lanConfigRaw = file_get_contents($lanConfigFilepath);
    $lanConfig = json_decode($lanConfigRaw, true);
    checkForJSONerrors($lanConfigRaw, $lanConfigFilepath, $lanConfigExampleFilepath);
    
    global $naLAN;
    $naLAN = (
        $naIP === '::1'
        || $naIP === '127.0.0.1'
        || in_array($naIP, $lanConfig)
    );

    // make globals variable holding the version number
    $naVersionNumber = file_get_contents(dirname(__FILE__).'/VERSION.txt');
    global $naVersionNumber;
    $naVersion = 'https://github.com/NicerEnterprises/nicerapp '.$naVersionNumber;
    global $naVersion; 
    
    // overrides by the site operator go here :
    // NOTE : YOU WILL LIKELY HAVE TO CHANGE global $filePerms_ownerUser, defined in this file.
    $fn = dirname(__FILE__).'/apps/siteOperator_boot.php';
    if (file_exists($fn)) require_once ($fn);

    require_once(dirname(__FILE__).'/apps/NicerAppWebOS/application-programmer-interfaces/technology/authentication/paymentSystems/boot.php');
    
    
    // oAuth like login systems and others like that :
    // everything excluding the NicerApp and NicerApp->couchdb login systems, basically.
    require_once(dirname(__FILE__).'/apps/NicerAppWebOS/application-programmer-interfaces/technology/authentication/loginSystems/boot.php');
?>
