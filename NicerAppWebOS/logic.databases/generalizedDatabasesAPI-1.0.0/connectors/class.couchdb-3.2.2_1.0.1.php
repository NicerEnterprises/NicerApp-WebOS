<?php
require_once (realpath(dirname(__FILE__).'/../../../..').'/NicerAppWebOS/boot.php');
require_once (realpath(dirname(__FILE__).'/../../../..').'/NicerAppWebOS/functions.php');
require_once (realpath(dirname(__FILE__).'/../../../..').'/NicerAppWebOS/3rd-party/sag/src/Sag.php');
require_once (realpath(dirname(__FILE__).'/../../../..').'/NicerAppWebOS/Sag-support-functions.php');

class class_NicerAppWebOS_database_API_couchdb_3_2 {
    public $cn = 'class_NicerAppWebOS_database_API_couchdb_3_2';
    public $connectionType = 'couchdb';
    public $debug = false;
    public $ip;
    public $security_admin = '{ "admins": { "names": [], "roles": ["administrators"] }, "members": { "names": [], "roles": ["administrators","guests"] } }';
    public $security_guest = '{ "admins": { "names": [], "roles": ["guests"] }, "members": { "names": [], "roles": ["guests"] } }';
    public $naWebOS;
    public $cdb;
    public $cdb_slr;
    
    public $username=null;
    public $roles=null;

    public function __construct ($naWebOS, $username = 'Guest', $cRec = null) {
        global $dbConfigFile_couchdb;

        if (is_null($naWebOS)) $this->throwError('__construct($naWebOS) : invalid $naWebOS', E_USER_ERROR);
        $this->cms = $naWebOS;
        
        $this->connectionSettings = $cRec;

        $admin = $username=='admin';

        $this->cdb = new Sag($cRec['host'], $cRec['port']);
        $this->cdb->setHTTPAdapter($cRec['httpAdapter']);
        $this->cdb->useSSL($cRec['useSSL']);

    //if (php_sapi_name() === 'cli') return 'php_sapi_name()='.php_sapi_name(); // BAD!
        //echo 't77;'; var_dump ($username);
        $naLoginResult = cdb_login ($this->cdb, $cRec, $username);
    //var_dump ($naLoginResult); die();
        //echo '<pre style="background:blue;color:lime">'; echo '<h1>class.couchdb.3.2.2_1.0.1.php</h1><br/>';var_dump ($_COOKIE); var_dump ($cdb_slr); var_dump ($this->cdb->getSession()); var_dump ($naLoginResult); echo '</pre>'; die();


        // test db connection quality
        if (is_null($this->cdb->getSession()->body->userCtx->name)) {
            trigger_error ('Could not log into couchdb database. Reason : Database cookie expired. Please login again.', E_USER_WARNING);
        }

        $u = $this->cdb->getSession()->body->userCtx;
        $this->username = $u->name;
        $this->roles = $u->roles;


        if ($admin) {
            $this->isAdmin = true;
            $_SESSION['cdb_userIsAdministrator'] = $this->isAdmin;
        } elseif (false) {
            /*---
             * REMEMBERME_BIRKE IS NOT LONGER USED.
             * ONLY $cdb->loginByCookie is used from now on (2021-12), from
             *  #btnLoginLogout
             *      onclick = -->.../NicerAppWebOS/domainConfigs/nicer.app/index.template.php::id="siteLogin"
             *          onclick = -->.../NicerAppWebOS/logic.AJAX/ajax_login.php::#btnLogin
             *              onclick = -->.../NicerAppWebOS/functions.php::
             *              cdb_login($username, $password, SAG::AUTH_COOKIE);
             *
             * on site showing, from .../NicerAppWebOS/boot.php :
             *  call .../NicerAppWebOS/logic.databases/generalizedDatabasesAPI-1.0.0/connectors/class.couchdb-3.2.2-1.0.1.php::class_NicerAppWebOS_database_API_couchdb_3_2:__construct()
             *      for $naWebOS->dbs and $naWebOS->dbsAdmin; ONLY dbs will be using the AUTH_COOKIE set by ajax_login.php, the admin account will be using the plaintext password stored on disk in .../NicerAppWebOS/domainConfigs/databases.*.json
             *
             * ANY ERRORS DURING STARTUP WILL BE REPORTED TO THE END-USER BY MEANS OF COLORIZED POPUP.
/*
            $naLoginResult_birke = useRememberme_birke();
            //echo '<pre>'; var_dump($naLoginResult_birke); exit();
            
            if (is_object($naLoginResult_birke) && property_exists($naLoginResult_birke, 'cookieExists')) {
                $isSuccess = $naLoginResult_birke->cookieExists && $naLoginResult_birke->tripleWasFound;
                $isExpired = $naLoginResult_birke->tripleWasValid;
            
            } else if (is_object($naLoginResult_birke)) {
                $isSuccess = $naLoginResult_birke->isSuccess();
                $isExpired = $naLoginResult_birke->isExpired();
            }
            global $loginResult; 
            if ($isSuccess || is_object($naLoginResult)) { // rememberme library at work (or not) (NOT at the moment, and it's also NOT an easy bug to fix. core layers of PHP being addressed by another programmer (.../NicerAppWebOS/3rd-party/vendor/birke and .../NicerAppWebOS/3rd-party/birke), who is using a coding-style that is vastly different from my own (a geek, while i'm a so called adult CEO + CTO script-kid (he likes complicated math and it's related shit, i like complicated lego puzzles (in text during my adult life) that i design myself).
            
                //echo 'hello world 1b'; exit();
                
                if ($isExpired) {
                    // trust no-one and nothing.
                    // except your loved ones, *when* you can love them.
                    $errMsg =  
                        'WARNING : the login credentials stored in your cookie have expired.<br/>'.PHP_EOL
                        .'you have been logged in as user \''.$naLoginResult['username'].'\'.<br/>'.PHP_EOL
                        .'current expiration time length for that cookie is set to exactly 1 week (measured in seconds since your last valid login).'.PHP_EOL;
                    if (php_sapi_name() !== 'cli') {
                        array_push($_SESSION['naErrors_js']['bootup'], $errMsg);
                    } else {
                        echo $errMsg;
                    }
                    
                    $this->username = $naLoginResult['username'];
                    $this->adjustedUsername = $naLoginResult['username'];
                    $this->adjustedUsername = str_replace(' ', '__', $this->adjustedUsername);
                    $this->adjustedUsername = str_replace('.', '_', $this->adjustedUsername);
                    $this->roles = $naLoginResult['roles'];
                } else {
                    //echo '<pre>'; var_dump ($loginResult); exit();
                    $this->username = $naLoginResult_birke->credential;
                    $this->adjustedUsername = $naLoginResult_birke->credential;
                    $this->adjustedUsername = str_replace(' ', '__', $this->adjustedUsername);
                    $this->adjustedUsername = str_replace('.', '_', $this->adjustedUsername);
                    $this->roles = $this->cdb->getSession()->body->userCtx->roles;
                }
            } else {
                // login cookie expired, no big deal 
                $errMsg =  
                    'ERROR : the login credentials stored in your cookie have expired.<br/>'.PHP_EOL
                    .'you have been logged in as user \''.$naLoginResult['username'].'\'.<br/>'.PHP_EOL
                    .'current expiration time length for that cookie is set to exactly 1 week (measured in seconds since your last valid login).'.PHP_EOL;
                array_push($_SESSION['naErrors_js']['bootup'], $errMsg);
                $this->username = $cRec['username'];
                $this->adjustedUsername = $cRec['username'];
                $this->adjustedUsername = str_replace(' ', '__', $this->adjustedUsername);
                $this->adjustedUsername = str_replace('.', '_', $this->adjustedUsername);
                $this->roles = ['Guests'];
           }
            
            $this->isAdmin = false;
            foreach ($this->roles as $idx => $role) {
                if ($role=='administrators') $this->isAdmin = true;
            }
            $_SESSION['cdb_userIsAdministrator'] = $this->isAdmin;
*/
        }
        return $this;
    }

    
    public function throwError ($msg, $errorLevel) {
        echo '<pre class="nicerapp_error__database">$msg='.$msg.', $errorLevel='.$errorLevel.'</pre>';
        trigger_error ($msg, $errorLevel);
    }
    
