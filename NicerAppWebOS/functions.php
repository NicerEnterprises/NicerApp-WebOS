<?php
require_once(dirname(__FILE__).'/boot.php');
require_once(dirname(__FILE__).'/3rd-party/vendor/autoload.php');
use Birke\Rememberme\Authenticator;
use Birke\Rememberme\Storage\FileStorage;
use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;

global $toArray;
$toArray = function($x) use(&$toArray) {
    return is_scalar($x)
        ? $x
        : array_map($toArray, (array) $x);
};

function filePathToURL ($filepath) {
    global $naWebOS;
    $fp = str_replace(realpath(dirname(__FILE__).'/..'),'',$filepath);
    $fp = 'https://'.$naWebOS->domain.$fp;
    return $fp;
}

function safeLoadJSONfile($filePath, $mustExist=true) {

    if (!file_exists($filePath)) {
        if (!$mustExist) return []; else trigger_error ('File "'.$filePath.'" does not exist', E_USER_ERROR);
    };
    $textData = file_get_contents ($filePath);
    $jsonData = json_decode ($textData, true);
    //echo json_last_error_msg();
    if (json_last_error()!==JSON_ERROR_NONE) trigger_error ('Error during JSON decoding of file content for file "'.$filePath.'" : '.json_last_error_msg(), E_USER_ERROR);
    return $jsonData;
}

function getBackgrounds ($root, $webRoot, $recursive=false) {
    $excl = '/(?!.*thumbs).*/'; // exclude anything that includes 'thumbs' in it's filepath.

    $files1 = getBackgroundFiles ($root, FILE_FORMATS_photos_texts, $excl, $recursive);
    $files2 = processBackgroundFiles ($files1, $root, $webRoot, $recursive);
    //echo '<pre>'; var_dump ($root); var_dump ($webRoot); var_dump ($files2); die();

    return $files2;
}
function getBackgroundFiles ($root, $fileFormats, $excl, $recursive) {
    if ($recursive) {
        $r = getFilePathList ($root, true, $fileFormats, $excl, array('file'), null, 1, true);
    } else {
        $r = getFilePathList ($root, true, $fileFormats, $excl, array('file'));
    }
    return $r;
}
function processBackgroundFiles (&$files, $root, $webRoot, $recursive) {
    $keyCount = 0;
    $valueCount = 0;
    $params = array (
        'root' => $root,
        'webRoot' => $webRoot,
        'recursive' => $recursive,
        'a' => &$files,
        'prevLevel' => 0,
        'keyCount' => &$keyCount,
        'valueCount' => &$valueCount,
    );
    $callKeyForValues = false;
    walkArray ( $files, /*'processBackgroundFile_key'*/null, 'processBackgroundFile_value', $callKeyForValues, $params );
    return $files;
}
function processBackgroundFile_key ($cd) {
    $path = $cd['path'].'/'.$cd['k'];
}
function processBackgroundFile_value ($cd) {
    if ($cd['params']['recursive']) {
        if (!is_int($cd['k'])) {
            $path = $cd['path'].'/'.$cd['k'];
            $path = substr($path,1);
        } else {
            $path = $cd['path'];
        }
        if ($cd['path']!=='') {
            $file = $cd['params']['root'].$path.'/'.$cd['v'];
        } else {
            $file = $cd['params']['root'].$cd['v'];
        }
    } else {
        $path = $cd['path'].$cd['k'];
        $file = $cd['v'];
    }

    //echo '<pre>';var_dump ($file);echo '</pre>';die();
    $td = str_replace ($cd['params']['root'], '', $file);
    //echo '<pre>';var_dump ($cd);echo '</pre>';die();
    $path2 = $cd['path'].'/'.$cd['k'];
    $path2 = substr($path2,1);
    $ref = &chaseToPath ($cd['params']['a'], $path2);
    $ref = $td;
}


//require_once (dirname(__FILE__).'/phpHardCrypto/boot.php');
//use Rene_AJM_Veerman\phpHardCrypto;
global $randomStringSeed;
$randomStringSeed = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
function maxRandomStringCombinations ($length) {
    global $randomStringSeed;
    return pow($length, strlen($randomStringSeed));
}

function randomString ($length) {
    global $randomStringSeed;
    $r = '';
    for ($i=0; $i<$length; $i++) {
        $r .= substr ($randomStringSeed, rand(0,strlen($randomStringSeed)), 1);
    };
    return $r;
}

$phpScript_startupTime = microtime(true); global $phpScript_startupTime;

function mainErrorHandler ($errno, $errstr, $errfile, $errline) {
    /*
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        echo 'die'; exit();
        return false;
    }*/

    global $naWebOS; global $naErr; global $naLog;
    $err = $naErr->add ($errno, $errstr, $errfile, $errline);
    $naLog->add ( [ $err ] ); // outputs to screen and apache log file as well.
    return true;


}

function backtrace() {
    $data = debug_backtrace();
    //$data = array_splice ($data, 1, 2);
    //return '<pre>'.json_encode($data, JSON_PRETTY_PRINT).'</pre>';
    $html = '';
    while (count($data) > 0) {

        $it = array_shift($data);

        if (
            array_key_exists('function', $it)
            && (
                // ignore these, as they are part of the custom error handling system itself :
                $it['function'] == 'backtrace'
                || $it['function'] == 'mainErrorHandler'
                || $it['function'] == 'trigger_error'
            )
        ) continue;

        $html .= "\t\t\t".'<div class="backtraceItem">'.PHP_EOL;
        if (array_key_exists('class', $it) && $it['class']!=='') {
            $html .=
                "\t\t\t\t".'<span class="backtraceCodeLocation">'.PHP_EOL
                .'<span class="backtraceClassLabel">Class </span>'.PHP_EOL
                .'<span class="backtraceClass">'.$it['class'].'</span>'.PHP_EOL
                .'<span class="backtraceType">'.$it['type'].'</span>'.PHP_EOL
                .'<span class="backtraceFunction">'.$it['function'].'</span>'.PHP_EOL
                .'</span><br/>'.PHP_EOL.PHP_EOL;
        } else if (array_key_exists('function', $it) && $it['function']!=='') {
            $html .=
                "\t\t\t\t".'<span class="backtraceCodeLocation">'
                .'<span class="backtraceFunctionLabel">Function </span>'.PHP_EOL
                .'<span class="backtraceFunction">'.$it['function'].'</span>'.PHP_EOL
                .'</span><br/>'.PHP_EOL.PHP_EOL;
        }
        if (array_key_exists('file', $it) && $it['file']!=='') {
            $html .=
                "\t\t\t\t".'<span class="backtraceFileLabel">Location</span>'.PHP_EOL
                .'<span class="backtraceFile">'.$it['file'].'</span><span class="backtraceFunctionArgSeperator"> : </span>'
                .'<span class="backtraceLineNum">'.$it['line'].'</span>';
        }
        if (array_key_exists('args',$it) && is_array($it['args']) && count($it['args']) > 0) {
            $html .= "\t\t\t\t".'<div class="backtraceFunctionArgs"><span class="backtraceFunctionArgsLabel">Function arguments</span><span class="backtraceFunctionArgSeperator"> : </span>';
            foreach ($it['args'] as $idx => $arg) {
                if (is_array($arg)) {
                    $html .= "\t".'<span class="backtraceFunctionArg">'.json_encode($arg).'</span><span class="backtraceFunctionArgSeperator">,</span> ';
                } else {
                    $html .= "\t".'<span class="backtraceFunctionArg">'.json_encode($arg).'</span><span class="backtraceFunctionArgSeperator">,</span> ';
                }
            }
            $html .= '</div>'.PHP_EOL;
        }
        $html .= '</div><br/>'.PHP_EOL.PHP_EOL.PHP_EOL;
    }
    return $html;
}

