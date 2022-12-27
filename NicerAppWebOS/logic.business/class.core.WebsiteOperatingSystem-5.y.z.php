<?php
$rootPath_na = realpath(dirname(__FILE__).'/../..'); global $rootPath_na;

class NicerAppWebOS {
    public $cn = '.../NicerAppWebOS/logic.business/class.core.WebsiteOperatingSystem-5.y.z.php::class NicerAppWebOS';
    public $version = '5.0.0';
    public $about = array(
        'whatsThis' => 'NicerApp Content Management System PHP class',
        'version' => '5.0.0',
        'history' => 'See HISTORY_and_FUTURE.html in the same folder as this file. For more information on the To-Do list for NicerApp WCS, see it\'s default front page.',
        'lastModified' => 'Sunday, 21 July, 2022, 05:00 CEST (Amsterdam.NL timezone)',
        'copyright' => 'Copyright (c) and (r) 2002-2022 by Rene A.J.M. Veerman <rene.veerman.netherlandsd@gmail.com>'
    );

    public $initialized = false;
    public $baseIndentLevel = 2;
    public $cssTheme = 'dark';
    
    public $ip = null;
    public $domain;
    public $basePath;
    public $selfHealer;
    public $view;
    
    //--- database entry point variables ---* /
    public $dbs = null; // database class instance that's logged in as the end-user.
    public $dbsAdmin = null; // database class instance that's logged in as the COUCHDB ADMIN USER.
    public $hasDB = null;
    public $showAllErrors = false;
    
    //--- business logic level 1 NicerApp from Nicer Enterprises core entry point variables
    public $cts; // code translation system of the NicerApp WCS (Websites Control System) as a whole
    public $comments; // comments system for pages on NicerApp WCS (Websites Control System).
    
    public function __construct () {
        $fncn = $this->cn.'->__construct()';
		$this->basePath = realpath(dirname(__FILE__).'/../..');
        //echo $this->basePath; exit();
        $this->cssTheme = 'dark';
        if (array_key_exists ('siteTheme', $_POST)) $this->cssTheme = $_POST['siteTheme'];
        if (array_key_exists ('siteTheme', $_COOKIE)) $this->cssTheme = $_COOKIE['siteTheme'];
        $p1 = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');
        $p2 = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');
        $this->domain = str_replace($p1.DIRECTORY_SEPARATOR,'', $p2);
        //var_dump ($this->domain); die();

        $dfd = strtolower($this->domain);
        $dfd = str_replace('.', '_', $dfd);
        if (preg_match('/^\d/', $dfd)) {
            $dfd = 'number_'.$dfd;
        }
        $this->domainForDB = $dfd;


        $midsFile =
            $this->basePath.'/NicerAppWebOS/apps/'
            .'manufacturerNameForDomainName_'.$this->domain.'_val.txt';
        if (!file_exists($midsFile))
            trigger_error ($fncn.' : file "'.$midsFile.'" does not exist', E_USER_ERROR);
        if (!is_readable($midsFile))
            trigger_error ($fncn.' : file "'.$midsFile.'" is not readable. run .../NicerAppWebOS/scripts.maintenance/setPermissions.sh from the commandline please', E_USER_ERROR);
        $mfc = trim(file_get_contents ($midsFile));

        $this->viewsMIDpath =
            $this->basePath.'/NicerAppWebOS/apps/'
            .str_replace($this->domain, $mfc, $midsFile);
        $this->viewsMID = $mfc;

        //var_dump ($this->view); exit();
        // bll1 (business logic level 1 of NicerApp WCS Core Websites Code (Computer Language:PHP, OS:Linux Kubuntu and Linux Ubuntu,, database:couchdb)) :: :: variables initialization
        //$this->cts = new class_api_codeTranslationSystem_for_NicerAppWebOS_5_y_z();
        //$this->comments = new class_NicerApp_WCS_api_comments_v1_0_0()    ;
        
        if (function_exists('apache_request_headers')) {
            $this->ip = (array_key_exists('X-Forwarded-For',apache_request_headers())?apache_request_headers()['X-Forwarded-For'] : $_SERVER['REMOTE_ADDR']);
        }
    }

    public function getDataID ($dataSetName, $fieldName, $value=null) {
        $db = $this->dbs->findConnection('couchdb');
        return $db->getNewRandomID ($dataSetName, $fieldName, $value);
    }

    public function getViewFromShortenedURL ($views) {
        global $rootPath_na;
        $fn = $rootPath_na.'/NicerAppWebOS/siteCache/mainmenu.reverse.csv';
        //echo't2:'; var_dump (file_exists($fn)); die();
        $fp = fopen($fn, 'r');
        $lines = array();
        while(!feof($fp) && ($line = fgetcsv($fp)) !== false) {
            $urlToSearchFor = substr($line[0], 1, -1);
            if ($urlToSearchFor===$views) return json_decode(base64_decode_url($line[1]), true);
        }
        fclose($fp);
        return false;
    }

    public function initializeDatabases () {
        $fncn = $this->cn.'::initializeDatabases()';

        $this->hasDB = false;
        if ($this->dbs===null) {
            $this->dbs = 'initializing';
            // logged in as the end-user.
            //$this->db = new class_NicerAppWebOS_database_API_couchdb_3_2 (clone $this, false);
            try {
                $this->dbs = new class_NicerAppWebOS_database_API ('Guest');
                //echo '<pre>'; var_dump ($this->dbs);die();
                setcookie('cdb_loginName' ,$this->dbs->findConnection('couchdb')->username, time() + 604800, '/');

            //echo '<pre>'; var_dump ($this->dbs); exit();

                if (php_sapi_name() !== 'cli') {
                    //WILL NEVER WORK; HANDLED BY logic.AJAX/ajax_testDBconnection.php! setcookie('cdb_loginName' ,$this->dbs->findConnection('couchdb')->username, time() + 604800, '/');
                    $_SESSION['cdb_loginName'] = $this->dbs->findConnection('couchdb')->username;
                }

                $this->hasDB = true;
            } catch (Throwable $error) {
                echo '<pre>';
                echo $fncn.' : Throwable $error=';//.json_encode($error,JSON_PRETTY_PRINT);;
                var_dump ($error);
                echo '</pre>';
                die();
            } catch (Exception $error) {
                echo '<pre>';
                echo $fncn.' : Exception $error=';//.json_encode($error,JSON_PRETTY_PRINT);;
                var_dump ($error);
                echo '</pre>';
                die();
            }
        }

        if ($this->dbsAdmin===null) {
            $this->dbsAdmin = 'initializing';
            // logged in as $cdbConfig['adminUsername']!
            //$this->dbAdmin = new class_NicerAppWebOS_database_API_couchdb_3_2 (clone $this, true);
            try {
                $this->dbsAdmin = new class_NicerAppWebOS_database_API ('admin');

                if (php_sapi_name() !== 'cli') {
                    //WILL NEVER WORK; HANDLED BY logic.AJAX/ajax_testDBconnection.php! setcookie('cdb_admin_loginName' ,$this->dbsAdmin->findConnection('couchdb')->username, time() + 604800, '/');
                    $_SESSION['cdb_admin_loginName'] = $this->dbsAdmin->findConnection('couchdb')->username;
                }

                $this->hasDB = true;
            } catch (Throwable $e) {
            } catch (Exception $e) {
            }
        }

        $this->initialized = true;
    }