    public function dataSetName_domainName ($domainName) {
        $dn = str_replace('.','_',strToLower($domainName));
        if (preg_match('/^\d/', $dn)) {
            $dn = 'number_'.$dn;
        }
        return $dn;
    }

    public function dataSetName ($dbSuffix) {
        global $naWebOS;
        $domainName = $this->dataSetName_domainName($naWebOS->domain);
        $dataSetName = $domainName.'___'.str_replace('.','_',$dbSuffix);
        $dataSetName = strToLower($dataSetName);
        return $dataSetName;
    }

    public function dbName ($dbSuffix) {
        return $this->dataSetName($dbSuffix);
    }
    
    public function createUsers() {
        // create users
        global $naWebOS;
        $uid = 'org.couchdb.user:'.$this->dataSetName_domainName($naWebOS->domain).'___Administrator';
        //var_dump ($uid); die();
        $got = true;
        $this->cdb->setDatabase('_users',false);
        try { $call = $this->cdb->get($uid); } catch (Exception $e) { $got = false; }
        if (!$got) {
            try {
                $rec = array (
                    '_id' => $uid,
                    'name' => $this->dataSetName_domainName($naWebOS->domain).'___Administrator',
                    'password' => (array_key_exists('AdministratorPassword',$_REQUEST) ? $_REQUEST['AdministratorPassword'] : 'Administrator'), 
                    'realname' => 'NicerApp WebOS Administrator',
                    'email' => (array_key_exists('AdministratorEmail',$_REQUEST) ? $_REQUEST['AdministratorEmail'] : 'root@localhost'), 
                    'roles' => [ "guests", "administrators", "editors" ], 
                    'type' => "user"
                );
                $call = $this->cdb->post ($rec);
                if ($call->body->ok) echo 'Created Administrator user record.<br/>'; else echo '<span style="color:red">Could not create Administrator user record.</span><br/>';
            } catch (Exception $e) {
                echo '<pre style="color:red">'; var_dump ($e); echo '</pre>';
            }
        } else {
            echo 'Already have an Administrator user record.<br/>';
        }

        $uid = 'org.couchdb.user:'.$this->dataSetName_domainName($naWebOS->domain).'___Guest';
        $got = true;
        $this->cdb->setDatabase('_users',false);
        try { $call = $this->cdb->get($uid); } catch (Exception $e) { $got = false; }
        if (!$got) {
            try {
                $rec = array (
                    '_id' => $uid, 
                    'name' => $this->dataSetName_domainName($naWebOS->domain).'___Guest',
                    'password' => 'Guest', 
                    'realname' => 'NicerApp WebOS Guest',
                    'email' => 'guest@localhost', 
                    'roles' => [ "guests" ], 
                    'type' => "user"
                );
                $call = $this->cdb->post ($rec);
                if ($call->body->ok) echo 'Created Guest user record.<br/>'; else echo '<span style="color:red">Could not create Guest user record.</span><br/>';
            } catch (Exception $e) {
                echo '<pre style="color:red">'; var_dump ($e); echo '</pre>';
            }
        } else {
            echo 'Already have a Guest user record.<br/>';
        }
        return true;
    }