function checkForJSONerrors($rawData, $filepath, $exampleFilepath) {
    if (json_last_error() !== JSON_ERROR_NONE) {
        $error =
            '<div class="phpJSONerror">'.PHP_EOL
                .'<div class="phpJSONerrorTitle">PHP JSON ERRROR :</div>'.PHP_EOL
                .'<div class="phpJSONerror_location">'.PHP_EOL
                    .'<span class="phpJSONerror_filepathLabel">File path : </span>'
                    .'<span class="phpJSONerror_filepath">'.$filepath.'</span><br/>'.PHP_EOL
                    .'<span class="phpJSONerror_exampleFilepathLabel">Example template file path : </span>'.PHP_EOL
                    .'<span class="phpJSONerror_exampleFilepath">'.$exampleFilepath.'</span>'.PHP_EOL
                .'</div>'.PHP_EOL
                .'<div class="phpJSONerror_rawData">'.htmlspecialchars($rawData).'</div>'.PHP_EOL
                .'<div class="phpJSONerror_message">'
                    .'<span class="phpJSONerror_msgLabel">Error message : </span>'
                    .'<span class="phpJSONerror_msg">'.json_last_error_msg().'</span>'
                .'</div>'
            .'</div>';
        trigger_error ($error, E_USER_ERROR);
        return false;
    }
    return true;
}

function cdb_login($cdb, $cRec, $username) {
    //echo '$_COOKIE=<pre>';var_dump($_COOKIE);echo '</PRE>';
    $done = false;
    if ($username=='admin') {
        try {
            $cdb->login ($cRec['username'], $cRec['password']);
        } catch (Exception $e) {
            trigger_error ($fncn.' : could not login using credentials '.json_encode($cRec).'.', E_USER_ERROR);
            return false;
        }
        $cdb_session = $cdb->getSession();
        return [
            'username' => $cdb_session->body->userCtx->name,
            'roles' => $cdb_session->body->userCtx->roles
        ];
    } else {
        if (
            is_array($_COOKIE)
            && array_key_exists('cdb_authSession_cookie',$_COOKIE)
            && is_string($_COOKIE['cdb_authSession_cookie'])
            && $_COOKIE['cdb_authSession_cookie']!==''
        ) {
            $r = $cdb->loginByCookie ($_COOKIE['cdb_authSession_cookie']);

            //echo '<h1>functions.php :</h1><pre style="background:blue;color:yellow;overflow-y:auto">'; var_dump ($_COOKIE); var_dump ($cdb->getSession()); echo '</pre>'; exit();

            //if (!is_null($r)) {
                //echo '<pre>'; var_dump ($cdb->getSession()); exit();
                $cdb_session = $cdb->getSession();
                if (is_object($cdb_session) && $cdb_session->body->ok) {
                    $done = true;
                    $_SESSION['cdb_loginName'] = $cdb_session->body->userCtx->name;
                                //var_dump ('t1:'.$_SESSION['cdb_loginName']);

                    return [
                        'username' => $cdb_session->body->userCtx->name,
                        'roles' => $cdb_session->body->userCtx->roles
                    ];
                }
            //}
        }

        if (
            is_array($_COOKIE)
            && array_key_exists('AuthSession',$_COOKIE)
            && is_string($_COOKIE['AuthSession'])
            && $_COOKIE['AuthSession']!==''
        ) {
            // var_dump (123);
            $r = $cdb->loginByCookie ($_COOKIE['AuthSession']);
            //echo '<pre>'; var_dump ($r); exit();
            //if (!is_null($r)) {
                //echo '<pre>'; var_dump ($cdb->getSession()); exit();
            $cdb_session = $cdb->getSession();
            if (is_object($cdb_session) && $cdb_session->body->ok) {
                $done = true;
                $_SESSION['cdb_loginName'] = $cdb_session->body->userCtx->name;
                //var_dump ('t21:'.$_SESSION['cdb_loginName']);
                return [
                    'username' => $cdb_session->body->userCtx->name,
                    'roles' => $cdb_session->body->userCtx->roles
                ];
            } else {
                //echo 't55:'; var_dump ($cRec);
                cdb_login ($cRec['username'], $cRec['password'], Sag::AUTH_COOKIE);
                $cdb_session = $cdb->getSession();
                if (is_object($cdb_session) && $cdb_session->body->ok) {
                    $done = true;
                    $_SESSION['cdb_loginName'] = $cdb_session->body->userCtx->name;
                    //var_dump ('t22:'.$_SESSION['cdb_loginName']);
                    return [
                        'username' => $cdb_session->body->userCtx->name,
                        'roles' => $cdb_session->body->userCtx->roles
                    ];
                }
            }
            //}
        }
    }

    if (!$done) {
        try {
            //echo 'COOKIE RESET : '.json_encode($cRec); die();
            $cdb->login ($cRec['username'], $cRec['password']);
            //if ($cRec['username']!=='Guest') trigger_error ('Session cookie expired. You have been logged in as \''.$cRec['username'].'\'', E_USER_WARNING);
            //echo '<pre>'; var_dump ($cdb->getSession()); exit();
            $cdb_session = $cdb->getSession();
        } catch (Exception $e) {
            trigger_error ($fncn.' : could not login using credentials '.json_encode($cRec).'.', E_USER_WARNING);
        }
        if (is_object($cdb_session) && $cdb_session->body->ok) {
            if ($cdb_session->body->userCtx->name!=='admin') $_SESSION['cdb_loginName'] = $cdb_session->body->userCtx->name;
            //var_dump ('t3:'.$_SESSION['cdb_loginName']);

            return [
                'username' => $cdb_session->body->userCtx->name,
                'roles' => $cdb_session->body->userCtx->roles
            ];
        }
    }

    return NULL;
}


// * outdated, superceded by .../NicerAppWebOS/phpHardCrypto which uses the built-in 'sodium' encryption library functions in PHP7+
function useRememberme_birke($credential='Guest') {
    // Initialize RememberMe Library with file storage
    $storagePath = dirname(__FILE__)."/siteCache/tokens";
    if (!is_writable($storagePath) || !is_dir($storagePath)) {
        die(
            "'$storagePath' does not exist or is not writable by the web server.\n".
            "To run the example, please create the directory and give it the correct permissions."
        );
    }
    global $rememberMeStorage;
    $rememberMeStorage = new FileStorage($storagePath);
    global $rememberMe;
    $rememberMe = new Authenticator($rememberMeStorage);
    global $loginResult;
    $loginResult = $rememberMe->login();
    //echo 'lr:'; var_dump ($loginResult->getCredential());

    if ($loginResult->isSuccess()) {
        $_SESSION['cdb_loginName'] = $loginResult->getCredential();
        //setcookie('cdb_loginName', $loginResult->getCredential(), time() + 604800, '/');
        //echo '<pre>';var_dump ($_SESSION);exit();
        // There is a chance that an attacker has stolen the login token, so we store
        // the fact that the user was logged in via RememberMe (instead of login form)
        $_SESSION['remembered_by_cookie'] = true;


    } else {
        $loginResult = $rememberMe->createCookie($credential);
        $loginResult = $rememberMe->login();
        $_SESSION['cdb_loginName'] = $loginResult->getCredential();
        $_SESSION['remembered_by_cookie'] = true;
    };
    return $loginResult;
}

function ascii2hex($ascii) {
  $hex = '';
  for ($i = 0; $i < strlen($ascii); $i++) {
    $byte = strtoupper(dechex(ord($ascii[$i])));
    $byte = str_repeat('0', 2 - strlen($byte)).$byte;
    $hex.=$byte;
  }
  return $hex;
}


function base64_encode_url($string) {
    return str_replace(['+','/','='], ['-','_',''], base64_encode($string));
}

function base64_decode_url($string) {
    return base64_decode(str_replace(['-','_'], ['+','/'], $string));
}