    public function initializeGlobals() {
        $fncn = $this->cn.'::initializeGlobals()';
        global $argv;
        $this->url = array_key_exists('REQUEST_URI', $_SERVER)
            ? $_SERVER['REQUEST_URI']
            : $argv[0];
        $this->showAllErrors = !array_key_exists('sae', $_REQUEST) || $_REQUEST['sae']==='y';
        if (array_key_exists('viewID', $_GET)) {
            if (
                $_GET['viewID']==''
                || $_GET['viewID']=='/'
            ) {
                $view = [
                    '/' => [
                        'page' => 'index'
                    ]
                ];
            } else {
                // request view settings from database
                //echo '<pre>';var_dump ($_GET);
                $decoded = json_decode(base64_decode_url($_GET['viewID']), true);
                //var_dump (json_last_error());
                if (json_last_error()!==0) {
                    // $view must be looked up in the database :
                    $db = $this->dbs->findConnection('couchdb');
                    $cdb = $db->cdb;
                    $dataSetName = $db->dataSetName('views'); // i know, couchdb calls a 'table' a 'database'. and that sux.

                    $cdb->setDatabase ($dataSetName, false);
                    $findCommand = [
                        'selector' => [ 'viewID' => $_GET['viewID'] ],
                        'use_index' => 'primaryIndex',
                        'fields' => ['_id']
                    ];
                    try {
                        $call = $cdb->find ($findCommand);
                    } catch (Exception $e) {
                        $msg = $fncn.' FAILED while trying to find in \''.$dataSetName.'\' : '.$e->getMessage();
                        trigger_error ($msg, E_USER_NOTICE);
                        echo $msg;
                        return false;
                    }
//echo '<pre>'; var_dump ($findCommand); var_dump ($call); echo '</pre>'; die();
                    if (
                        is_object($call)
                        && is_object($call->body)
                        && is_array($call->body->docs)
                    ) {
                        if (count($call->body->docs)===0) {
                            $view = $this->getViewFromShortenedURL ($_GET['viewID']);
                        } elseif (count($call->body->docs)===1) {
                            $call = $cdb->get ($call->body->docs[0]['_id']);
                            $view = $call->body->docs[0]['view'];
                        } elseif (count($call->body->docs)>1) {
                            $msg = $fncn.' : multiple views for viewID='.$_GET['viewID'].' were found. using only the first.';
                            trigger_error($msg, E_USER_WARNING);
                            echo $msg;
                            error_log($msg);

                            $call = $cdb->get ($call->body->docs[0]['_id']);
                            $view = $call->body->docs[0]['view'];
                        } else $view = $this->getViewFromShortenedURL ($_GET['viewID']);
                    } else $view = $this->getViewFromShortenedURL ($_GET['viewID']);

                } else {
                    // $view is prepared by .../.htaccess
                    $view = $decoded;
                }

                //echo 'class.NicerApp.core.WebsiteControlSystem-5.y.z.php::__construct() :'; var_dump ($view);  var_dump (is_null($view)); die();
            }
            $this->view = $view;
        }
    }

    public function getSite() {
        global $naWebOS;
        global $rootPath_na;
        $rp_domain = $rootPath_na.'/NicerAppWebOS/domainConfigs/'.$this->domain;
        $templateFile = $rp_domain.'/index.template.php';
        $templateCustomerFile = $rp_domain.'/index.template.customer.php';
        //var_dump ($this->view); exit();
        if (array_key_exists('viewID', $_GET)) {
            if ($_GET['viewID']=='/') {
                $titleFile = $rp_domain.'/index.title.php';
            } else {
                $view = $naWebOS->view;//json_decode (base64_decode_url($_GET['vi']), true);
                $this->view = $view;
                //echo '<pre>';var_dump($_GET);var_dump ($this->view);exit();
                
                foreach ($this->view as $viewFolder => $viewSettings) {
                    $titleFile = realpath(dirname(__FILE__).'/../..').'/'.$viewFolder.'/app.title.site.php';
                }
            }
        } else {    
            $titleFile = $rp_domain.'/index.title.php';
        }
        if (!isset($view) && !file_exists($titleFile)) {
            trigger_error ('app.title.site.php missing for app=frontpage_of_site, $titleFile="'.$titleFile.'"', E_USER_ERROR);
        } elseif (!isset($titleFile)) {
            trigger_error ('app.title.site.php missing for app='.json_encode($view), E_USER_ERROR);
        }

        $cssLinks = $this->getLinks ( [
            [ 'indexFile' => $rp_domain.'/index.css.json', 'type' => 'css' ],
            [ 'files' => $this->getVividButtonCSSfiles(), 'type' => 'css' ]
        ] );
        $javascriptLinks = $this->getLinks ( [
            [ 'indexFile' => $rp_domain.'/index.javascripts.json', 'type' => 'javascript' ],
            //[ 'indexFile' => $rp_domain.'/index.customerJavascripts.json', 'type' => 'javascript' ],
            [ 'files' => $this->getVividButtonJavascriptFiles(), 'type' => 'javascript' ]
        ] );

        $siteMenu_avoid = json_encode( [
            '#siteDateTime', '#btnOptions', '#btnLoginLogout', '#btnChangeBackground'
        ] );
        
        if (file_exists($templateCustomerFile)) 
            $templateCustomer = execPHP($templateCustomerFile); else $templateCustomer = '';
        
        $replacements = array (
            //'{$view}' => ( is_array($view) ? json_encode($view, JSON_PRETTY_PRINT) : '{}' ),
            '{$title}' => execPHP($titleFile),
            '{$domain}' => $this->domain,
            '{$cssLinks}' => $cssLinks,
            '{$javascriptLinks}' => $javascriptLinks,
            '{$customerHTML}' => $templateCustomer,
            '{$pageSpecificCSS}' => $this->getPageCSS(),
            '{$theme}' => $this->cssTheme,
            '{$viewport}' => $this->getMetaTags_viewport(),
            '{$siteMenu_avoid}' => $siteMenu_avoid
        );        
        $content = $this->getContent();
        //var_dump ($content); exit();

        //  NOT needed anymore, the .../NicerAppWebOS/site-5.y.z.js script will call
        //  .../NicerAppWebOS/domainConfigs/YOURDOMAIN_TLD/mainmenu.php and initialize the #siteMenu
        //  with data either gotten from a database architecture, or via calculations done at
        //  startup time
        //$content['siteMenu'] = $this->getSiteMenu();

        $content['siteErrors'] = '';
        foreach ($_SESSION['naErrors_startup'] as $idx => $msg) {
            $content['siteErrors'] .= $msg;
        }
        foreach ($_SESSION['naErrors'] as $idx => $msg) {
            $content['siteErrors'] .= $msg;
        };
        foreach ($content as $divName=>$contentForDiv) {
            //$contentForDiv = htmlentities($contentForDiv);
            $arr = array ( '{$div_'.$divName.'}' => $contentForDiv );
            $replacements = array_merge ($replacements, $arr);
        }
        $search3 = array_keys($replacements);
        $replace3 = array_values($replacements);
        $html = require_return($templateFile, false);
        //var_dump($html); exit();
        $html3 = str_replace ($search3, $replace3, $html);
        //var_dump($html3);
        $debug = false;
        if ($debug) {
            echo '<pre>'; 
             echo '$search3='; var_dump ($search3); echo PHP_EOL.PHP_EOL;
            echo '$replace3=';var_dump ($replace3); echo PHP_EOL.PHP_EOL;
            echo '</pre>';
            exit();
        }
        return $html3;
    }
    
    public function getLinks ($files) {
        $lines = '';
        foreach ($files as $idx => $fileRec) {
            if (array_key_exists('indexFile', $fileRec)) {
                $indexFilepath = $fileRec['indexFile'];
                $filesRaw = file_get_contents($indexFilepath);
                $files = json_decode ($filesRaw);
                checkForJSONerrors ($filesRaw, $indexFilepath, '"null"');
            } else if (array_key_exists('files', $fileRec)) {
                $files = $fileRec['files'];
            }
            $indexType = $fileRec['type'];
            
            switch ($indexType) {
                case 'css': $lineSrc = "\t".'<link type="text/css" rel="StyleSheet" href="{$src}?c={$changed}">'."\r\n"; break;
                case 'javascript': $lineSrc = "\t".'<script type="text/javascript" src="{$src}?c={$changed}"></script>'."\r\n"; break;
            };
            
            foreach ($files as $idx => $file) {
                //trigger_error ($file.' (1)', E_USER_NOTICE);
                $oFile = $file;
                $file = str_replace ('apps/{$domain}', 'apps/'.$this->viewsMID, $file);
                $file = str_replace ('apps/'.$this->domain, 'apps/'.$this->viewsMID, $file);
                $file = str_replace ('{$domain}', $this->domain, $file);
                //trigger_error ($file.' (2)', E_USER_NOTICE);
                if (file_exists($this->basePath.'/'.$file)) {
                    $url = str_replace ($this->basePath,'',$file);
                    $search = array ('{$src}', '{$changed}');
                    $replace = array ($url, date('Ymd_His', filemtime($this->basePath.'/'.$file)));
                    $lines .= str_replace ($search, $replace, $lineSrc);
                } else {
                    trigger_error ('file "'.$this->basePath.'/'.$file.'" is missing (oFile='.$oFile.'), referenced from <span class="naCMS_getLinksFileRec">'.json_encode($fileRec).'</span>.', E_USER_ERROR);
                }
            }
        }
        return $lines;
    }
    