    public function clearOutDatabases($dbs) {
        $dbsArr=[];
        foreach ($dbs as $dataSetName=>$mustDo) {
            $dbsArr[] = strtolower($dataSetName);
        }

        $allDBs = $this->cdb->getAllDatabases();
        //echo '<pre style="color:green">'; var_dump($dbs); echo '</pre>';
        foreach ($allDBs->body as $idx => $dataSetName) {
            $domainName = $this->dataSetName_domainName($this->cms->domain);
            $dataSetName = strtolower($dataSetName);
            $dbDomainName = preg_replace('/___.*$/','',$dataSetName);
            $strippeddataSetName = preg_replace('/.*___/','',$dataSetName);
            $dbg = array(
                '$dataSetName' => $dataSetName,
                '$domainName' => $domainName,
                'strpos' => strpos($dataSetName,$domainName)
            );
            //echo '<pre>'; var_dump($dbg); echo '</pre>';    
            $toBeDeleted = !in_array($strippeddataSetName, $dbsArr) && array_key_exists($strippeddataSetName,$dbs) && $dbs[$strippeddataSetName];

            $sp = strpos($dataSetName,$domainName);
            if (
                $sp===0
                && $toBeDeleted
            ) {
                $do = true;
                try { 
                    $db = $this->cdb->deleteDatabase($dataSetName); echo '<span style="color:lime;background:blue">Deleted database '.$dataSetName.'</span><br/>'.PHP_EOL;
                } catch (Exception $e) { 
                    if ($this->debug) { echo $e->getMessage(); echo '<br/>'; $do = false; exit(); }
                }
            }/* else {
                echo '<span style="color:yellow;background:navy">NOT deleted database '.$dataSetName.'</span><br/>'.PHP_EOL;
            }*/
        }
        return true;
    }
    