function execPHP ($file, $flush=true) {
    if ($flush) {
        ob_flush(); // NOT WISE AT ALL (nested calls to execPHP() will crash JSON decoding in the browser due to HTML inserted in AJAX response before the JSON data.
        $c = '';
    } else {
        $c = ob_get_contents();
        if ($c===false) $c = '';
    }
    ob_end_clean();
    ob_start();
    $p = strpos($file,'?');
    $qs = substr($file, $p+1, strlen($file)-$p-1);
    $f = (
        $p === false
        ? $file
        : substr($file, 0, $p)
    );

    //echo $qs; exit();
    if ($p!==false) parse_str ($qs, $_GET); // may seem like a dirty hack, but isn't.
    /*
    echo '$flush='; var_dump ($flush); echo PHP_EOL.PHP_EOL;
    echo '$f='; var_dump ($f); echo PHP_EOL.PHP_EOL;
    */
    include ($f);
    $c .= ob_get_contents();
    ob_end_clean();
    ob_start();
    return $c;
};

function require_return ($file, $flush=false) {
// used by .../domainConfigs/DOMAIN.EXT/mainmenu.php
    if ($flush) {
        ob_flush(); // NOT WISE AT ALL (nested calls to execPHP() will crash JSON decoding in the browser due to HTML inserted in AJAX response before the JSON data.
        $c = '';
    } else {
        $c = ob_get_contents();
        if ($c===false) $c = '';
    }
    ob_end_clean();
    ob_start();
    include ($file);
    $c .= ob_get_contents();
    ob_end_clean();
    ob_start();
    return $c;
}

function css_array_to_css($rules, $indent = 0) {
    $css = '';
    $prefix = str_repeat('  ', $indent);

    foreach ($rules as $key => $value) {
        if (is_array($value)) {
            $selector = $key;
            $properties = $value;

            $css .= $prefix . "$selector {\n";
            $css .= $prefix . css_array_to_css($properties, $indent + 1);
            $css .= $prefix . "}\n";
        } else {
            $property = $key;
            $selector2 = '';
            for ($i=0; $i<strlen($property); $i++) {
                $c = substr($property, $i, 1);
                if ($c === strtolower($c)) {
                    $selector2 .= $c;
                } else {
                    $selector2 .= '-'.strtolower($c);
                }
            }
            $property = $selector2;
            $css .= $prefix . "$property: $value;\n";
        }
    }

    return $css;
}

function css_to_array ($cssContent) {
    $ret = [];

    $c = explode ("\n", $cssContent);
    //echo '<pre style="color:white;background:green">'; var_dump ($c); echo '</pre>';
    foreach ($c as $lineIdx => $lc) {
        if (strpos($lc, '{')!==false) {
            $k = trim(explode('{',$lc)[0]);
            //echo '<pre style="color:cyan;background:green">'; var_dump ($k); echo '</pre>';
            $ret[$k] = [];
        }
        if (strpos($lc, ':')!==false) {
            $kv = trim (explode(':',$lc)[0]);
            $kv1 = explode('-', $kv);
            if (count($kv1)===1) {
                $kv = $kv;
            } else {
                $kv = $kv1[0].ucfirst($kv1[1]);
            };
            //echo '<pre style="color:white;background:green">'; var_dump ($kv); echo '</pre>';
            $v = trim (explode(':',$lc)[1]);
            $v = str_replace (';','',$v);
            //echo '<pre style="color:black;background:green">'; var_dump ($v); echo '</pre>';
            $ret[$k][$kv] =$v;
        }
    }
    //echo '<pre style="color:white;background:green">'; var_dump ($ret); echo '</pre>';
    return $ret;
}

function css_keyframes_to_array ($cssContent) {
    $ret = [];

    $c = explode ("\n", $cssContent);
    //echo '<pre style="color:white;background:green">'; var_dump ($c); echo '</pre>';
    foreach ($c as $lineIdx => $lc) {
        if (strpos($lc,'%')===false && strpos($lc, '{')!==false) {
            $k = trim(explode('{',$lc)[0]);
            //echo '<pre style="color:cyan;background:green">'; var_dump ($k); echo '</pre>';
            $ret[$k] = [];
        }
        if (strpos($lc, '%')!==false) {
            $pv = trim (explode('%',$lc)[0]);
            //echo '<pre style="color:yellow;background:darkgreen">'; var_dump ($pv); echo '</pre>';
            $v = trim (explode('{',$lc)[1]);
            $v = str_replace ('}','',$v);
            //echo '<pre style="color:white;background:darkgreen">'; var_dump ($v); echo '</pre>';
            $ret[$k][$pv.'%'] =[];
        }
        if (strpos($lc, ':')!==false) {
            $kv = trim (explode(':',$lc)[0]);
            $kv1 = explode('-', $kv);
            if (count($kv1)===1) {
                $kv = $kv;
            } else {
                $kv = $kv1[0].ucfirst($kv1[1]);
            };
            //echo '<pre style="color:white;background:green">'; var_dump ($kv); echo '</pre>';
            $v = trim (explode(':',$lc)[1]);
            $v = str_replace (';','',$v);
            //echo '<pre style="color:black;background:green">'; var_dump ($v); echo '</pre>';
            $ret[$k][$pv.'%'][$kv] =$v;
        }
    }
    //echo '<pre style="color:white;background:green">'; var_dump ($ret); echo '</pre>';
    return $ret;
}