    public function getVividButtonCSSfiles () {
        global $rootPath_na;
        $basePath = $rootPath_na.'/NicerAppWebOS/logic.userInterface/vividUI-5.0.0/vividButton-4.1.0';
        $files = getFilePathList ($basePath, true, '/btn_.*\.css/', null, array('file'), 1);
        foreach ($files as $idx => $file) {
            $files[$idx] = str_replace($this->basePath, '', $file);
        }
        sort($files);
        return array_merge ([ '/NicerAppWebOS/logic.userInterface/vividUI-5.0.0/vividButton-4.1.0/themes.css' ], $files);
    }
    
    public function getVividButtonJavascriptFiles () {
        global $rootPath_na;
        $basePath = $rootPath_na.'/NicerAppWebOS/logic.userInterface/vividUI-5.0.0/vividButton-4.1.0';
        $files = getFilePathList ($basePath, true, '/btn_.*\.source\.js/', null, array('file'), 1);
        foreach ($files as $idx => $file) {
            $files[$idx] = str_replace($this->basePath, '', $file);
        }
        sort ($files);
        return $files;
    }

    public function nonEmptyStringField ($fieldName, $arr) {
        if (
            array_key_exists($fieldName, $arr)
            && is_string ($arr[$fieldName])
            && $arr[$fieldName]!==''
        ) return true;
        return false;
    }

    public function getContent () {
        $fncn = $this->cn.'::getContent()';
        // see also : .../.htaccess and more specifically .../NicerAppWebOS/scripts.maintenance/.htaccess.build.part2.txt
        if (!is_array($_GET)) {
            $msg = $fncn.' : FAILED (this was not called via a web-browser).';
            trigger_error ($msg, E_USER_ERROR);
            return $this->getContent__standardErrorMessage($msg);
        } else {
            if (
                $this->nonEmptyStringField('username',$_GET)
                && $this->nonEmptyStringField('dataID',$_GET)
            ) return $this->getContent__data_by_users ($_GET['username'], $_GET['dataID']);

            elseif ( $this->nonEmptyStringField('viewID',$_GET) )
                return $this->getContent__view ($_GET['viewID']); // this handles the front page of a website too.

            else return $this->getContent__standardErrorMessage(
                $fncn.' : FAILED (this was not called with the right parameters). parameters are '.json_encode($_GET)
            );
        }
    }

    public function getContent__standardErrorMessage ($msg) {
        $ret = [];
        $file = $this->basePath.'/NicerAppWebOS/domainConfigs/'.$this->domain.'/errorMessage.default.php';
        if (!file_exists($file) || !is_readable($file)) {
            $html = $msg;
            $ret['siteContent'] = $html;
        } else {
            $fc = file_get_contents ($file);
            $html = str_replace('{$msg}', $msg, $fc);
            $ret['siteContent'] = $html;
        }
        return $ret;
    }

    public function getContent__view ($viewID=null) {
        $fncn = $this->cn.'::getContent_view()';
        global $naWebOS;

        $ret = [];
        if (!is_string($viewID) || $viewID==='') {
            $msg = $fncn.' : FAILED (invalid or empty viewID parameter).';
            trigger_error ($msg, E_USER_ERROR);
            return $this->getContent_standardErrorMessage ($msg);
        } else {
            if ($viewID==='/') {
                // output frontpage.dialog.*.php
                $folder = $this->basePath.'/NicerAppWebOS/domainConfigs/'.$naWebOS->domain.'/';
                $files = getFilePathList($folder, false, '/frontpage.dialog.*\.php/', null, array('file'), 1);
                //if ($debug) { echo $folder.'<br/>'.PHP_EOL; echo json_encode($files); echo PHP_EOL.PHP_EOL; };

                foreach ($files as $idx2 => $filepath) {
                    $fileRoot = $folder;
                    $filename = str_replace ($fileRoot, '', $filepath);
                    $dialogID = str_replace ('frontpage.dialog.', '', $filename);
                    $dialogID = str_replace ('.php', '', $dialogID);
                    $arr = array ( $dialogID => require_return($filepath) );
                    //var_dump ($filepath); echo PHP_EOL;
                    //var_dump ($dialogID); echo PHP_EOL;
                    //$arr = array ( $dialogID => $filepath );
                    $ret = array_merge ($ret, $arr);
                }

            } else {
                // request view settings from database
                $view = $this->view;
                if (is_array($view)) {
                    if (array_key_exists('misc', $view)) {
                        $fsid = $view['misc']['folder'];
                        foreach ($view as $k => $rec) {
                            if ($k=='misc') continue; else {
                                $fid = $k;
                                $rp = $fsid.'/'.$fid;
                            }
                        }
                        $view = [ $rp => $rec ];
                    }
                    //echo '<pre style="color:purple;background:cyan;">'; var_dump ($view); echo '</pre>'; die();

                    foreach ($view as $viewsFolder => $viewSettings) {
                        $files = getFilePathList ($this->basePath.'/'.$viewsFolder, true, '/app.*/', null, array('file'), 1);
                        //if ($debug)
                        //{ var_dump ($rootPath.'/'.$viewsFolder); echo '<pre style="color:yellow;background:red;">'; var_dump ($files); echo '</pre>'.PHP_EOL.PHP_EOL;  };

                        $titleFile = $this->basePath.'/'.$viewsFolder.'/app.title.site.php';
                        $ret = [];
                        foreach ($files as $idx3 => $contentFile) {
                            if (strpos($contentFile, 'app.dialog.')!==false) {
                                $divID = str_replace('app.dialog.', '', basename($contentFile));
                                $divID = str_replace('.php', '', $divID);
                                $ret[$divID] = execPHP ($contentFile);
                            }
                        }
                        //$contentFile = $rootPath.'/'.$viewsFolder.'/app.dialog.siteContent.php';
                        //$ret = [ 'siteContent' => execPHP ($contentFile) ];
                    }
                }



                // render view
                // ....
            }

            if (
                strpos($_SERVER['SCRIPT_NAME'], '/index.php')!==false
                || strpos($_SERVER['SCRIPT_NAME'], '/ajax_get_content.php')!==false
            ) $ret = array_merge ($ret, [
                'head' => $this->getPageCSS()
            ]);

            return $ret;

        }
    }