    public function createDataSet_analytics() {
        $dataSetName = $this->dataSetName('analytics');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName,true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit();
        }
        echo 'Created database '.$dataSetName.'<br/>';
    }
    
    public function createDataSet_errorHandling() {
        $dataSetName = $this->dataSetName('errorHandling');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName,true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit();
        }
        echo 'Created database '.$dataSetName.'<br/>';
    }
    
    public function createDataSet_app_2D_webmail__accounts() {
        $dataSetName = $this->dataSetName('app_2D_webmail__accounts');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName,true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit();
        }
        echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_app_3D_fileManager__tree_d_positions() {
        $dataSetName = $this->dataSetName('app_3D_fileManager__three_d_positions');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName,true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit();
        }
        echo 'Created database '.$dataSetName.'<br/>';
    }
    
    public function createDataSet_cms_tree() {
        $dataSetName = $this->dataSetName('cms_tree');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_admin);
        } catch (Exception $e) {
            echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit();
        }
        /*
        $do = false; try { $doc = $this->cdb->get('aaa'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "aaa", "id" : "aaa", "parent" : "#", "text" : "System", "state" : { "opened" : false }, "type" : "naSystemFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };


        $do = false; try { $doc = $this->cdb->get('aab'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "aab", "id" : "aab", "parent" : "aaa", "text" : "Users", "state" : { "opened" : false }, "type" : "naSystemFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('aab_Administrator'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "aab_Administrator", "id" : "aab_Administrator", "parent" : "aab", "text" : "Administrator", "state" : { "opened" : false }, "type" : "naSettings" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('aab_Administrator_vividThemes'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "aab_Administrator_vividThemes", "id" : "aab_Administrator_vividThemes", "parent" : "aab_Administrator", "text" : "vividThemes", "state" : { "opened" : false }, "type" : "naVividThemes" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('aac'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "aac", "id" : "aac", "parent" : "aaa", "text" : "Groups", "state" : { "opened" : false }, "type" : "naSystemFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('aac_Administrators'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "aac_Administrators", "id" : "aac_Administrators", "parent" : "aac", "text" : "Administrators", "state" : { "opened" : false }, "type" : "naSettings" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('aac_Editors'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "aac_Editors", "id" : "aac_Editors", "parent" : "aac", "text" : "Editors", "state" : { "opened" : false}, "type" : "naSettings" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('aac_Guests'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "aac_Guests", "id" : "aac_Guests", "parent" : "aac", "text" : "Guests", "state" : { "opened" : false}, "type" : "naSettings" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('aad'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "aad", "id" : "aad", "parent" : "aaa", "text" : "Site", "state" : { "opened" : false }, "type" : "naSettings" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };
        */

        $do = false; try { $doc = $this->cdb->get('caa'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "caa", "id" : "caa", "parent" : "#", "text" : "Groups", "state" : { "opened" : true }, "type" : "naSystemFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('baa'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "cms_tree", "_id" : "baa", "id" : "baa", "parent" : "#", "text" : "Users", "state" : { "opened" : true }, "type" : "naSystemFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_cms_tree__role__guests() {
        $dataSetName = $this->dataSetName('cms_tree__role__guests');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit();
        }

        $do = false; try { $doc = $this->cdb->get('cab'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "cab", "id" : "cab", "parent" : "caa", "text" : "Guests", "state" : { "opened" : true }, "type" : "naGroupRootFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('cba'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "cba", "id" : "cba", "parent" : "cab", "text" : "Blog", "state" : { "opened" : true }, "type" : "naFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('cbb'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "cbb", "id" : "cbb", "parent" : "cab", "text" : "Media Albums", "state" : { "opened" : true }, "type" : "naFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_cms_tree__user__administrator() {
        $dataSetName = $this->dataSetName('cms_tree__user__administrator');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_admin);
        } catch (Exception $e) {
            echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit();
        }

        $do = false; try { $doc = $this->cdb->get('bab'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "bab", "id" : "bab", "parent" : "baa", "text" : "Administrator", "state" : { "opened" : true }, "type" : "naUserRootFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('bba'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "bba", "id" : "bba", "parent" : "bab", "text" : "Blog", "state" : { "opened" : true }, "type" : "naFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('bbb'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "bbb", "id" : "bbb", "parent" : "bab", "text" : "Media Albums", "state" : { "opened" : true }, "type" : "naFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_cms_tree__user__guest() {

        $dataSetName = $this->dataSetName('cms_tree__user__guest');
        $dataSetName = strToLower($dataSetName);
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit();
        }

        $do = false; try { $doc = $this->cdb->get('dab'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "dab", "id" : "dab", "parent" : "baa", "text" : "Guest", "state" : { "opened" : true }, "type" : "naUserRootFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('dba'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "dba", "id" : "dba", "parent" : "dab", "text" : "Blog", "state" : { "opened" : true }, "type" : "naFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('dbb'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "dbb", "id" : "dbb", "parent" : "dba", "text" : "Front page", "selected" : true, "type" : "naDocument" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };

        $do = false; try { $doc = $this->cdb->get('dbc'); } catch (Exception $e) { $do = true; };
        $data = '{ "database" : "'.$dataSetName.'", "_id" : "dbc", "id" : "dbc", "parent" : "dab", "text" : "Media Albums", "state" : { "opened" : true }, "type" : "naFolder" }';
        if ($do) try { $this->cdb->post($data); } catch (Exception $e) { echo '<pre>'.json_encode(json_decode($data),JSON_PRETTY_PRINT).'</pre>'; echo $e->getMessage(); echo '<br/>'; };


        echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_cms_documents__user__administrator() {
        $dataSetName = $this->dataSetName('cms_documents__user__administrator');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_admin);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }
        if ($this->debug) echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_cms_documents__user__guest() {
        $dataSetName = $this->dataSetName('cms_documents__user__guest');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }


        echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_cms_documents__role__guests() {
        $dataSetName = $this->dataSetName('cms_documents__role__guests');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        $xec = 'rm -rf "'.realpath(dirname(__FILE__)).'/siteData/'.$this->cms->domain.'/*"';
        exec ($xec, $output, $result);
        $dbg = array (
            'xec' => $xec,
            'output' => $output,
            'result' => $result
        );
        if ($this->debug) echo '<pre>'.json_encode($dbg,JSON_PRETTY_PRINT).'</pre><br/>';
        echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_data_themes() {
        // TODO : error handling

        $dataSetName = $this->dataSetName('data_themes');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        //if ($this->debug) { echo '<pre style="color:orange;background:navy;">'; var_dump ($cdb); echo '</pre>';  }
        //if ($this->debug) { echo '<pre style="color:orange;background:navy;">'; var_dump (css_to_array(file_get_contents(dirname(__FILE__).'/themes/nicerapp_default.css'))); echo '</pre>';}

        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        $rec = array(
            '_id' => cdb_randomString(20),
            'role' => 'guests',
            'theme' => 'default',
            'specificityName' => 'site',
            'menusFadingSpeed' => 400,
            'menusUseRainbowPanels'=> true,
            'textBackgroundOpacity' => 0.38,
            'lastUsed' => time(),
            'dialogs' => array_merge_recursive(
                            css_to_array (file_get_contents(
                                realpath(dirname(__FILE__).'/../../../..')
                                .'/NicerAppWebOS/themes/nicerapp_default_siteContent-almost-transparent.css'
                            )),
                            css_to_array (file_get_contents(
                                realpath(dirname(__FILE__).'/../../../..')
                                .'/NicerAppWebOS/themes/nicerapp_app.2D.musicPlayer.css'
                            ))
            )
/*
            'dialogs' => css_to_array (file_get_contents(
                realpath(dirname(__FILE__).'/../../../..')
                .'/NicerAppWebOS/themes/nicerapp_default.css'
            ))
*/
        );
        if ($this->debug) { echo '<pre style="color:blue">'; var_dump ($rec); var_dump ($cdb); echo '</pre>'; }
        try {
            $this->cdb->post($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }
        $rec = array(
            '_id' => cdb_randomString(20),
            'lastUsed' => time(),
            'view' => 'applications/2D/musicPlayer',
            'role' => 'guests',
            'theme' => 'app \'musicPlayer\' default',
            'menusFadingSpeed' => 400,
            'menusUseRainbowPanels' => true,
            'textBackgroundOpacity' => 0.38,
            'dialogs' => array_merge_recursive(
                            css_to_array (file_get_contents(
                                realpath(dirname(__FILE__).'/../../../..')
                                .'/NicerAppWebOS/themes/nicerapp_default_siteContent-almost-transparent.css'
                            )),
                            css_to_array (file_get_contents(
                                realpath(dirname(__FILE__).'/../../../..')
                                .'/NicerAppWebOS/themes/nicerapp_app.2D.musicPlayer.css'
                            ))
            )
        );
        if ($this->debug) { echo '<pre style="color:blue">'; var_dump ($rec); var_dump ($cdb); echo '</pre>'; }
        try {
            $this->cdb->post($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        $rec = [
            'index' => [
                'fields' => [ 'theme', 'view', 'url', 'role', 'user', 'ip', 'ua' ]
            ],
            'name' => 'primaryIndex',
            'type' => 'json'
        ];
        try {
            $this->cdb->setIndex ($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        $rec = [
            'index' => [
                'fields' => [ 'lastUsed' ]
            ],
            'name' => 'sortIndex',
            'type' => 'json'
        ];
        try {
            $this->cdb->setIndex ($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }


        echo 'Created and populated database '.$dataSetName.'<br/>'.PHP_EOL;
    }
    
    public function createDataSet_settings_naVividMenu() {
        $dataSetName = $this->dataSetName('settings_naVividMenu');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        //if ($this->debug) { echo '<pre style="color:orange;background:navy;">'; var_dump ($cdb); echo '</pre>';  }
        //if ($this->debug) { echo '<pre style="color:orange;background:navy;">'; var_dump (css_to_array(file_get_contents(dirname(__FILE__).'/themes/nicerapp_default.css'))); echo '</pre>';}

        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }
        $rec = [
            'index' => [
                'fields' => [ 'menuID', 'url', 'browserSizeX', 'browserSizeY' ]
            ],
            'name' => 'primaryIndex',
            'type' => 'json'
        ];
        try { 
            $this->cdb->setIndex ($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        echo 'Created and populated database '.$dataSetName.'<br/>'.PHP_EOL;
    }

    public function createDataSet_api_wallpaperscraper__plugin_googleImages() {
        $dataSetName = $this->dataSetName('api_wallpaperscraper__plugin_googleImages');
        $dataSetName = strToLower($dataSetName);
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }
        echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_api_wallpaperscraper__plugin_bingImages() {
        $dataSetName = $this->dataSetName('api_wallpaperscraper__plugin_bingImages');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }
        echo 'Created database '.$dataSetName.'<br/>';
    }

    public function createDataSet_app_2D_news__rss_items() {
        $dataSetName = $this->dataSetName('app_2D_news__rss_items');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try { 
            $call = $this->cdb->setSecurity ($this->security_admin);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }
        /*
        $view_001_code  = 'function (doc) {'."\r\n".PHP_EOL;
            $view_001_code .= "\t".'if (doc.pd) {'."\r\n".PHP_EOL;
                $view_001_code .= "\t\t".'emit (doc.pd, doc);'."\r\n".PHP_EOL;
            $view_001_code .= "\t".'}'."\r\n".PHP_EOL;
        $view_001_code .= '}'."\r\n".PHP_EOL;
        $rec = [
            '_id' => '_design/view_001',
            'language' => 'javascript',
            'views' => [ 'by_date' => [ 'map' => $view_001_code ] ]
        ];
        $this->cdb->post($rec);
        if ($this->debug) echo 'Created and populated database '.$dataSetName.'<br/>';
        */


        $rec = [
            'index' => [
                'fields' => [ 'pd', 'p' ]
            ],
            'name' => 'primaryIndex',
            'type' => 'json'
        ];
        try {
            $this->cdb->setIndex ($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }


        $rec = [
            'index' => [
                'fields' => [ 'pd', 'p', 't', 'de' ]
            ],
            'name' => 'searchIndex',
            'type' => 'json'
        ];
        try { 
            $this->cdb->setIndex ($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }


        echo 'Created and populated database '.$dataSetName.'<br/>';
    }

    public function createDataSet_logEntries() {
        $dataSetName = $this->dataSetName('logEntries');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try {
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        $rec = [
            'index' => [
                'fields' => [ 'sid' ]
            ],
            'name' => 'primaryIndex',
            'type' => 'json'
        ];
        try {
            $this->cdb->setIndex ($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }


        echo 'Created and populated database '.$dataSetName.'<br/>';
    }

    public function createDataSet_data_by_users() {
        $dataSetName = $this->dataSetName('data_by_users');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try {
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        $rec = [
            'index' => [
                'fields' => [ 'dataID', 'user' ]
            ],
            'name' => 'primaryIndex',
            'type' => 'json'
        ];
        try {
            $this->cdb->setIndex ($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        echo 'Created and populated database '.$dataSetName.'<br/>';
    }

    public function createDataSet_views() {
        $dataSetName = $this->dataSetName('views');
        try { $this->cdb->deleteDatabase ($dataSetName); } catch (Exception $e) { };
        $this->cdb->setDatabase($dataSetName, true);
        try {
            $call = $this->cdb->setSecurity ($this->security_guest);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        $rec = [
            'index' => [
                'fields' => [ 'viewID' ]
            ],
            'name' => 'primaryIndex',
            'type' => 'json'
        ];
        try {
            $this->cdb->setIndex ($rec);
        } catch (Exception $e) {
            if ($this->debug) { echo '<pre style="color:red">'; var_dump ($e); echo '</pre>'; exit(); }
        }

        echo 'Created and populated database '.$dataSetName.'<br/>';
    }

    //--- ERROR HANDLING AND LOGGING FUNCTIONS

    public function addLogEntries ($entries) {
        #TODO 1-2b // 1- = first to-do item, 2 = 2nd file-set, b = 1 level down into the file-set.
        $fncn = $this->cn.'->addLogEntries($entries)';
        $cdb = $this->cdb;
        $dataSetName = $this->dataSetName('log_entries');
        $cdb->setDatabase($dataSetName, false);

        $t = null; $to = null;
        foreach ($entries[0] as $k => $rec) {
            $t = $rec['t'];
            $to = $rec['to'];
            break;
        };

        $rec = array(
            '_id' => cdb_randomString(20),
            't' => $t,
            'to' => $to,
            'entries' => $entries
        );
        try {
            $cdb->post($rec);
        } catch (Exception $e) {
            global $naLog; global $naWebOS;
            $naLog->addTo_phpOutput( SEID,
                $fncn.' : Error while trying to $cdb->post() : $e->getMessage()='.$e->getMessage().', $cdb->getSession()='.json_encode($cdb->getSession()).', $naWebOS->dbs->findConnection(\'couchdb\')->username='.$naWebOS->dbs->findConnection('couchdb')->username
            );
            return false;
        }
        return true;
    }



    //--- UTILITY FUNCTIONS

    public function getNewRandomID ($relTableName, $fieldName) {
        global $naWebOS;

        $length = false;
        $go = true;
        $done = false;
        $dataSetName2 = 'minLength_randomValuesFor__'.$relTableName.'__'.$fieldName;
        $findCommand = array (
            'selector' => array (
                'tableName' => $relTableName,
                'fieldName' => $fieldName
            ),
            'use_index' => 'primaryIndex',
            'fields' => array ('_id', '_rev', 'minLength' )
        );
        try {
            $dataSetName2 = $this->dataSetName($dataSetName2);
            $naWebOS->dbsAdmin->findConnection('couchdb')->cdb->setDatabase ($dataSetName2, true); // true = create db if it doesnt exist already
            $call = $naWebOS->dbsAdmin->findConnection('couchdb')->cdb->find ($findCommand);
        } catch (Exception $e) {
            global $naErr;
            $naErr->addStr('<p>'.$e->getMessage().'</p>'.PHP_EOL, $e->getMessage());
            echo $e->getMessage();
            $go = false;
            $done = true;
        }
        $length = null;
        if ($go) {
            if (!is_null($call) && !is_null($call->body) && count($call->body->docs)===0)
                $length = 1;
            else {
                $length = intval($call->body->docs[0]->minLength);
            }
        }
        if (!is_numeric($length)) $length = 1;
        if ($length !== false) {
            $tried = 0;
            $maxCombos = maxRandomStringCombinations($length);
            while (!$done) {
                $valueToTry = randomString($length);
                $tried++;
                if ($tried > $maxCombos/5) {
                    $length++;
                    $maxCombos = maxRandomStringCombinations($length);
                    $valueToTry = randomString($length);
                    $tried = 1;
                }
                $go = true;
                $findCommand = array (
                    'selector' => array (
                        $fieldName => $valueToTry,
                    ),
                    'use_index' => 'primaryIndex', // note that $fieldName had better be in the 'primaryIndex', created by one of the createDataSet_*() functions listed in this file!
                    'fields' => array ('_id', '_rev' )
                );
                try {
                    $dataSetName = $this->dataSetName($relTableName);
                    $this->cdb->setDatabase ($relTableName, false);
                    $call = $this->cdb->find ($findCommand);
                } catch (Exception $e) {
                    global $naErr;
                    $naErr->addStr('<p>'.$e->getMessage().'</p>'.PHP_EOL, $e->getMessage());
                    echo $e->getMessage();
                    $go = false;
                    $done = true;
                }
                if ($go) {
                    if (!is_null($call) && !is_null($call->body) && count($call->body->docs)===0) $done = true;
                }
            }
            return $valueToTry;
        }
        return false;
    }

    public function getAllDatabaseNames () {
        return $this->cdb->getAllDatabases();
    }

    public function changeThemeName ($oldThemeName, $newThemeName) {
        if ($oldThemeName=='default') {
            echo 'ERROR : can not change the name of theme "default".<br/>'.PHP_EOL;
            return false;
        }
        
        $dataSetName = $this->dataSetName('data_themes');
        $this->cdb->setDatabase($dataSetName, false);
        $call = $this->cdb->getAllDocs();

        //echo '<pre>'; //var_dump ($call);
        foreach ($call->body->rows as $idx => $row) {
            $call2 = $this->cdb->get($row->id);
            //var_dump ($call2);
            if (property_exists($call2->body,'theme')) {
                $theme = $call2->body->theme;
                
                if ($call2->body->theme==$oldThemeName) {
                    $updatedData = (array)$call2->body;
                    $updatedData['theme'] = $newThemeName;
                    $response = $this->cdb->put ($call2->body->_id, $updatedData);
                    return $response->body->ok;
                }
            }
        }
    }

    public function delete_allThemes_byName ($themeName) {
        if ($themeName=='default') {
            echo 'ERROR : can not the delete themes which are named "default".<br/>(please use '.PHP_EOL;
            return false;
        }
        
        $dataSetName = $this->dataSetName('data_themes');
        $this->cdb->setDatabase($dataSetName, false);
        $call = $this->cdb->getAllDocs();

        //echo '<pre>'; //var_dump ($call);
        foreach ($call->body->rows as $idx => $row) {
            $call2 = $this->cdb->get($row->id);
            //var_dump ($call2);
            if (property_exists($call2->body,'theme')) {
                if ($call2->body->theme==$themeName) {
                    $response = $this->cdb->delete ($call2->body->_id, $call2->body->_rev);
                    try { $call3 = $this->cdb->get($row->id); } catch (Exception $e) { $call3 = false; }
                    while ($call3 && $call3->body->ok) {
                        $this->cdb->delete ($call3->body->_id, $call3->body->_rev);
                        try { $call3 = $this->cdb->get($row->id); } catch (Exception $e) { $call3 = false; }
                    }
                    
                    return $call3->body->ok || $response->body->ok;
                }
            }
        }
    }

    public function testDBconnection() {
        $r = '';

        global $naWebOS; global $naErr; global $naLog;
        $cdbDomain = str_replace('.','_',$naWebOS->domain);
        $cdb = $this->cdb;

//echo '<pre style="background:blue;color:white;">'; var_dump ($_COOKIE);echo '</pre>';
        if (
            !array_key_exists('cdb_authSession_cookie', $_COOKIE)
            && !array_key_exists('AuthSession', $_COOKIE)
        ) {
            //echo '2';
            if (
                array_key_exists('REMEMBERME', $_COOKIE)
                && is_string($_COOKIE['REMEMBERME'])
                && $_COOKIE['REMEMBERME']!==''
            ) {
                $naLoginResult_birke = useRememberme_birke();
                $userID = $naLoginResult_birke->getCredential();

                if (is_object($naLoginResult_birke) && property_exists($naLoginResult_birke, 'cookieExists')) {
                    $loginMethod = 1;
                    $isSuccess = $naLoginResult_birke->cookieExists && $naLoginResult_birke->tripleWasFound;
                    $isExpired = $naLoginResult_birke->tripleWasValid;

                } else if (is_object($naLoginResult_birke)) {
                    $loginMethod = 2;
                    $isSuccess = $naLoginResult_birke->isSuccess();
                    $isExpired = $naLoginResult_birke->isExpired();
                }

                $loggedIn = $isSuccess && !$isExpired;
                //echo '<pre>'; var_dump ($loginResult); exit();
                if ($loggedIn) $r .= 'status : Success'; else $r .= 'Browser cookies do not contain (valid) database connection settings.<br/>(problem #1, rememberMeByBirke->isSuccess()='.($isSuccess?'true':'false').', rememberMeByBirke->isExpired()='.($isExpired?'true':'false').').';
            } else {
                $loginMethod = 3;
                $userID = 'NULL';
                $r .= 'Browser cookies do not contain (valid) database connection settings.<br/>(problem #2 - not a single type of cookie could be used to authenticate the user).';
            }


        } else {
            $loginMethod = 4;
            if (session_status() === PHP_SESSION_NONE) {
                ini_set('session.gc_maxlifetime', 3600 * 24 * 7);
                session_start();
                $_SESSION['cdb_authSession_cookie'] = $_COOKIE['cdb_authSession_cookie'];
            };

            cdb_login ($naWebOS->dbs->findConnection('couchdb')->cdb, null, null);

            $sessionData = $cdb->getSession();
            //var_dump ($sessionData); exit();
            $_SESSION['cdb_loginName'] = $sessionData->body->userCtx->name;
            $userID = $sessionData->body->userCtx->name;
            if (count($sessionData->body->userCtx->roles)>0) $r .= 'status : Success'; else $r .= 'Browser cookies and server hosted credentials do not contain (valid) database connection settings.<br/>(problem #3 - the cdb_authSession_cookie and AuthSession cookies are both invalid and the settings in .../NicerAppWebOS/domainConfigs/$naWebOS->DOMAIN/couchdb.json are invalid as well).';


        }
        return [ 'result' => $r, 'userID' => $userID, 'loginMethod' => $loginMethod ];
    }

    public function editDataSubSet ($relTableName=null, $findCommand=null, $overlay=null) {
        $fncn = $this->cn.'::editDataSubSet()';
        $go = true;

        $dataSetName = $this->dataSetName($relTableName);
        $this->cdb->setDatabase ($dataSetName, false);

        try {
            $call = $this->cdb->find ($findCommand);
        } catch (Exception $e) {
            $go = false;
        };

        if ($call->headers->_HTTP->status!=='200') {
            $msg = 'Couchdb is not responding with a 200 HTTP code to a $findCommand query.';
            trigger_error ($msg, E_USER_WARNING);
        } elseif (count($call->body->docs)===0) {
            $document = $overlay;
            if (
                array_key_exists('user',$_POST)
                && $_POST['user']!==''
            ) $document['user'] = $_POST['user'];
            if (
                array_key_exists('role',$_POST)
                && $_POST['role']!==''
            ) $document['role'] = $_POST['role'];

            try { $call = $this->cdb->get ($_POST['id']); $document['_rev'] = $call->body->_rev; } catch (Exception $e) { };

            try { $call = $this->cdb->post($document); } catch (Exception $e) { cdb_error (500, $e, 'Could not add/update document in '.$dataSetName); exit(); };

        } elseif (count($call->body->docs)===1) {
            global $toArray;

            try { $call = $this->cdb->get ($call->body->docs[0]->_id); $document2 = $toArray($call->body); $document = array_merge ($document2, $overlay); } catch (Exception $e) { };

            try { $call = $this->cdb->post($document); } catch (Exception $e) { cdb_error (500, $e, 'Could not add/update document in '.$dataSetName); return false; };

        } elseif (count($call->body->docs) > 1) {
            $msg = $fncn.' : more than 1 document returned.';
            trigger_error ($msg, E_USER_WARNING);
        }
        return true;
    }

    public function cms_editDocument () {
        global $naWebOS;
        $db = $naWebOS->dbs->findConnection('couchdb');
        $cdb = $db->cdb;

        $cdb->setDatabase($_POST['database'],false);
        $dataID = array_key_exists('dataID',$_POST) ? $_POST['dataID'] : $naWebOS->getDataID($_POST['database'], 'dataID');
        $document = array (
            'database' => $_POST['database'],
            '_id' => $_POST['id'],
            'id' => $_POST['id'],
            'dataID' => $dataID,
            'document' => $_POST['document']
        );
        if (
            array_key_exists('user',$_POST)
            && $_POST['user']!==''
        ) $document['user'] = $_POST['user'];
        if (
            array_key_exists('role',$_POST)
            && $_POST['role']!==''
        ) $document['role'] = $_POST['role'];
        try { $call = $cdb->get ($_POST['id']); $document['_rev'] = $call->body->_rev; } catch (Exception $e) { };
        try { $call = $cdb->post($document); } catch (Exception $e) { cdb_error (500, $e, 'Could not add/update record in '.$_POST['database']); exit(); };

        $dataSetName = str_replace('_documents', '_tree', $_POST['database']);
        $cdb->setDatabase($dataSetName,false);
        $document = null;
        try { $call = $cdb->get ($_POST['id']); $document = (array)$call->body; } catch (Exception $e) { };// cdb_error (500, $e, 'Could not find record (id='.$_POST['id'].') in '.$dataSetName); exit(); };
        if (
            (
                !is_null($document)
                && is_array($document)
                && !array_key_exists('dataID', $document)
            )
            || $document['dataID']!==$dataID
        ) {
            $document['dataID'] = $dataID;
        }
        //echo '<pre>'; var_dump ($document); die();
        try { $call = $cdb->post($document); } catch (Exception $e) { cdb_error (500, $e, 'Could not update document'); exit(); };

        return $dataID;
    }

    public function editDataByUsers ($findCommand=null, $dataIDs=null, $dataIDs_idx=null) {
        $dr = $dataIDs[$dataIDs_idx];

        $go = true;
        try {
            $call = $this->cdb->find ($findCommand);
        } catch (Exception $e) {
            $go = false;
        };

        if ($call->headers->_HTTP->status!=='200') {
            $msg = 'Couchdb is not responding with a 200 HTTP code to a $findCommand query.';
            trigger_error ($msg, E_USER_WARNING);
        } elseif (count($call->body->docs)===0) {
            $document = [
                'dataID' => $dr['resultValue'],
                'database' => $_POST['database'],
                'viewSettings' => [
                    "/path/to/blogEditor" => [
                    ]
                ]
            ];
            if (
                array_key_exists('user',$_POST)
                && $_POST['user']!==''
            ) $document['user'] = $_POST['user'];
            if (
                array_key_exists('role',$_POST)
                && $_POST['role']!==''
            ) $document['role'] = $_POST['role'];

            try { $call = $this->cdb->get ($_POST['id']); $document['_rev'] = $call->body->_rev; } catch (Exception $e) { };

            try { $call = $this->cdb->post($document); } catch (Exception $e) {
                cdb_error (500, $e, 'Could not add/update document in '.$dataSetName);
                exit();
            };

            return true;
        }

    }

/* DEPRACATED :
    public function getSettingsPositions() {
        global $naWebOS; global $naErr; global $naLog;
        $naLogEntries = [];
        $cdbDomain = str_replace('.','_',$naWebOS->domain);
        $cdb = $this->cdb;
        //echo '<pre>'; var_dump ($_POST);
        $dataSetName = strtolower($cdbDomain.'___'.$_POST['dbType']);
        //echo $dataSetName.'<br/>'.PHP_EOL.PHP_EOL;
        try {
            $cdb->setDatabase($dataSetName, false);
        } catch (Exception $e) {
            $msg = $fncn.' : Could not access database "'.$dataSetName.'", $e->getMessage()='.$e->getMessage();
            //echo $msg;
            trigger_error ($msg, E_USER_WARNING);
        }

        $findCommand = array (
            'selector' => array(
                'menuID' => $_POST['menuID'],
                'url' => $_POST['url'],
                'browserSizeX' => intval($_POST['browserSizeX']),
                'browserSizeY' => intval($_POST['browserSizeY'])
            ),
            'fields' => array( '_id', 'menuID', 'url', 'browserSizeX', 'browserSizeY', 'items' )
        );

        try {
            $call = $cdb->find ($findCommand);
        } catch (Exception $e) {
            $msg = $fncn
                .' : Error while searching database with $dataSetName='.$dataSetName.'. '
                .'$e->getMessage()='.$e->getMessage();
            trigger_error ($msg, E_USER_WARNING);
            //echo $msg;
            return false;
        };

        $debug = false;
        if ($debug) {
            $msg = $fncn
                .' : info : $findCommand='; var_dump ($findCommand); echo '.<br/>'.PHP_EOL
                .', $call='; var_dump ($call); echo '.<br/>'.PHP_EOL;
            //echo $msg;
            trigger_error ($msg, E_USER_NOTICE);
            //exit();
        }

        $r = false;
        $hasRecord = false;
        //var_dump ($call->headers->_HTTP->status); die();
        if ($call->headers->_HTTP->status==='200') {
            foreach ($call->body->docs as $idx => $d) {
            //echo 'woohoo_'.$idx."\r\n";
                $hasRecord = true;
                $r = json_encode((array)$d);//.'<br/>'.PHP_EOL;
                break;
            }
        }
        return $r;
    }

    public function setSettingsPositions() {
        $fncn = $this->cn.'->setSettingsPositions()';

        global $naWebOS; global $naErr; global $naLog;
        $cdbDomain = str_replace('.','_',$naWebOS->domain); global $cdbDomain;

        $dataSetName = $cdbDomain.'___'.$_POST['dbType'];
        $cdb = $naWebOS->dbs->findConnection('couchdb')->cdb;
        $cdb->setDatabase($dataSetName, false);

        $items = json_decode($_POST['items'],true);
        $findCommand = array (
            'selector' => array(
                'menuID' => $_POST['menuID'],
                'url' => $_POST['url'],
                'browserSizeX' => intval($_POST['browserSizeX']),
                'browserSizeY' => intval($_POST['browserSizeY'])
            ),
            'fields' => array(
                '_id', '_rev'
            )
        );
        if ($debug) { echo '$findCommand='; var_dump ($findCommand); echo PHP_EOL.PHP_EOL; }
        $naLog->add ( [
            $naLog->add_var ($fncn, '$findCommand', $findCommand)
        ] );

        $call = $cdb->find ($findCommand);
        //if ($debug) { echo '$call='; var_dump ($call); echo PHP_EOL.PHP_EOL; }

        if (count($call->body->docs)===0) {
            postRecord($cdb, $items, $fncn);
        } else {
            for ($j=0; $j < count($items); $j++) {
                for ($i=0; $i < count($call->body->docs); $i++) {
                    try {
                        $cdb->delete ($call->body->docs[$i]->_id, $call->body->docs[$i]->_rev);
                    } catch (Exception $e) {
                        trigger_error ($fncn.' : Could not delete doc with id='.$call->body->docs[$i]->_id.', $e->getMessage()='.$e->getMessage(), E_USER_NOTICE);
                    };
                }
                postRecord($cdb, $items, $fncn);
            }
        }
        function postRecord ($cdb, $items, $fncnSuper) {
            $fncn = $fncnSuper.'..postRecord($cdb, $items)';
            //global $cdb;
            global $cdbDomain;
            global $naWebOS;
            $debug = false;
            $id = cdb_randomString(20);
            $rec = [
                'id' => $id,
                'menuID' => $_POST['menuID'],
                'url' => $_POST['url'],
                'browserSizeX' => intval($_POST['browserSizeX']),
                'browserSizeY' => intval($_POST['browserSizeY']),
                'items' => $items
            ];

            $dataSetName = $cdbDomain.'___'.$_POST['dbType'];
            $cdb->setDatabase($dataSetName, false);

            //if ($debug) { echo '<pre>'; var_dump ($rec); var_dump($_POST); var_dump(json_last_error()); echo '</pre>'.PHP_EOL.PHP_EOL; }
            try {
                $call3 = $cdb->post($rec);
            } catch (Exception $e) {
                trigger_error ($fncn.' : status : Failed : could not update record in database ('.$dataSetName.')', E_USER_WARNING);

            }

            if ($call3->headers->_HTTP->status=='201') {
                echo 'status : Success.';
                exit();
            } else {
                echo 'status : Failed.';
                exit();
            }
        }
    }
*/
}
?>