function css_animation_template_to_animation ($theme, $anim, $selectors, $searchReplace) {
    $t = $theme; $a = $anim; $s = $selectors; $sr = $searchReplace; $debug = false;
    if ($debug) { echo '<pre style="background:navy;color:grey;">'; var_dump ($sr); echo '</pre>'; }
    foreach ($s as $i => &$rawSel) {
        $selFinal = '@keyframes '.$rawSel.'__'.$theme;
        if ($debug) { echo '<span style="background:blue;color:white;">'.$selFinal.'</span><br/>'; }
        foreach ($a as $j => &$rawA) {
            if ($j==$selFinal) {
                if ($debug) { echo '<pre style="background:navy;color:yellow;">'; var_dump ($rawA); echo '</pre>'; }
                foreach ($rawA as $k => &$rawAss) { // rawAss = raw animation stop settings. :D
                    foreach ($sr as $l => &$rawSR) {
                        if ($k === $l) {
                            // have reached an animation stop that needs changing
                            foreach ($rawSR as $m => &$rawPS) { //rawPS = raw CSS property settings
                                foreach ($rawAss as $n => &$rawPS2) {
                                    if ($m === $n) {
                                        if ($debug) {
                                            echo '<pre style="background:green;color:yellow;">'; var_dump ($rawPS); echo '</pre>';
                                            echo '<pre style="background:darkgreen;color:lime;">'; var_dump ($rawAss); echo '</pre>';
                                            echo '<pre style="background:darkgreen;color:white;">'; var_dump ($rawPS2); echo '</pre>';
                                        }
                                        foreach ($rawPS as $o => &$sre) { // sre = search-replace entry
                                            if ($debug) {
                                                echo '<pre style="background:red;color:white;">'; var_dump ($rawPS2); echo '</pre>';
                                                echo '<pre style="background:red;color:yellow;">'; var_dump (preg_replace ($sre['search'], $sre['replace'], $rawPS2)); echo '</pre>';
                                            }
                                            $a[$j][$k][$n] = preg_replace ($sre['search'], $sre['replace'], $rawPS2);

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    unset ($rawSel); unset ($rawA); unset ($rawAss); unset ($rawSR); unset ($rawPS); unset ($rawPS2); unset ($sre);
    if ($debug) { echo '<pre style="background : blue; color : yellow;">'; var_dump ($a); echo '</pre>'; }
    return $a;
}

function css_animation_array_to_css ($anim, $indent=0) {
    $css = '';
    $prefix = str_repeat('  ', $indent);

    foreach ($anim as $keyFrameID => $kf) {
        $css .= $prefix . "$keyFrameID {\n";
        $css .= $prefix . css_array_to_css($kf, $indent + 1);
        $css .= $prefix . "}\n";
    }

    return $css;
}

function css_animation_keys_to_css ($theme, $keys, $indent=0) {
    $css = '';
    $prefix = str_repeat('  ', $indent);
    $prefix2 = str_repeat('  ', $indent+1);
    foreach ($keys as $k => $v) {
            $css .= $prefix.$k." {\n";
            $css .= $prefix2."animation : ".$v.'__'.$theme." 1s forwards;\n";
            $css .= $prefix."}\n";
    }
    return $css;
}


function naWebOS_photoAlbum_countFiles ($jobs) {
    $r = 0;
    foreach ($jobs as $jobIdx => $job) {
        $root = $job['path'];
        $thumbsPath = $job['thumbnails'];
        $delThumbs = $job['delThumbs'];

        if (file_exists($root)) {
            $files = getFilePathList ($root, true, FILE_FORMATS_photos, null, ['file']);

            $files3 = [];
            foreach ($files as $idx => $file) {
                if (strpos($file,'/thumbs/thumbs')!==false) {
                    $pi = pathinfo($file);
                    $xec = 'rm -rf "'.$pi['dirname'].'"';
                    exec ($xec, $output, $result);
                    continue;
                }
                if (strpos($file,'/thumbs')===false) {
                    $files3[] = $file;
                }
            }

            $r += count($files3);
        }
    }
    return $r;
}

function naWebOS_photoAlbum_resizeFiles ($totalFileCount, $totalJobsCount, $jobsDoneCount, $jobIdx, $job) {
    global $filePerms_ownerUser;
    global $filePerms_ownerGroup;
    global $filePerms_perms_publicWriteableExecutable;
    global $filePerms_perms_readonly;
    global $filePerms_perms_readWrite;
    //var_dump($job); echo PHP_EOL; die();

    $root = $job['path'];
    $thumbsPath = $job['thumbnails'];
    $delThumbs = $job['delThumbs'];
    $arguments = $job['arguments'];
    $excl = '/(?!.*thumbs).*/'; // exclude anything that includes 'thumbs' in it's filepath.
    $excl2 = null;


    //var_dump ($files); die();
    $files3 = [];

    $msgJobs = ($jobsDoneCount+1).'of'.$totalJobsCount;
    $fncn = 'naWebOS_photoAlbum_convert() job '.$msgJobs.' :: ';
    echo $fncn.'Figuring out which files to convert.'.PHP_EOL;

    if ($delThumbs) {
        $files = getFilePathList ($root, true, FILE_FORMATS_photos, $excl2, ['file']);
        foreach ($files as $idx => $file) {
            if (strpos($file,'/thumbs')!==false) {
                $pi = pathinfo($file);
                $xec = 'rm -rf "'.dirname($pi['dirname']).'"';
                exec ($xec, $output, $result);
            }
        }
        exit();
    } else {
        $files = getFilePathList ($root, true, FILE_FORMATS_photos, $excl, ['file']);
    }

    foreach ($files as $idx => $file) {
        if (strpos($file,'/thumbs/thumbs')!==false) {
            $pi = pathinfo($file);
            $xec = 'rm -rf "'.$pi['dirname'].'"';
            exec ($xec, $output, $result);
            continue;
        }
        if (strpos($file,'/thumbs')===false) {
            $f = dirname($file).'/thumbs/'.basename($file);
            //echo 't23:'.$f.PHP_EOL;
            $found = false;
            foreach ($files as $idx2=>$file2) {
                if ($f===$file2) $found = true;
            }
            if (!$found) $files3[] = $file;
        }
    }

    global $filePerms_ownerUser;
    global $filePerms_ownerGroup;
    global $filePerms_perms;

    $sizeIndex = ['__root__'=>$root];
    foreach ($files3 as $idx => $file) {
        try {
            $original_info = getimagesize($file);
            $original_w = $original_info[0];
            $original_h = $original_info[1];

            $sizeIndex[str_replace($root,'',$file)] = [$original_w,$original_h];
        } catch (Throwable $e) {
            echo $fncn.$t->getMessage().'.'.PHP_EOL;
            continue;
        } catch (Exception $e) {
            echo $fncn.$t->getMessage().'.'.PHP_EOL;
            continue;
        }
        //var_dump ($original_info); die();

        // my (and the end-user's) thanks go to https://ansi.gabebanks.net/.
        $cEnd = '';
        $cHL = ''; //colorsHighlighted
        $cEnd = "\x1b[39;49m"; // back to default colors
        $cMsgCat = ""; // message category colors
        if ($original_w > 7000) {
            $cHL = "\x1b[32;49m"; // green
        } elseif ($original_w > 5000) {
            $cHL = "\x1b[36;49m"; // cyan
        } elseif ($original_w > 3700) {
            $cHL = "\x1b[34;49m"; // blue
        } elseif ($original_w > 1000) {
            $cHL = "\x1b[33;49m"; // yellow
        }

        $w1 = '(w='.$cHL.$original_w.$cEnd.',h='.$cHL.$original_h.$cEnd.')';
        $msg = $fncn.$cMsgCat.'NOW RESIZING, $thumbsPath="'.$thumbsPath.'", $file="'.$file.'", from '.$w1.$cMsgCat.' to ';
        echo $msg;

        $didAny = false;

        $msgJobs = ($jobsDoneCount+1).'of'.$totalJobsCount;
        $fncn = 'naWebOS_photoAlbum_convert() job '.$msgJobs.', fileCount='.count($files3).', fileIdx='.$idx.' : ';

        $tp = $thumbsPath;
        $tp = str_replace('./','',$tp);
        $tp = str_replace('/$filename.$ext','',$tp);

        $pi3 = pathinfo($file);
        $file2 = $pi3['dirname'].'/'.$tp.'/300/'.$pi3['basename'];
        $x1 = createDirectoryStructure (dirname($file2), $filePerms_ownerUser, $filePerms_ownerGroup, $filePerms_perms_publicWriteableExecutable);

        $file3 = $pi3['dirname'].'/'.$tp.'/651/'.$pi3['basename'];
        $x2 = createDirectoryStructure (dirname($file3), $filePerms_ownerUser, $filePerms_ownerGroup, $filePerms_perms_publicWriteableExecutable);

        $file4 = $pi3['dirname'].'/'.$tp.'/1920/'.$pi3['basename'];
        $x3 = createDirectoryStructure (dirname($file4), $filePerms_ownerUser, $filePerms_ownerGroup, $filePerms_perms_publicWriteableExecutable);

        $file5 = $pi3['dirname'].'/'.$tp.'/3840/'.$pi3['basename'];
        $x4 = createDirectoryStructure (dirname($file5), $filePerms_ownerUser, $filePerms_ownerGroup, $filePerms_perms_publicWriteableExecutable);

        $dbg = [
            'x1' => $x1,
            'x2' => $x2,
            'x3' => $x3
        ];
        //var_dump ($dbg);

        try {
            $original_img = null;

            if (!file_exists($file2)) {
                if (is_null($original_img)) $original_img = imagecreatefromjpeg($file);
                $thumb_w = 300;
                $thumb_h = round(($original_h * $thumb_w)/$original_w);
                $thumb_img = imagecreatetruecolor($thumb_w, $thumb_h);
                if (imagecopyresampled($thumb_img, $original_img,
                                0, 0,
                                0, 0,
                                $thumb_w, $thumb_h,
                                $original_w, $original_h)
                ) {;
                    imagejpeg($thumb_img, $file2);
                    imagedestroy($thumb_img);
                    imagedestroy($original_img);

                    $w1 = '(w='.$cHL.$original_w.$cEnd.',h='.$cHL.$original_h.$cEnd.')';
                    $w2 = '(w='.$cHL.$thumb_w.$cEnd.',h='.$cHL.$thumb_h.$cEnd.')';
                    $msg = $fncn.$cMsgCat.'FILE RESIZED, $thumbsPath="'.$thumbsPath.'", from '.$w1.$cMsgCat.' to '.$w2.$cMsgCat.', '.$cEnd.'$file="'.$file.'"'.PHP_EOL;

                    $msg = $w2.' ';
                    echo $msg;
                } else {
                    $msg = $fncn.PHP_EOL.'File "'.$file2.'" could not be created.'.PHP_EOL;
                    echo $msg;
                }
                $didAny = true;
            }

            if (!file_exists($file3)) {
                if (is_null($original_img)) $original_img = imagecreatefromjpeg($file);
                $thumb_w = 651;
                $thumb_h = round(($original_h * $thumb_w)/$original_w);
                $thumb_img = imagecreatetruecolor($thumb_w, $thumb_h);
                if (imagecopyresampled($thumb_img, $original_img,
                                0, 0,
                                0, 0,
                                $thumb_w, $thumb_h,
                                $original_w, $original_h)
                ) {;
                    imagejpeg($thumb_img, $file3);
                    imagedestroy($thumb_img);
                    imagedestroy($original_img);
                    $w1 = '(w='.$cHL.$original_w.$cEnd.',h='.$cHL.$original_h.$cEnd.')';
                    $w2 = '(w='.$cHL.$thumb_w.$cEnd.',h='.$cHL.$thumb_h.$cEnd.')';
                    $msg = $fncn.$cMsgCat.'FILE RESIZED, $thumbsPath="'.$thumbsPath.'", from '.$w1.$cMsgCat.' to '.$w2.$cMsgCat.', '.$cEnd.'$file="'.$file.'"'.PHP_EOL;

                    $msg = $w2.' ';
                    echo $msg;
                } else {
                    $msg = $fncn.PHP_EOL.'File "'.$file3.'" could not be created.'.PHP_EOL;
                    echo $msg;
                }
                $didAny = true;
            }

            if ($original_w > 2200 && !file_exists($file4)) {
                if (is_null($original_img)) $original_img = imagecreatefromjpeg($file);
                $thumb_w = 1920;
                $thumb_h = round(($original_h * $thumb_w)/$original_w);
                $thumb_img = imagecreatetruecolor($thumb_w, $thumb_h);
                if (imagecopyresampled($thumb_img, $original_img,
                                0, 0,
                                0, 0,
                                $thumb_w, $thumb_h,
                                $original_w, $original_h)
                ) {;
                    imagejpeg($thumb_img, $file4);
                    imagedestroy($thumb_img);
                    imagedestroy($original_img);
                    $w1 = '(w='.$cHL.$original_w.$cEnd.',h='.$cHL.$original_h.$cEnd.')';
                    $w2 = '(w='.$cHL.$thumb_w.$cEnd.',h='.$cHL.$thumb_h.$cEnd.')';
                    $msg = $fncn.$cMsgCat.'FILE RESIZED, $thumbsPath="'.$thumbsPath.'", from '.$w1.$cMsgCat.' to '.$w2.$cMsgCat.', '.$cEnd.'$file="'.$file.'"'.PHP_EOL;

                    $msg = $w2.' ';
                    echo $msg;
                } else {
                    $msg = $fncn.PHP_EOL.'File "'.$file4.'" could not be created.'.PHP_EOL;
                    echo $msg;
                }
                $didAny = true;
            }

            if ($original_w > 4400 && !file_exists($file5)) {
                if (is_null($original_img)) $original_img = imagecreatefromjpeg($file);
                $thumb_w = 3840;
                $thumb_h = round(($original_h * $thumb_w)/$original_w);
                $thumb_img = imagecreatetruecolor($thumb_w, $thumb_h);
                if (imagecopyresampled($thumb_img, $original_img,
                                0, 0,
                                0, 0,
                                $thumb_w, $thumb_h,
                                $original_w, $original_h)
                ) {;
                    imagejpeg($thumb_img, $file5);
                    imagedestroy($thumb_img);
                    imagedestroy($original_img);

                    $w1 = '(w='.$cHL.$original_w.$cEnd.',h='.$cHL.$original_h.$cEnd.')';
                    $w2 = '(w='.$cHL.$thumb_w.$cEnd.',h='.$cHL.$thumb_h.$cEnd.')';
                    $msg = $fncn.$cMsgCat.'FILE RESIZED, $thumbsPath="'.$thumbsPath.'", from '.$w1.$cMsgCat.' to '.$w2.$cMsgCat.', '.$cEnd.'$file="'.$file.'"'.PHP_EOL;

                    $msg = $w2.' ';
                    echo $msg;
                } else {
                    $msg = $fncn.PHP_EOL.'File "'.$file5.'" could not be created.'.PHP_EOL;
                    echo $msg;
                }
                $didAny = true;
            }

            if (!$didAny) echo '(no resizings were necessary)';
            echo PHP_EOL;

            if ($didAny) sleep (2);

        } catch (Throwable $t) {
            echo $fncn.$t->getMessage().'.'.PHP_EOL;
        } catch (Exception $e) {
            echo $fncn.$e->getMessage().'.'.PHP_EOL;
        }


        /*
        if ($idx/13 === round($idx/13)) {
            echo '13 files done, sleeping for 5 seconds.'.PHP_EOL;
            sleep (5);
        }

        $xec = 'mogrify -set comment \'File checked by mogrify.\' "'.$file.'" 2>&1';
        exec ($xec, $output, $result1);

        $xec = 'convert "'.$file.'" -resize 200 "'.$file2.'" 2>&1';
        exec ($xec, $output, $result);

        $result = $result1.$result;
//var_dump ($output); die();
        if (
            (
                $result === 0
                ||
                $result === '00'
            )
            && (
                is_array($output)
                && count($output)===0
            )
        ) {
            $dbg = [
                'idx' => $idx,
                'count' => count($files3),
                'xec' => $xec,
                'output' => $output,
                'result' => $result
            ];
            $msg = $fncn.'Succeeded.'.PHP_EOL;
            echo $msg;
            //var_dump ($dbg);
        } else {
            echo $fncn.'CORRUPTED FILE - DELETING ORIGINAL *AND* THUMBNAIL.'.PHP_EOL;
            $dbg = [
                'idx' => $idx,
                'count' => count($files3),
                'xec' => $xec,
                'output' => $output,
                'result' => $result
            ];
            var_dump ($dbg); echo PHP_EOL;

            $xec = 'rm "'.$file.'"';
            echo $xec.PHP_EOL;
            //exec ($xec, $output, $result);

            $xec = 'rm "'.$file2.'"';
            echo $xec.PHP_EOL;
            //exec ($xec, $output, $result);
        }
        /* waste of time :
        $xec = 'identify -verbose "'.$file.'" 2>&1 | grep "corrupt image"';
        exec ($xec, $output, $result);
        if (count($output)>0) {
            echo 'CORRUPTED FILE "'.$file.'" - DELETING ORIGINAL *AND* THUMBNAIL.'.PHP_EOL;

            $xec = 'rm "'.$file.'"';
            exec ($xec, $output, $result);

            $xec = 'rm "'.$file2.'"';
            exec ($xec, $output, $result);
        }
        */
    }

    file_put_contents ($root.'/sizeIndex.json', json_encode($sizeIndex,JSON_PRETTY_PRINT));

    return count($files);
}

function createDirectoryStructure ($filepath, $ownerUser=null, $ownerGroup=null, $filePerms=null) {
$fncn = "createDirectoryStructure";
$debug = false;
/*	Creates a directory structure.
    Returns a boolean success value. False usually indicates illegal characters in the directories.

    If you supply a filename as part of $filepath, all directories for that filepath are created.
    If $filepath==only a directory, you TODO**MUST**TODO end $filepath with / or \
*/

    global $filePerms_ownerUser;
    global $filePerms_ownerGroup;
    global $filePerms_perms_publicWriteableExecutable;
    global $filePerms_perms_readonly;
    global $filePerms_perms_readWrite;

    if (is_null($ownerUser)) $ownerUser = $filePerms_ownerUser;
    if (is_null($ownerGroup)) $ownerGroup = $filePerms_ownerGroup;
    if (is_null($filePerms)) $filePerms = $filePerms_perms_readWrite;


    //slash-direction doesn't matter for PHP4 file functions :-), so we even things out first;
    $filepath = strtr (trim($filepath), "\\", "/");
    if ($filepath[strlen($filepath)-1]!="/") $filepath.="/";
    if ($filepath[0]!="/") $filepath="/".$filepath;
    if ($debug) { echo $fncn.'()'.PHP_EOL; echo '$filepath='; var_dump ($filepath); echo PHP_EOL.PHP_EOL; }

    if (($filepath[1]!=':') && ($filepath[0]!='/')) trigger_error ("$fncn: $filepath is not from the root. results would be unstable. gimme a filepath with / as first character.", E_USER_ERROR);

    $directories = explode ("/", $filepath);
    $i = count($directories)-1;
    $j = $i;
    while ($j > -1) {
        if ($directories[$j]==='') unset ($directories[$j]);
        $j--;
    };
    $result = true;
    if ($debug && false) { echo '1::$directories='; var_dump ($directories); echo PHP_EOL.PHP_EOL; }

    for ($i = count($directories); $i>0; $i--) {
        $pathToTest = '/'.implode ("/", array_slice($directories,0,$i+1));
        if ($debug) { echo '$pathToTest='; var_dump ($pathToTest); echo PHP_EOL.'file_exists($pathToTest)='; var_dump(file_exists($pathToTest)); echo PHP_EOL.PHP_EOL; }
        if (file_exists($pathToTest)) break;
    }

    $dbg = array (
        'ptt' => $pathToTest,
        'i' => $i,
        'dirs' => $directories//,
         //'backtrace' => debug_backtrace()
    );

    if ( ($i < count($directories)) ) {
        if ($debug) { var_dump ($dbg); echo PHP_EOL.PHP_EOL; }

        for ($j = $i; $j < (count($directories)); $j++) {
            $pathToCreate = '/'.implode ("/", array_slice($directories,0,$j+1));
            //var_dump ($pathToCreate);
            if (!file_exists($pathToCreate)) {
                //$filePerms = 0770; // dirty hack for said.by and the now more secure .../setPermissions.sh
                if ($debug) { echo 'p2='; var_dump ($pathToCreate); }
                $result=mkdir($pathToCreate,0770);//!is_null($filePerms)?$filePerms:0777);
                if (is_string($ownerUser)) $x = chown ($pathToCreate, $ownerUser);
                if (is_string($ownerGroup)) $y = chgrp ($pathToCreate, $ownerGroup);
                if (!is_null($filePerms)) $z = chmod ($pathToCreate, 0770);
                $dbg = [ '$result' => $result, 'chown' => $x, 'chgrp' => $y, 'chmod' => $z ];
                if ($debug) { echo '$dbg='; var_dump ($dbg); }

            }
        }
    }
    return true;
}

function getFilePathList (
//TODO: all features listed below $level are untested.

	//$pathStart,
	$path,								// current path
	$recursive = false,					// if true, we also process any subdirectory.
	$fileSpecRE = "/.*/",				// Regular Expression file specs - will be matched against any filename found.
	// ^-- this is NOT the same as normal "somefile-*.something.extension" type wildcards. see example above.
    $excludeFolders = null,
	$fileTypesFilter = array (),		// array (int=>string (filetype() result) ==== int=>"file"|"dir" )
	$depth = null,
	$level = 1,
	$returnRecursive = false,           // whether or not to return the filepaths found as a recursive array (true) or a flat list array (false).
	$ownerFilter = array (),			// array (int=>string (username) ); only return files owned by someone in $ownerFilter.
	$fileSizeMin = null,				// If >=0, any files returned must have a minimum size of $fileSizeMin bytes.
	$fileSizeMax = null,				// same as above, but maximum size

	/* all date parameters below must be provided in the mktime() format. */
	$aTimeMin = null,					// calls fileatime(). Read The Friendly Manual. http://www.php.net/manual/
	$aTimeMax = null,					//	^- access includes a program reading from this file.
	$mTimeMin = null,					// calls filemtime(). RTFM.
	$mTimeMax = null,
	$cTimeMin = null,					// calls filectime(). rtfm.
	$cTimeMax = null,
	/*	on windows XP, cTime = creation time; mTime = modified time; aTime = access time.
		I also noted some BUGS in retrieving these dates from my system.
	*/
	$listCall = ""						// interesting feature; lets you include results from any informational file function(s).
/*	TODO : fix $*Date* parameter handling,
	returns an array consisting of all files in a directory structure, filtered by the parameters given.
	results are returned in directory order. if ($recursive) then subdirectory content is listed before file content.
	OKAY, this one is monolithic :)   But very usefull, so an exception to the rule is granted here.
example:
	htmlDump (getFilePathList("c:/dat/web", true, "/.*\.php$|.*\.php\d$|.*\.inc$/",
		array(), array(), null, null, null, null, null, null, null, null,
		"\"ctime=\".date (\"Y/m/d H:m:s\", filectime (\$filepath)).".
		"\" - atime=\".date (\"Y/m/d H:m:s\", fileatime (\$filepath)).".
		"\" - mtime=\".date (\"Y/m/d H:m:s\", filemtime (\$filepath)).".
		";"
		));
	-== this returns an array with complete filepaths of all files under c:/dat/web, that have an extension like
		*.php, *.php3, *.php4 or *.inc.
		for my system, it returns:
			array(4) {
			  [0]=>
			  string(115) "c:/dat/web/index.php - [listCall=ctime=2003/05/11 18:05:26 - atime=2003/05/16 05:05:44 - mtime=2003/05/16 05:05:44]"
			  [1]=>
			  string(122) "c:/dat/web/preProcessor.php - [listCall=ctime=2003/05/15 16:05:55 - atime=2003/05/16 04:05:47 - mtime=2003/05/15 17:05:35]"
			  [2]=>
			  string(116) "c:/dat/web/source.php - [listCall=ctime=2003/05/11 18:05:26 - atime=2003/05/16 04:05:47 - mtime=2003/04/28 13:04:07]"
			  [3]=>
			  string(117) "c:/dat/web/sources.php - [listCall=ctime=2003/05/11 18:05:26 - atime=2003/05/16 04:05:50 - mtime=2003/05/12 00:05:22]"
}
		in this example, the $listCall is kinda complicated. but only to show it's power.
		if you're having trouble debugging your $listCall, turn on the relevant htmlDump() call in this function.

another example:
	htmlDump (getFilePathList("c:/dat/web", false, "/.*\.php$|.*\.php\d$|.*\.inc$/",
		array(), array(), null, null, null, null, null, time()-mktime (0,0,0,0,1,0));
	-== this returns, for my system, all *.php,*.php3/4,*.inc files in c:/dat/web, that havent changed since 24 hours ago:
*/

) {
    $fncn = '.../NicerAppWebOS/functions.php/getFilePathList()';
    $debug = false;

	//if (stripos($path, $pathStart)!==false) {
		//echo '<pre style="color:cyan;">'; var_dump ($path); echo '</pre>'; exit();
		if (!realpath($path)) trigger_error ($fncn.' : FATAL ERROR : "'.$path.'" does not exist.', E_USER_ERROR);
		$path = realpath($path);

		if (!is_null($excludeFolders)) {
            preg_match_all($excludeFolders, $path, $ms);
            if ($debug) {
                echo '<pre>';
                //var_dump (debug_backtrace()); echo PHP_EOL;
                var_dump ($path); echo PHP_EOL;
                var_dump ($excludeFolders); echo PHP_EOL;
                var_dump($ms);//exit();
                echo '</pre>';
            }
        }

        $result = array();
		if (is_null($excludeFolders) || (
            is_array($ms)
            && is_array($ms[0])
            && count($ms[0]) === 2
            && $ms[0][0] == $path
            && $ms[0][1] == ''
		)) {
            //if (!in_array("file",$fileTypesFilter)) $fileTypesFilter[count($fileTypesFilter)]="file";
            //htmlOut (" --== $path ==--");
            if ($path[strlen($path)-1]!="/") $path.="/";
            //echo $path.'<br/>';
            if ($handle = opendir($path)) {
                /* This is the correct way to loop over the directory. */
                while (false !== ($file = readdir($handle))) {
                //if (!is_file($path.$file)) continue;
                    if ($file != "." && $file != "..") {

                        $pass = true;
                        //echo $path.$file.'<br/>';
                        $ft = filetype($path.$file);
                        if (!in_array ($ft, $fileTypesFilter)) $pass = false;
                        // htmlDump ($ft, "filesys");
                        if ($ft=="dir") $filepath = $path.$file."/"; else $filepath = $path.$file;

                        //echo '<pre>';
                        //var_dump ($file); echo PHP_EOL;
                        //var_dump ($fileSpecRE); echo PHP_EOL;
                        if ($pass) $pass = preg_match ($fileSpecRE, strToLower($file))!==0;
                        //var_dump ($pass); echo PHP_EOL;
                        //echo '</pre>';
                        if ($pass && count($ownerFilter)>0) {
                            $fo = fileowner ($filepath);
                            if ($fo!=false) {
                                $fo = posix_getpwuid($fo);
                                if (!in_array ($fo, $ownerFilter)) $pass=false;
                            } else {
                            //couldn't retrieve username. be strict & safe, fail.
                                $pass = false;
                            }
                        }
                        if ($pass && isset($fileSizeMin)) if (filesize ($filepath) < $fileSizeMin) $pass=false;
                        if ($pass && isset($fileSizeMax)) if (filesize ($filepath) > $fileSizeMax) $pass=false;

                        if ($pass && isset($aTimeMin))
                            $pass=evalDate ("fileatime", $filepath, ">=", $aTimeMin, "aTimeMin");
                        if ($pass==true && isset($aTimeMax))
                        //	^- if ($stringValue) == always true!,
                        //		so explicitly check for boolean true result after calling
                        //		functions that may return an (error) string.
                            $pass=evalDate ("fileatime", $filepath, "<=", $aTimeMax, "aTimeMax");
                        if ($pass==true && isset($mTimeMin))
                            $pass=evalDate ("filemtime", $filepath, ">=", $mTimeMin, "mTimeMin");
                        if ($pass==true && isset($mTimeMax))
                            $pass=evalDate ("filemtime", $filepath, "<=", $mTimeMax, "mTimeMax");
                        if ($pass==true && isset($cTimeMin))
                            $pass=evalDate ("filectime", $filepath, ">=", $cTimeMin, "cTimeMin");
                        if ($pass==true && isset($cTimeMax))
                            $pass=evalDate ("filectime", $filepath, "<=", $cTimeMax, "cTimeMax");

                        $r = "";
                        if ($pass==true) {
                            //htmlOut ("PASSED");

                            $ev = "\$r = $listCall";
                            //htmlDump ($ev);
                            if (!empty($listCall)) eval ($ev);
                            $idx = count ($result);
                            if (!empty($r)) $r = " - [listCall=$r]";
                            if (!$returnRecursive) {
                                $result[$idx] = $filepath.$r;
                            } else {
                                $result[$idx] = basename($filepath.$r);
                            }
                        }
                        if (is_string($pass)) {
                            //htmlOut ("PASSED - checks failed");
                            $result[count($result)] = "[$pass]".$filepath;
                        }

                        if ($recursive && $ft=="dir" && (is_null($depth) || $level<$depth)) {
                            $subdir = @getFilePathList ($filepath,$recursive, $fileSpecRE, $excludeFolders,
                                $fileTypesFilter, $depth, $level+1, $returnRecursive, $ownerFilter, $fileSizeMin, $fileSizeMax,
                                $aTimeMin, $aTimeMax, $mTimeMin, $mTimeMax,
                                $cTimeMin, $cTimeMax, $listCall);
                            if (!$returnRecursive) {
                                if (!is_null($subdir)) array_splice ($result, count($result)+1, 0, $subdir);
                            } else {
                                if (!is_null($subdir)) $result[basename($filepath.$r)] = $subdir;
                            }
                        }
                    } // !dot-files ('.' && '..', current & parent path on OS commandline)
                } //!preg_match($excludeFolders, $path)
			}
		}
		//htmlDump ($result, "result");
		if ($debug) { echo '<pre style="color:purple">'; var_dump ($result); echo '</pre>'; };
		return $result;
	//}
	//$result = array();
	//return $result;
}



function addThumbsToFolder ($folder) {
    $files = getFilePathList ($root, true, '/.*\.gif|.*\.jpg|.*\.jpeg|.*\.png/', array('file'));
    sort ($files);
    //echo '<pre style="color:orange;">'; var_dump ($files); echo '</pre>';
    ob_start();

    foreach ($files as $idx => $original) {
        if ($verbose) {
            echo '<p style="color:green;">'.$idx.' of '.count($files).' : '.$original.'</p>';
        }
        $thumb = str_replace(basename($original), 'thumbs/'.$original, $original);
        createDirectoryStructure (dirname($thumb));
        if (!file_exists($thumb)) {
            $xec = 'convert "'.$original.'" -resize 200 "'.$thumb.'"';
            exec ($xec, $output, $result);
            if ($showOutput) {
                $dbg = array (
                    'idx' => $idx,
                    'count' => count($files),
                    'exec' => $xec,
                    'output' => $output,
                    'result' => $result
                );
                echo '<pre>';var_dump($dbg); echo '</pre>';
            }
            ?>
            <script type="text/javascript">
                document.scrollTop = 999999999999;
            </script>
            <?php
            ob_flush();
            ob_end_flush();
            flush();
            ob_start();
        }
        //exit();
    }
}








function walkArray (&$a, $keyCallback=null, $valueCallback=null, $callKeyForValues=false, $callbackParams=null, $k='', $level=0, $path='') {
// usage : walkArray ($someRecursiveArray, 'walkArray_printKey', 'walkArray_printValue');
// can handle recursive arrays. a nested array is a recursive array.
// is faster, especially on large arrays, than RecuriveArrayIterator, see speed testing comment at http://php.net/manual/en/class.recursiveiteratoriterator.php
// provides detailed information to callbacks on where in the data we are, something that array_walk_recursive just doesnt do.
// passes data around as pointers, not copies of data.
    if (is_numeric($k)) $k = intval($k);
    if (!is_array($a)) {
        trigger_error ('walkArray() was called but $a parameter passed is not an array.', E_USER_ERROR);
        return false;
    } else {
        foreach ($a as $k=>&$v) {
            $cd = array ( // callback data
                'type' => 'key',
                'path' => $path,
                'level' => $level,
                'k' => &$k,
                'v' => &$v,
                'params' => &$callbackParams
            );
            //$cd['params']['a'] = &$a;

            if (is_string($keyCallback) && ($callKeyForValues || is_array($v)))
                call_user_func ($keyCallback, $cd);

            if (is_array ($v)) {
                walkArray ($a[$k], $keyCallback, $valueCallback, $callKeyForValues, $callbackParams, $k, $level+1, $path.'/'.$k);
            } else {
                $cd['type'] = 'value';
                if (is_string($valueCallback)) call_user_func ($valueCallback, $cd);
            }
        }
    }
    $r = true;
    return goodResult($r);
}


function walkArray_printKey ($cd) {
    echo '<div style="background:blue;color:yellow;border-radius:5px;padding:2px;margin-top:5px;">'.PHP_EOL;
    $indent = 20 * $cd['level'];
    echo '<div style="padding-left:'.$indent.'px">'.PHP_EOL;
    echo 'key : '.$cd['k'].'<br/>'.PHP_EOL;
    echo 'path : '.$cd['path'].'<br/>'.PHP_EOL;
    echo '</div>'.PHP_EOL;
    echo '</div>'.PHP_EOL;
}

function walkArray_printValue ($cd) {
    echo '<pre style="background:green;color:white;border-radius:5px;padding:2px;margin-top:2px;">'.PHP_EOL;
    $indent = 20 * $cd['level'];
    echo '<div style="padding-left:'.$indent.'px">'.PHP_EOL;
    echo 'key : '.$cd['k'].'<br/>'.PHP_EOL;
    echo 'path : '.$cd['path'].'<br/>'.PHP_EOL;
    echo 'value : '.$cd['v'].'<br/>'.PHP_EOL;
    echo '</div>'.PHP_EOL;
    echo '</pre>'.PHP_EOL;
}


function &chaseToPath (&$wm, $path, $create=false, $targetData=false) {
    //var_dump ($create); exit();
    //echo '$wm=<pre>'; var_dump ($wm);echo '</pre>'; //exit();
    //$path = str_replace ('/', '/d/', $path);
    //$path .= '/d';
    $nodes = explode ('/', $path);
    foreach ($nodes as $idx=>$node) {
        if (is_numeric($node) && is_string($node)) {
            if (strpos($node,'.')===false) {
                $nodes[$idx] = (int)$node;
            } else {
                $nodes[$idx] = (float)$node;
            }
        }
    }
    $chase = &chase ($wm, $nodes, $create, $targetData);

    if (false) {
        //echo '$wm=<pre>'; var_dump ($wm);echo '</pre>'; exit();
        $dbg = array (
            '$path' => $path,
            '$nodes' => $nodes,
            '$wm' => $wm,
            '$chase' => $chase
        );
        echo '$dbg=<pre style="background:red;color:yellow;">'; var_dump ($dbg); echo '</pre>'.PHP_EOL.PHP_EOL;
        //exit();
    }



    $false = false;
    if (good($chase)) {
        $arr = &result($chase);
        return $arr;
    } else return $false;
}

function &chase (&$arr, $indexes, $create=false, $targetData=false) {
    if (false) {
        echo 'nicerapp/functions.php --- $arr=<pre>'; var_dump ($arr); echo '</pre>';
        echo 'nicerapp/functions.php --- $indexes=<pre>'; var_dump ($indexes); echo '</pre>';
        echo 'nicerapp/functions.php --- $create=<pre>'; var_dump ($create); echo '</pre>';
        echo 'nicerapp/functions.php --- $targetData=<pre>'; var_dump ($targetData); echo '</pre>';
    }
	$r = &$arr;
	foreach ($indexes as $idx) {
           // echo 'sitewide/functions.php --- $idx=<pre>'; var_dump ($idx); var_dump (array_key_exists($idx,$r)); var_dump ($r); echo '</pre>';
            if (
                    is_array($r)
                    && (
                            $create===true
                            || array_key_exists($idx,$r)
                    )
            ) {
                    if ($create===true && !array_key_exists($idx,$r)) $r[$idx]=array();
                    //echo 'sitewide/functions.php --- $idx=<pre>'; var_dump ($idx); echo '</pre>';
                    $r = &$r[$idx];
            } else {
                /*
                    $err = array(
                    'msg' => 'Could not walk the full tree',
                    'vars' => array(
                            '$idx--error'=>$idx,
                            '$indexes'=>$indexes,
                            '$arr'=>$arr
                            )
                    );
                    badResult (E_USER_NOTICE, $err);
                  */
                    $ret = false; // BUG #2 squashed
                    return $ret;
            }
	}
	if (is_array($targetData))
    foreach ($targetData as $k => $v) {
        //echo PHP_EOL.'$k='; var_dump($k); echo PHP_EOL;
        if (is_array($v) && $idx=='') {
            $r[$k] = $v;
        } else {
            $r[$k] = $v;
        }
    }

        //echo 'sitewide/functions.php --- $r=<pre>'; var_dump ($r); echo '</pre>';
	return goodResult($r);
}

function &chaseToReference (&$array, $path) {
	if (!empty($path)) {
		if (empty($array[$path[0]])) {
			$err = array(
				'msg' => 'Could not walk the full tree',
				'$path' => $path,
				'$array (possibly partially walked)' => $array
			);
			return badResult (E_USER_NOTICE, $err);
		} else return chaseToReference($array[$path[0]], array_slice($path, 1));
	} else {
		return goodResult($array);
	}
}

function good($r) {
	return (
		is_array($r)
		&& array_key_exists('result',$r)
	);
}

function &result(&$r) {
	return $r['result'];
}

function &resultArray (&$r) {
  $r2 = array();
  foreach ($r as $k => $v) {
    $r2[$k] = result($v);
  }
  return $r2;
}


function &goodResult(&$r) {
	$r2 = array (
		'isMetaForFunc' => true,
		'result' => &$r
	);
	return $r2;
}

function safeJSONload($filePath, $exampleFilepath='[NOT_SPECIFIED]') {
    $fncn = 'safeJSONload("'.$filePath.'")';
    if (!file_exists($filePath)) {
        trigger_error ($fncn.' : File "'.$filePath.'" does not exist. You might find an example file in "'.$exampleFilepath.'".', E_USER_WARNING);
        return false;
    }
    if (!is_readable($filePath)) {
        trigger_error ($fncn.' : file "'.$filePath.'" is not readable.', E_USER_WARNING);
        return false;
    }

    $fc = file_get_contents($filePath);
    if (!is_string($fc)) {
        trigger_error ($fncn.' : file "'.$filePath.'" does not contain a string.', E_USER_WARNING);
        return false;
    };

    $jsonArr = json_decode ($fc, true);
    if (json_last_error()!==0) {
        trigger_error ($fncn.' : JSON decoding of file "'.$filePath.'" resulted in PHP error code '.json_last_error().', error = '.json_last_error_msg(), E_USER_WARNING);
        return false;
    }
    return $jsonArr;
}

function NicerAppWebOS_jsonErrorHandler() {
// maybe i don't need to write this at all, ever.
}

function recrypt ($username, $plaintextPassword, $newHash_couchDB) {
    $debug = false;
    $baseDir = realpath(dirname(__FILE__).'/..').'/NicerAppWebOS/apps';
    $files = @getFilePathList ($baseDir, true, '/^recrypt.php$/', null, array('file'));
    if ($debug) {
        echo '<pre>';
        var_dump ($files);
    };

    foreach ($files as $idx => $filepath) {
        $relPath = str_replace($baseDir.'/','',$filepath);
        $relPathParts = explode (DIRECTORY_SEPARATOR, $relPath);
        $manufacturerName = recryptFunctionNameCompatibility ($relPathParts[0]);
        $viewName = recryptFunctionNameCompatibility ($relPathParts[1]);

        $funcName = $manufacturerName.'__'.$viewName;
        require_once ($filepath);

        //var_dump ($funcName);
        if (function_exists($funcName)) call_user_func ($funcName, $username, $plaintextPassword, $newHash_couchDB);
    }

}

function recryptFunctionNameCompatibility ($val) {
    $ret = str_replace('.','_',$val);
    return $ret;
}

?>