    public function getContent__data_by_users ($username=null, $dataID=null) {
        $fncn = $this->cn.'::getContent__data_by_users()';
        global $rootPath_na;
        global $naWebOS;
        $db = $naWebOS->dbs->findConnection('couchdb');
        $cdb = $db->cdb;

        $relTableName = 'data_by_users';
        $dataSetName = $db->dataSetName($relTableName);
        $cdb->setDatabase ($dataSetName, false);

        // am i called with the correct parameters, or not?
        if (
            !is_string($username)
            || $username===''
            || !is_string($dataID)
            || $dataID===''
        ) {
            $msg = $fncn.' : FAILED (invalid or empty "username" and/or "dataID" parameter(s)).';
            trigger_error ($msg, E_USER_ERROR);
            return $this->getContent_standardErrorMessage ($msg);
        } else {

            // fetch dataRecord
            $findCommand = [
                'selector' => [ 'user' => $username, 'dataSubSetID' => $dataID ],
                'use_index' => 'primaryIndex',
                'fields' => ['_id']
            ];
            //echo '<pre style="padding:8px;border-radius:10px;background:rgba(255,255,255,0.5);color:green;">'; var_dump ($findCommand); echo '</pre>';
            try {
                $call = $cdb->find ($findCommand);
            } catch (Exception $e) {
                $msg = $fncn.' FAILED while trying to find in \''.$dataSetName.'\' : '.$e->getMessage();
                trigger_error ($msg, E_USER_ERROR);
                echo $msg;
                return false;
            }

            //echo '<pre style="color:blue">'; var_dump ($dataSetName); var_dump ($findCommand); var_dump ($call);var_dump (count($call->body->docs));die();

            if (count($call->body->docs)===0) {
                $msg = 'Content could not be found.';
                return $this->getContent__standardErrorMessage ($msg);
            }

            $call2 = $cdb->get ($call->body->docs[0]->_id);
            //echo '<pre style="color:blue">'; var_dump ($call2);die();
            $dataRecord = (array)$call2->body;
            //echo '<pre style="color:green">'; var_dump ($dataRecord);die();



            if (array_key_exists('viewID', $dataRecord)) {
                // request view settings from database
                $viewID = $dataRecord['viewID'];

                $db = $this->dbs->findConnection('couchdb');
                $cdb = $db->cdb;
                $dataSetName = $db->dataSetName('views'); // i know, couchdb calls a 'table' a 'database'. and that sux.

                $findCommand = [
                    'selector' => [ 'viewID' => $viewID ],
                    'use_index' => 'primaryIndex',
                    'fields' => '_id'
                ];
                try {
                    $call3 = $cdb->find ($findCommand);
                } catch (Exception $e) {
                    $msg = $fncn.' FAILED while trying to find in \''.$dataSetName.'\' : '.$e->getMessage();
                    trigger_error ($msg, E_USER_ERROR);
                    echo $msg;
                    return false;
                }

                $call = $cdb->get ($call->body[0]['_id']);
                $view = $call->body[0];

                // overlay view settings, data from {$myDomain_tld}___views with
                //  data from {$myDomain_tld}___data_by_user::appParameters
                if (is_array($view['view'])) {
                    foreach ($view['view'] as $viewKey => $viewRecord) {
                        foreach ($dataRecord['appParameters'] as $drAppIdx => $drAppRecord) {
                            foreach ($drAppRecord as $viewKey2 => $viewRecord2) {
                                if ($viewKey === $viewKey2) {
                                    $view['view'][$viewKey2] = array_merge (
                                        $view['view'][$viewKey2],
                                        $viewRecord2
                                    );
                                }

                            }
                        }
                    }
                }
            } else {
                global $toArray;
                $view = $toArray($dataRecord['viewSettings']);
            }
            //echo '<pre style="color:green">'; var_dump ($view);die();
            $this->view = $view;

            // render the view
            if (is_array($view)) {
                if (array_key_exists('misc', $view)) {
                    $fsid = $view['misc']['folder'];
                    foreach ($view as $k => $rec) {
                        if ($k=='misc') continue; else {
                            $fid = $k;
                            $rp = $fsid.'/'.$fid;
                        }
                    }
                    $view = [ $rp => $rec ];
                }
                //echo '<pre style="color:purple;background:cyan;">'; var_dump ($view); echo '</pre>'; die();

                foreach ($view as $viewsFolder => $viewSettings) {
                    $rootPath = str_replace('/NicerAppWebOS','',$rootPath_na);
                    $files = getFilePathList ($rootPath.'/'.$viewsFolder, true, '/app.*/', null, array('file'), 1);
                    //if ($debug)
                    //{ var_dump ($rootPath.'/'.$viewsFolder); echo '<pre style="color:yellow;background:red;">'; var_dump ($files); echo '</pre>'.PHP_EOL.PHP_EOL;  };

                    $titleFile = $rootPath.'/'.$viewsFolder.'/app.title.site.php';
                    $ret = [];
                    foreach ($files as $idx3 => $contentFile) {
                        if (strpos($contentFile, 'app.dialog.')!==false) {
                            $divID = str_replace('app.dialog.', '', basename($contentFile));
                            $divID = str_replace('.php', '', $divID);
                            $ret[$divID] = execPHP ($contentFile);
                        }
                    }
                    //$contentFile = $rootPath.'/'.$viewsFolder.'/app.dialog.siteContent.php';
                    //$ret = [ 'siteContent' => execPHP ($contentFile) ];
                }
            }


            if (
                strpos($_SERVER['SCRIPT_NAME'], '/index.php')!==false
                || strpos($_SERVER['SCRIPT_NAME'], '/ajax_get_content.php')!==false
            ) $ret = array_merge ($ret, [
                'head' => $this->getPageCSS()
            ]);

            return $ret;
            //echo json_encode($ret);

        }
    }

            
    public function getContent_version_4_y_z () {
        //return '<pre>'.json_encode($_GET,JSON_PRETTY_PRINT).'</pre>';
        if (!array_key_exists('apps',$_GET)) $_GET['apps']='/';
        $contentFetcher =
            realpath(dirname(__FILE__).'/../..')
            .'/NicerAppWebOS/logic.AJAX/ajax_get_content.php';
        //var_dump ($contentFetcher); echo PHP_EOL;
        $r = require_return ($contentFetcher, false);
        //var_dump ($_GET); var_dump ($r); exit();
        $r = json_decode ($r, true);
        //echo '<pre>'; var_dump ($r);echo '<br/><br/>'; var_dump(json_last_error_msg()); exit();
        return $r;
    }
    
    public function getSiteMenu() {
        $contentFile = dirname(__FILE__).'/domainConfigs/'.$this->domain.'/mainmenu.php';
        //var_dump ($contentFile); exit();
        $content = require_return ($contentFile, false);
        //var_dump ($content); echo '-.0.-'; exit();
        return $content;
    }
    
    public function getMetaTags_viewport() {
    
        //return '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">';    
    
    
        // the 'safe option' for nicerapp plus android5 / iPad6 / iPhone6 / iPhone6-plus (and beyond perhaps)
        $r = '';
        // potential alternatives : 
        // 1a - shows potential coz it might be used to allow a user to zoom into a nicerapp page on a smartphone:
            // $r = '<meta name=viewport content="width=device-width, initial-scale=1, user-scalable=yes">';
        // 1b - perhaps a good industry standard : 
            // $r = '<meta name="viewport" content="width=device-width">';

        // for android 5 and iPad6 and iPhone6 and iPhone6-plus and beyond
        //var_dump ($_SERVER['HTTP_USER_AGENT']); exit();
        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
                if (
                    strpos($_SERVER['HTTP_USER_AGENT'], 'Android')!==false 
                ) {
                    $r = '<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, user-scalable=no">';
                    
                } else if (
                    strpos($_SERVER['HTTP_USER_AGENT'], 'iPad3C1')!==false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad3C2')!==false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad4C1')!==false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad4C2')!==false
                ) { // iPads without retina display
                    $r = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">';
                
                } else if (
                    strpos($_SERVER['HTTP_USER_AGENT'], 'iPad3C3')!==false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad3C3')!==false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad4C4')!==false
                    || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad4C5')!==false
                
                ) { // iPads with retina displays
                    $r = '<meta name="viewport" content="width=device-width, initial-scale=2, maximum-scale=2, user-scalable=yes">';
                
                } else if (
                    strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone OS 8_')!==false // iPhone 6 + iPad (May 2015)
                ) {
                    $r = '<meta name="viewport" content="width=device-width, initial-scale=1.2, maximum-scale=1.05, user-scalable=yes">';
                    
                } else if (
                    $_SERVER['HTTP_USER_AGENT']=='Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1' // iPhone 7 and iPhone 7 Plus
                ) {
                    $r = '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">';
                } else if (
                    $_SERVER['HTTP_USER_AGENT'] == 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1' // iPhone 8 Plus
                ) {
                    $r = '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">';
                } else if (
                    $_SERVER['HTTP_USER_AGENT']=='Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1' // iPhone X and iPhoneX Plus
                ) {
                    $r = '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">';                
                }
        }  

        return $r;
    }
    
    // helper functions
    public function currentDateTimeStamp() { // it's considered unwise to be using this function at all
        return date('Ymd_His');
    }
    
    public function fileDateTimeStamp($filepath) { // use this function instead
        //return $filepath;
        return date('Ymd_His', filemtime($filepath));
    }

    
    public function html($relativeIndentLevel, $html) {
        $indent = '';
        for ($i=0; $i < $this->baseIndentLevel + $relativeIndentLevel; $i++) $indent .= "\t";
        return $indent.$html.PHP_EOL;
    }
    
    public function html_vividButton (
        $relativeIndentLevel, $containerStyle, 
        
        $id, 
        $class, $subClassSuffix, $iconComponents_subClassSuffix, 
        $buttonStyle, 
        $button_event_onclick, 
        $button_event_onmouseover,
        $button_event_onmouseout,
        
        $buttonTabIndex, $buttonTitleAlt, 
        
        $borderImgSrc, 
        $tileImgSrc, 
        $buttonBGimgSrc, 
        $buttonImgSrc, 
        
        $buttonOverlayHTML,
        
        $buttonText, 
        $buttonText_class, 
        $buttonText_style
    ) {
        $il = $relativeIndentLevel;
        if ($buttonTitleAlt!== $buttonText) $buttonTitleAlt2 = $buttonTitleAlt; else $buttonTitleAlt2 = '';
        $r  = $this->html($il, '<div id="'.$id.'_container" class="'.str_replace('vividButton_icon','vividButton_container',$class).'" tabindex="'.$buttonTabIndex.'" style="display:flex;'.$containerStyle.'" onclick="'.$button_event_onclick.'" onmouseover="'.$button_event_onmouseover.'" onmouseout="'.$button_event_onmouseout.'" title="'.$buttonTitleAlt2.'" alt="'.$buttonTitleAlt.'">');
        $r .= $this->html($il+1, '<div id="'.$id.'" class="'.$class.' tooltip" title="'.$buttonTitleAlt2.'" tabindex="'.$buttonTabIndex.'" style="'.$buttonStyle.'">');
        $r .= $this->html($il+2,    '<div class="vividButton_icon_borderCSS'.$subClassSuffix.' '.$iconComponents_subClassSuffix.'"></div>');
        if (!is_null($borderImgSrc)) $r .= $this->html($il+2,    '<img class="vividButton_icon_imgBorder'.$subClassSuffix.' '.$iconComponents_subClassSuffix.'" srcPreload="/NicerAppWebOS/siteMedia/'.$borderImgSrc.'"/>');
        if (!is_null($tileImgSrc)) $r .= $this->html($il+2,    '<img class="vividButton_icon_imgTile'.$subClassSuffix.' '.$iconComponents_subClassSuffix.'" srcPreload="/NicerAppWebOS/siteMedia/'.$tileImgSrc.'"/>');
        if (!is_null($buttonBGimgSrc)) $r .= $this->html($il+2,    '<img class="vividButton_icon_imgButtonIconBG'.$subClassSuffix.' '.$iconComponents_subClassSuffix.'" srcPreload="/NicerAppWebOS/siteMedia/'.$buttonBGimgSrc.'"/>');
        if (!is_null($buttonImgSrc)) $r .= $this->html($il+2,    '<img class="vividButton_icon_imgButtonIcon'.$subClassSuffix.' '.$iconComponents_subClassSuffix.'" srcPreload="/NicerAppWebOS/siteMedia/'.$buttonImgSrc.'"/>');
        if (!is_null($buttonOverlayHTML)) $r .= $this->html($il+2,    $buttonOverlayHTML);
        $r .= $this->html($il, '</div>');
        if (is_string($buttonText) && $buttonText!=='') {
            $textPartSuffix = '_text';
            $r .= $this->html($il+1, '<div id="'.$id.$textPartSuffix.'" class="vividButton_icon'.$subClassSuffix.'_text '.$buttonText_class.'" style="'.$buttonText_style.'" tabindex="'.$buttonTabIndex.'" title="'.$buttonTitleAlt2.'" alt="'.$buttonTitleAlt.'">');
            $r .= $this->html($il+2,    '<div>'.$buttonText.'</div>');
            $r .= $this->html($il+1, '</div>');
        }
        $r .= $this->html($il, '</div>');
        return $r;
    }

    public function html_vividTabPage (
        $relativeIndentLevel, $containerStyle,

        $id,
        $container_class, $container_style, $container_title, $container_alt,
        $container_event_onclick, $container_event_onmouseover, $container_event_onmouseout,

        $tabPages_title, $tabPages_title_style,
        $header_class, $header_style, $header_title, $header_alt,
        $header_event_onclick, $header_event_onmouseover, $header_event_onmouseout,
        $header_buttons,

        $content_class, $content_style, $content_title, $content_alt,
        $content_event_onclick, $content_event_onmouseover, $content_event_onmouseout,
        $tabPages_content
    ) {
        $il = $relativeIndentLevel;
        $r = $this->html ($il,
            '<div id="'.$id.'" class="vividTabPage '.$container_class.'" style="display:flex;'.$container_style.'" '
            .'onclick="'.$container_event_onclick.'" onmouseover="'.$container_event_onmouseover.'" onmouseout="'.$container_event_onmouseout.'" '
            .'title="'.$container_title.'" alt="'.$container_alt.'">'
        );
            $r .= $this->html ($il+1,
                '<div id="'.$id.'_header" class="vividTabPage_header '.$header_class.'" style="'.$header_style.'" '
                .'onclick="'.$header_event_onclick.'" onmouseover="'.$header_event_onmouseover.'" onmouseout="'.$header_event_onmouseout.'" '
                .'title="'.$header_title.'" alt="'.$header_alt.'">'
            );
                $r .= $this->html ($il+2, '<div style="order:-1;'.$tabPages_title_style.'">'.$tabPages_title.'</div>');
                $r .= $this->html ($il+2, $header_buttons);
            $r .= $this->html ($il+1, '</div>');
            $r .= $this->html ($il+1,
                '<div id="'.$id.'_content" class="vividTabPage_content vividScrollpane '.$content_class.'" style="'.$content_style.'" '
                .'onclick="'.$content_event_onclick.'" onmouseover="'.$content_event_onmouseover.'" onmouseout="'.$content_event_onmouseout.'" '
                .'title="'.$content_title,'" alt="'.$content_alt.'">'
            );
                $r .= $this->html ($il+2, $content);
            $r .= $this->html ($il+1, '</div>');
        $r .= $this->html ($il, '</div>');
        return $r;
    }
    
    
    
    public function getPageCSS($js=true) {
        global $naDebugAll;
        global $naLAN;
        $debug = false;
        
        $viewFolder = '[UNKNOWN VIEW]';



        if (is_array($this->view)) {
            foreach ($this->view as $viewFolder => $viewSettings) break;
            $url = '/view/'.base64_encode_url(json_encode($this->view));
        } /*else if (array_key_exists('REQUEST_URI',$_SERVER)) {
            // use defaults if not in proper format (when URL uses HTTP URL parameters for instance)..
            $viewName = '[front page]';
            $url = '/';
            
            // check if SEO url exists in proper format
            $uri = $_SERVER['REQUEST_URI'];
            if ($uri!=='' && strpos('?', $uri)===false) {
                $viewName = '[app page]';
                $url = $uri;
            }
        } */else {
            $viewFolder = '[front page]';
            $url = '/';
        }
        //if ($debug) { echo '<pre>'; var_dump ($url); echo PHP_EOL; var_dump ($this->view); echo '</pre>'.PHP_EOL; }
        $selectors = array (
            0 => array (
                'permissions' => array (
                    'read' => array(
                        'role' => 'guests'
                    ),
                    'write' => array(
                        'role' => 'guests'
                    )
                ),
                'specificityName' => 'site',
                'role' => 'guests',
                'display' => true,
                'worksWithoutDatabase' => true
            ),
            
            1 => array (
                'permissions' => array (
                    'read' => array(
                        'role' => 'guests'
                    ),
                    'write' => array(
                        'role' => 'guests'
                    )
                ),
                'view' => $viewFolder,
                'url' => $url,
                'role' => 'guests',
                'display' => true
            ),
            
            2 => array (
                'permissions' => array (
                    'read' => array(
                        'role' => 'guests'
                    ),
                    'write' => array(
                        'role' => 'guests'
                    )
                ),
                'url' => $url,
                'role' => 'guests',
                'display' => true
            )
        );
        $selectorNames = array ( 
            0 => 'site',
            1 => 'app \''.$viewFolder.'\'',
            2 => 'page'
        );
        $preferredSelectorName = 'site';
        
        //echo '<pre>';var_dump ($_SESSION); var_dump ($_COOKIE); echo '</pre>';
        if (
            false
            || (
                !isset($_COOKIE)
                || !is_array($_COOKIE)
                || !array_key_exists('cdb_loginName',$_COOKIE)
                || $_COOKIE['cdb_loginName']===''
                //|| !$_SESSION['cdb_userIsAdministrator']
            )
        ) {
            $selectors[0]['display'] = false;
            $selectors[1]['display'] = false;
            $selectors[2]['display'] = false;
        };
        //echo '<pre>'; var_dump ($selectors); 
        
        if (
            false
            || (
                is_object($this->dbs)
                && is_string($this->dbs->findConnection('couchdb')->username)
                && $this->dbs->findConnection('couchdb')->username!==''
                && $this->dbs->findConnection('couchdb')->username!==$this->domainForDB.'___Guest'
            )
        ) {
            $selectors[] = array (
                'permissions' => array (
                    'read' => array(
                        'user' => $_COOKIE['cdb_loginName']
                    ),
                    'write' => array(
                        'user' => $_COOKIE['cdb_loginName']
                    )
                ),
                'specificityName' => 'site',
                'user' => $_COOKIE['cdb_loginName'],
                'display' => true
            );
            $selectorNames[] = 'site for user '.$_COOKIE['cdb_loginName'];
            //$preferredSelectorName = 'site user '.$_COOKIE['cdb_loginName'];
            
            $selectors[] = array (
                'permissions' => array (
                    'read' => array(
                        'user' => $_COOKIE['cdb_loginName']
                    ),
                    'write' => array(
                        'user' => $_COOKIE['cdb_loginName']
                    )
                ),
                'view' => $viewFolder,
                'url' => $url,
                'user' => $_COOKIE['cdb_loginName'],
                'display' => true
            );
            $selectorNames[] = 'app \''.$viewFolder.'\' for user '.$_COOKIE['cdb_loginName'];
            
            
            $selectors[] = array (
                'permissions' => array (
                    'read' => array(
                        'user' => $_COOKIE['cdb_loginName']
                    ),
                    'write' => array(
                        'user' => $_COOKIE['cdb_loginName']
                    )
                ),
                'url' => $url,
                'user' => $_COOKIE['cdb_loginName'],
                'display' => true
            );
            $selectorNames[] = 'current page for user '.$_COOKIE['cdb_loginName'];
            //$preferredSelectorName = 'current page for user '.$_COOKIE['cdb_loginName'];
        };
        

        //if (session_status() === PHP_SESSION_NONE) {
            //ini_set('session.gc_maxlifetime', 3600);
            //session_start();
        //};
        $_SESSION['selectors'] = json_encode($selectors);
        $_SESSION['selectorNames'] = json_encode($selectorNames);
        //echo '<pre>'; var_dump ($_SESSION);
        
        $selectors2 = array_reverse($selectors, true);
        $selectorNames2 = array_reverse($selectorNames, true);

        $ret = '';
        $hasJS = false;
        $hasCSS = false;
        //if ($debug) 
        //echo '<pre>';var_dump ($selectors); exit();
        
        foreach ($selectors2 as $idx => $selector) {
            if ($debug) { echo $idx.'<br/>'.PHP_EOL; };
            $css = $this->getPageCSS_specific($selector);
            //if (is_array($css)) $css = json_encode($css, JSON_PRETTY_PRINT);
            if ($debug) { echo '<pre>$selector='; var_dump($selector); var_dump($css); };
            if (is_string($css) && $debug) {
                echo '$idx = '; var_dump ($idx); echo PHP_EOL.PHP_EOL;
                echo '$css = '; var_dump ($css); echo PHP_EOL.PHP_EOL;
                echo '$hasJS = '; var_dump ($hasJS); echo PHP_EOL.PHP_EOL;
                echo '$hasCSS = '; var_dump ($hasCSS); echo PHP_EOL.PHP_EOL;
                echo '$selectorL1 = '; var_dump ($selector); echo PHP_EOL.PHP_EOL;
                exit();
            };
            $_SESSION['selectorName'] = $selectorNames[$idx];
            $_SESSION['preferredSelectorName'] = $preferredSelectorName;
            if ($debug) { echo '$selector=';var_dump($selector); echo '<br/>$_SESSION='; var_dump ($_SESSION); echo PHP_EOL.PHP_EOL; }
            if (
                !$hasJS
                && $js === true
                && is_array($css)
                && array_key_exists('display',$selector) 
                && $selector['display']!==false
            ) {
                $hasJS = true;
                $r = '<script id="jsPageSpecific" type="text/javascript">'.PHP_EOL;
                $r .= '// debug1'.PHP_EOL;
                $useVividTexts = !array_key_exists('uvt',$_GET) || $_GET['uvt']=='y' ? 'true' : 'false';
                $dbg = [
                    'na.site.loadContent' => array_key_exists('lc',$_GET) && $_GET['lc']=='y' ? 'true' : 'false'
                ];

                //echo '<pre style="color:green">'; var_dump ($css); echo '</pre>'; die();

                foreach ($css as $themeName => $theme) { break; };
                $r .= 'na.site.globals = $.extend(na.site.globals, {'.PHP_EOL;
                    $r .= "\tdebug : ".json_encode($dbg).",".PHP_EOL;
                    $r .= "\tuseVividTexts : ".$useVividTexts.",".PHP_EOL;
                    $r .= "\tbackground : '".$theme['background']."',".PHP_EOL;
                    $r .= "\tbackgroundSearchKey : '".$theme['backgroundSearchKey']."',".PHP_EOL;
                    $r .= "\tthemes : ".json_encode($css).",".PHP_EOL;
                    $r .= "\tthemeName : '".$themeName."',".PHP_EOL;
                    $r .= "\tthemeSpecificityName : \"".$selectorNames[$idx]."\",".PHP_EOL;
                    $r .= "\tthemeSpecificityNames : ".json_encode($selectorNames).",".PHP_EOL;
                    $r .= "\tthemesDBkeys : ".json_encode($selectors).",".PHP_EOL;
                    $r .= "\tnaLAN : ".($naLAN ? 'true' : 'false').','.PHP_EOL;
                    $r .= "\tnaHasErrors : ".((array_key_exists('naErrors',$_SESSION) && is_string ($_SESSION['naErrors']) && $_SESSION['naErrors']!=='') ? 'true' : 'false').','.PHP_EOL;
                    $r .= "\thasDB : ".($this->hasDB ? 'true' : 'false').PHP_EOL;
                $r .= '});'.PHP_EOL;
                if (
                    strpos($_SERVER['SCRIPT_NAME'], '/index.php')!==false
                    || strpos($_SERVER['SCRIPT_NAME'], '/ajax_get_content.php')!==false
                ) {
                    $r .= 'na.site.globals = $.extend(na.site.globals, {'.PHP_EOL;
                        $r .= "\tapp : ".json_encode($this->view).','.PHP_EOL;
                        if (array_key_exists('apps',$_GET)) $r .= "\tapps : ".json_encode($_GET['apps']).PHP_EOL;
                    $r .= '});'.PHP_EOL;
                    $r .= 'if (!na.site.settings.current.url) na.site.settings.current = $.extend(na.site.settings.current, {'.PHP_EOL;
                        $r .= "\turl : ".json_encode($this->url).PHP_EOL;
                    $r .= '});'.PHP_EOL;
                };
                $r .= '$(document).ready(function() {'.PHP_EOL;
                    $r .= "\t//setTimeout(function() {".PHP_EOL;
                    $r .= "\t\tna.site.setSpecificity();".PHP_EOL;
                    $r .= "\t//}, 10);".PHP_EOL;
                $r .= "});".PHP_EOL;
                $r .= '</script>'.PHP_EOL;
                $ret = $r.$ret;
            };

            if (is_array($css) && !$hasCSS) {                
                $hasCSS = true;
                foreach ($css as $themeName => $theme) { break; };
                //$r = '<script type="text/javascript">'.PHP_EOL;
                //$r .= "\tna.site.globals = $.extend(na.site.globals, {".PHP_EOL;
                //$r .= "\t\tthemeName : '".$css['theme']."'".PHP_EOL;
                //$r .= "\t});".PHP_EOL;
                //$r .= '</script>'.PHP_EOL;
                $r = '<style id="cssPageSpecific" type="text/css" csn="'.$selectorNames[$idx].'">'.PHP_EOL;
                //echo '<pre style="color:green">'; var_dump ($theme['dialogs']); echo '</pre>'; die();
                $r .= css_array_to_css($theme['dialogs']).PHP_EOL;
                $r .= '#divFor_saCompanyLogo, #headerSiteDiv, li span, .backdropped, p, h1:not(#pageTitle), h2:not(#tagline1), h3 {'."\r\n".PHP_EOL;
                    $r .= "\t".'background : rgba(0,0,0,'.$theme['textBackgroundOpacity'].');'."\r\n".PHP_EOL;
                    $r .= "\t".'border-radius : 10px !important;'."\r\n".PHP_EOL;
                $r .= '}'."\r\n".PHP_EOL;

                $theme['animations'] = css_keyframes_to_array(
                    file_get_contents(dirname(__FILE__).'/../themes/nicerapp_default_animations__'.$themeName.'.css')
                );
                //echo '<pre class="css_keyframes_to_array">'; var_dump ($css['animations']); echo '</pre>';//die();

                $a1 = css_animation_template_to_animation (
                    $themeName, $theme['animations'],
                    [
                        'naHS_l0_in', 'naHS_l1_in', 'naHS_l2_in', 'naHS_json_in',
                        'naHS_releaseDate_l0_in', 'naHS_releaseDate_l1_in', 'naHS_releaseDate_l2_in'
                    ],
                    [ '0%' => [
                        'background' => [
                            [
                                'search' => '/rgba\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3}),\s*([\d\.])+\)/',
                                'replace' => 'rgba($1, $2, $3, '.$theme['textBackgroundOpacity'].')'
                            ],
                            [
                                'search' => '/rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)/',
                                'replace' => 'rgba($1, $2, $3, '.$theme['textBackgroundOpacity'].')'
                            ]
                        ]
                    ]]
                );
                //echo '<pre style="background:darkred; color:black;">'; var_dump ($a1); echo '</pre>'; die();
                $a2 = css_animation_template_to_animation (
                    $themeName, $theme['animations'],
                    [
                        'naHS_l0_out', 'naHS_l1_out', 'naHS_l2_out', 'naHS_json_out',
                        'naHS_releaseDate_l0_out', 'naHS_releaseDate_l1_out', 'naHS_releaseDate_l2_out'
                    ],
                    [ '100%' => [
                        'background' => [
                            [
                                'search' => '/rgba\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3}),\s*([\d\.])+\)/',
                                'replace' => 'rgba($1, $2, $3, '.$theme['textBackgroundOpacity'].')'
                            ],
                            [
                                'search' => '/rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)/',
                                'replace' => 'rgba($1, $2, $3, '.$theme['textBackgroundOpacity'].')'
                            ]
                        ]
                    ]
                ]);

                $r .= css_animation_array_to_css (array_merge($a1,$a2));
                //echo '<pre style="background:darkred; color:white;">'; var_dump (htmlentities($r)); echo '</pre>'; die();

                $r .= css_animation_keys_to_css (
                    $themeName,
                    [
                        'li.todoList > div.active' => 'naHS_l0_in',
                            // the above key-value pair with a $css['theme']=='default', results in the following CSS rule :
                            /*
                             * li.todoList > div.active {
                             *      animation : naHS_l0_in__default 1s forwards;
                             * }
                             */

                        'li.todoList > div' => 'naHS_l0_out',
                        '.todoList_l1 > li > div.active' => 'naHS_l1_in',
                        '.todoList_l1 > li > div' => 'naHS_l1_out',
                        '.todoList_l2 > li > div.active' => 'naHS_l2_in',
                        '.todoList_l2 > li > div' => 'naHS_l2_out',

                        '.todoList_l1 > li > pre.json.active' => 'naHS_l1_in',
                        '.todoList_l1 > li > pre.json' => 'naHS_l1_out',

                        '.todoList_l2 > li > pre.json.active' => 'naHS_l2_in',
                        '.todoList_l2 > li > pre.json' => 'naHS_l2_out',

                        'li.todoList.releaseDate > div.active' => 'naHS_releaseDate_l0_in',
                        'li.todoList.releaseDate > div' => 'naHS_releaseDate_l0_out',
                        '.todoList_l1.releaseDate > li > div.active' => 'naHS_releaseDate_l1_in',
                        '.todoList_l1.releaseDate > li > div' => 'naHS_releaseDate_l1_out',
                        '.todoList_l2.releaseDate > li > div.active' => 'naHS_releaseDate_l2_in',
                        '.todoList_l2.releaseDate > li > div' => 'naHS_releaseDate_l2_out'

                    ]
                );

                $r .= '</style>'.PHP_EOL;
                $ret .= $r;
            }
        };

        //exit();
        if (!$hasJS && $js===true) {
                $hasJS = true;
                foreach ($selectors2 as $idx => $selector) {
                    if ($selectorNames[$idx] !== $preferredSelectorName) continue;
                    $r = '<script id="jsPageSpecific" type="text/javascript">'.PHP_EOL;
                    $r .= '// debug4'.PHP_EOL;
                    $useVividTexts = !array_key_exists('uvt',$_GET) || $_GET['uvt']=='y' ? 'true' : 'false';
                    $dbg = [
                        'na.site.loadContent' => !array_key_exists('lc',$_GET) || $_GET['lc']=='y' ? 'true' : 'false'
                    ];
                    foreach ($css as $themeName => $theme) { break; };
                    $r .= 'na.site.globals = $.extend(na.site.globals, {'.PHP_EOL;
                        $r .= "\tdebug : ".json_encode($dbg).",".PHP_EOL;
                        $r .= "\tuseVividTexts : ".$useVividTexts.",".PHP_EOL;
                        $r .= "\tbackground : '".$theme['background']."',".PHP_EOL;
                        $r .= "\tbackgroundSearchKey : '".$theme['backgroundSearchKey']."',".PHP_EOL;
                        $r .= "\tthemes : ".json_encode($css).",".PHP_EOL;
                        $r .= "\tthemeName : '".$themeName."',".PHP_EOL;
                        $r .= "\tthemeSpecificityName : \"".$selectorNames[$idx]."\",".PHP_EOL;
                        $r .= "\tthemeSpecificityNames : ".json_encode($selectorNames).",".PHP_EOL;
                        $r .= "\tthemesDBkeys : ".json_encode($selectors).",".PHP_EOL;
                        $r .= "\tnaLAN : ".($naLAN ? 'true' : 'false').','.PHP_EOL;
                        $r .= "\tnaHasErrors : ".((array_key_exists('naErrors',$_SESSION) && is_string ($_SESSION['naErrors']) && $_SESSION['naErrors']!=='') ? 'true' : 'false').','.PHP_EOL;
                        $r .= "\thasDB : ".($this->hasDB ? 'true' : 'false').PHP_EOL;
                    $r .= '});'.PHP_EOL;
                    //var_dump (strpos($_SERVER['SCRIPT_NAME'], '/index.php')); var_dump (strpos($_SERVER['SCRIPT_NAME'], '/ajax_get_content.php')); var_dump ($_SERVER); 
                    //var_dump ($_GET); exit();
                    if (
                        strpos($_SERVER['SCRIPT_NAME'], '/index.php')!==false
                        || strpos($_SERVER['SCRIPT_NAME'], '/ajax_get_content.php')!==false
                    ) {
                        $r .= 'na.site.globals = $.extend(na.site.globals, {'.PHP_EOL;
                            $r .= "\tapp : ".json_encode($this->view).','.PHP_EOL;
                        $r .= '});'.PHP_EOL;
                        $r .= 'if (!na.site.settings.current.url) na.site.settings.current = $.extend(na.site.settings.current, {'.PHP_EOL;
                            $r .= "\turl : ".json_encode($this->url).PHP_EOL;
                        $r .= '});'.PHP_EOL;
                    };
                    $r .= '$(document).ready(function() {'.PHP_EOL;
                        $r .= "\t//setTimeout(function() {".PHP_EOL;
                        $r .= "\t\tna.site.setSpecificity();".PHP_EOL;
                        $r .= "\t//}, 10);".PHP_EOL;
                    $r .= "});".PHP_EOL;
                    $r .= '</script>'.PHP_EOL;
                    $ret = $r.$ret;
                }
        };
        if ($debug) { echo '$ret='; var_dump(htmlentities($ret)); echo '</pre>'.PHP_EOL.PHP_EOL; exit(); };
        return $ret;
        
    }
    
    public function getPageCSS_specific($selector) {
        $debug = false;
        $cdbFunctional1a = true;
        $fncn = $this->cn.'::getPageCSS_specific()';
        //$fncn = $this->cn.'::getPageCSS_specific("'.json_encode($selector).'")';

        //if ($debug) 
        //{ echo '$selector='; var_dump ($selector); echo '<br/><br/>'.PHP_EOL.PHP_EOL; exit(); };
        
        $permissions = $selector['permissions'];
        if ($debug && false) { 
            echo '$permissions='; var_dump ($permissions); echo '<br/><br/>'.PHP_EOL.PHP_EOL;
            unset ($selector['permissions']);
            unset ($selector['display']);
            exit();
        }
        if ($debug) {
            echo '<pre>$selector='; var_dump ($selector); echo '</pre><br/>'.PHP_EOL.PHP_EOL;
        }


        /*
        if (array_key_exists('worksWithoutDatabase',$selector) && $selector['worksWithoutDatabase']===true) {
                $rec = [
                    'default' => [
                        '_id' => cdb_randomString(20),
                        'role' => 'guests',
                        'theme' => 'default',
                        'specificityName' => 'site',
                        'textBackgroundOpacity' => 0.4,
                        'background' => '/NicerAppWebOS/siteMedia/backgrounds/tiled/grey/abstract_ice.jpg',
                        'backgroundSearchKey' => 'landscape',
                        'dialogs' => css_to_array (file_get_contents(
                            realpath(dirname(__FILE__).'/../..')
                            .'/NicerAppWebOS/themes/nicerapp_default.css'
                        ))
                    ]
                ];
                return $rec;
        */
        //} else {
            if ($cdbFunctional1a) {
                // check permissions
                $hasPermission = false;
                foreach ($permissions as $permissionType => $accounts) {
                    if ($permissionType=='read') {
                        foreach ($accounts as $accountType => $userOrGroupID) {
                            $adjustedUserOrGroupID = str_replace (' ', '__', $userOrGroupID);
                            $adjustedUserOrGroupID = str_replace ('.', '_', $adjustedUserOrGroupID);
                            if ($debug) { echo 't666='; var_dump($accountType); var_dump ($this->dbs->username); echo PHP_EOL; var_dump ($userOrGroupID); echo PHP_EOL; var_dump ($adjustedUserOrGroupID); }
                            if ($accountType == 'role') {
                                if ($debug) { echo '$this->dbs->roles='; var_dump($this->db->roles); };
                                if (is_string($this->dbs)) {
                                    echo $fncn.' : WARNING : invalid database connection ($this->dbs="'.json_encode($this->dbs).'")- this database server, or even the entire webserver, has been hacked by hostiles.';
                                    die(); // or exit();
                                }
                                foreach ( $this->dbs->findConnection('couchdb')->roles
                                    as $roleIdx => $groupID
                                ) {
                                    if ($debug) { echo 't667='; var_dump($groupID); };
                                    if ($userOrGroupID==$groupID) {
                                        $hasPermission = true;
                                    }
                                }
                            }
                            if ($accountType == 'user' && $this->dbs->findConnection('couchdb')->username == $adjustedUserOrGroupID) {
                                $hasPermission = true;
                                if ($debug) { echo 't777 $username='.$this->username.PHP_EOL; }
                            }
                        }
                    }
                }
            } else {
                return false;
                //$hasPermission = true;
                //if ($debug) { echo  '<h1 style="color:green;font-size:bold;">$hasPermission = true, because $cdbFunctional1a = false.</h1>'.PHP_EOL; }
            }

            if (!$hasPermission) {
                $msg = 'class.naContentManagementSystem.php::getPageCSS_specific() : !$hasPermission for username='.$this->dbs->findConnection('couchdb')->username.' - aborting';
                //if ($debug) trigger_error ($msg, E_USER_NOTICE);
                if ($debug) echo $msg.'<br/>'.PHP_EOL;

                if ($debug) echo '</pre>';
                return false;
            }

            // try to fetch the requested cosmetics data
            $dbName = $this->dbs->findConnection('couchdb')->dataSetName('data_themes');
            try {
                $this->dbs->findConnection('couchdb')->cdb->setDatabase($dbName, false);
            } catch (Exception $e) {
                if ($debug) { echo 'status : Failed : could not open database '.$dbName.'<br/>'.PHP_EOL; exit(); }
            }

            $sel = [];
            if (array_key_exists('user', $selector)) $sel['user'] = $selector['user'];
            if (array_key_exists('role', $selector)) $sel['role'] = $selector['role'];
            if (array_key_exists('view', $selector)) $sel['view'] = $selector['view'];
            if (array_key_exists('url', $selector)) $sel['url'] = $selector['url'];
            if (array_key_exists('specificityName', $selector)) $sel['specificityName'] = $selector['specificityName'];
            global $naIP;
            $selector['ip'] = $naIP;
            $selector['ua'] = $_SERVER['HTTP_USER_AGENT'];
            $selector['lastUsed'] = [
                '&gt' => 0
            ];
            if ($debug) { echo '<pre>'; var_dump ($sel); };

            $findCommand = array (
                'selector' => $sel,//array( 'url'=>$selector['url'], 'role'=>$selector['role'] ),//$selector,
                'fields' => array( '_id', 'user', 'view', 'role', 'lastUsed', 'theme', 'url', 'dialogs', 'background', 'backgroundSearchKey', 'textBackgroundOpacity' ),
                'sort' => [['lastUsed'=>'asc']]
            );
            try {
                $call = $this->dbs->findConnection('couchdb')->cdb->find ($findCommand);
            } catch (Exception $e) {
                $msg = 'while trying to find in \''.$dbName.'\' : '.$e->getMessage();
                echo $msg;
                //exit();
            }
            if ($debug)     {
                echo '<pre>info : $findCommand2='; var_dump ($findCommand); echo '.<br/>'.PHP_EOL;
                echo 'info : $call='; var_dump ($call); echo '.</pre>'.PHP_EOL;
                exit();
            }

            $hasRecord = false;
            $rets = [];
            if ($call->headers->_HTTP->status==='200') {
                foreach ($call->body->docs as $idx => $d) {
                    $hasRecord = true;
                    if ($debug) { echo '$d='; var_dump ($d); }
                    $ret = [
                        ( isset($d->theme) ? $d->theme : '[default]' ) => [
                            'dialogs' => json_decode(json_encode($d->dialogs), true),
                            'background' => ( isset($d->background) ? $d->background : '' ),
                            'backgroundSearchKey' => ( isset($d->backgroundSearchKey) ? $d->backgroundSearchKey : '' ),
                            'textBackgroundOpacity' => ( isset($d->textBackgroundOpacity) ? $d->textBackgroundOpacity : ''),
                            'theme' => ( isset($d->theme) ? $d->theme : '[default]' )
                        ]
                    ];
                    if (isset($d->user)) $ret[( isset($d->theme) ? $d->theme : '[default]' )]['user'] = json_decode(json_encode($d->user),true);
                    if (isset($d->role)) $ret[( isset($d->theme) ? $d->theme : '[default]' )]['role'] = json_decode(json_encode($d->role),true);
                    if (isset($d->url)) $ret[( isset($d->theme) ? $d->theme : '[default]' )]['url'] = json_decode(json_encode($d->url),true);
                    if (isset($d->view)) $ret[( isset($d->theme) ? $d->theme : '[default]' )]['view'] = json_decode(json_encode($d->view),true);
                    if (isset($d->specificityName)) $ret[( isset($d->theme) ? $d->theme : '[default]' )]['specificityName'] = json_decode(json_encode($d->specificityName),true);

                    if ($debug) echo '</pre>';

                    $rets = array_merge ($rets, $ret);
                    //return json_decode(json_encode($ret),true);
                }
                if (count($rets)>0) {
                    if ($debug) {
                        echo '<pre>info : $findCommand2='; var_dump ($findCommand); echo '.<br/>'.PHP_EOL;
                        echo 'info : $rets='; var_dump ($rets); echo '.</pre>'.PHP_EOL;
                        exit();
                    }
                    return $rets;
                }
            }
            if ($debug) echo '</pre>';
        //}
        return false;        
    }

}
?>
