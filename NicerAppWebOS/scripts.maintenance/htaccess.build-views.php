<?php
$fncn = 'htaccess.build-views.php';
$rootPath_2vuslwos = realpath(dirname(__FILE__).'/../..');
require_once ($rootPath_2vuslwos.'/NicerAppWebOS/boot.php');
global $filePerms_ownerUser;
global $filePerms_ownerGroup;
global $filePerms_perms_publicWriteableExecutable;
global $filePerms_perms_readonly;
global $naWebOS;

$dbs = [ 'views' => true ];
$naWebOS->dbsAdmin->createDatabases($dbs); // also empties database

$db = $naWebOS->dbsAdmin->findConnection('couchdb');
$cdb = $db->cdb;
$dataSetName1 = $db->dataSetName('views');
$dataSetName2 = $db->dataSetName('viewsIDs');
$cdb->setDatabase ($dataSetName1, false);

$fc = file_get_contents (dirname(__FILE__).'/.htaccess.build.part1.txt');
$fc .= PHP_EOL.PHP_EOL;

$lineEnding = ' [N]';


$fc .= 
    '<IfModule mod_rewrite.c>'.PHP_EOL
    .'# .../NicerAppWebOS/domainConfigs/nicer.app/mainmenu.items.php::$na_apps_structure as RewriteRules back into /*--NICERAPP_BASICS--*/'.PHP_EOL.PHP_EOL;

$fc2 = '"url","apps"'.PHP_EOL;

$counts = [];
    
global $naWebOS;
require_once ($rootPath_2vuslwos.'/NicerAppWebOS/domainConfigs/'.$naWebOS->domain.'/mainmenu.items.php');
$counts['.../NicerAppWebOS/domainConfigs/nicer.app/mainmenu.items.php'] = 0;
global $na_apps_structure;
$naURLs = array();
foreach ($na_apps_structure as $pageID => $pageStructure) {
//echo 'Added to .../.htaccess as RewriteRule : global $naURLs[\''.$pageID.'\'];'.PHP_EOL;
foreach ($pageStructure as $viewKeyID => $viewKeySettings) {
//var_dump ($viewKeyID); var_dump ($viewKeySettings);

foreach ($viewKeySettings as $softwareKey => $softwareKeySettings) {
//var_dump ($softwareKey, $softwareKeySettings);

foreach ($softwareKeySettings as $softKey => $softSettings) {
//var_dump ($softKey); var_dump($softSettings);

    if ($softKey==='misc') {
        $folder = $softSettings['folder'];
    }
    if ($softKey==='apps') {
        foreach ($softSettings as $viewFolderName => $viewSettings) {
            //$viewSettings['path'] = $folder;

            $id1 = randomString(50);
            $id2 = randomString(50);

            if ($viewFolderName=='meta') continue;

            if (

                !array_key_exists('SEO_value', $viewSettings)
                || (
                    (
                        is_string($viewSettings['SEO_value'])
                        && $viewSettings['SEO_value']===''
                    )
                    && (
                        !is_array($viewSettings['SEO_value'])
                    )
                )

            ) {
                $msg = $fncn.' : INVALID SEO_value ('.json_encode($softSettings).').';
                echo $msg;
            } else {
            
                $fsID = $folder.'/'.$viewFolderName;

                $asa = [$fsID=>$viewSettings];
                //echo '<pre style="color:green">'; var_dump ($viewSettings); die();

                $rec1 = [
                    '_id' => $id1
                ];
                unset ($asa[$fsID]['SEO_value']);
                $rec1['view'] = $asa;


                try {
                    $cdb->setDatabase($dataSetName1, false);
                    $cdb->post($rec1);
                } catch (Throwable $e) {
                    echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName1.'" : $e->getMessage()='.$e->getMessage();
                    exit();
                } catch (Exception $e) {
                    echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName1.'" : $e->getMessage()='.$e->getMessage();
                    exit();
                }

                if (is_string($viewSettings['SEO_value'])) {
                    $rec2 = [
                        '_id' => $id2,
                        'seo_value' => $viewSettings['SEO_value'],
                        'viewID' => $id1
                    ];
                    try {
                        $cdb->setDatabase($dataSetName2, false);
                        $cdb->post($rec2);
                    } catch (Throwable $e) {
                        echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
                        exit();
                    } catch (Exception $e) {
                        echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
                        exit();
                    }
                } elseif (is_array($viewSettings['SEO_value'])) {
                    foreach ($viewSettings['SEO_value'] as $idx => $seoValue) {
                        $id2 = randomString(40);
                        $rec2 = [
                            '_id' => $id2,
                            'seo_value' => $seoValue,
                            'viewID' => $id1
                        ];
                        try {
                            $cdb->setDatabase($dataSetName2, false);
                            $cdb->post($rec2);
                        } catch (Throwable $e) {
                            echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
                            exit();
                        } catch (Exception $e) {
                            echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
                            exit();
                        }
                    }
                }



                $counts['.../NicerAppWebOS/domainConfigs/nicer.app/mainmenu.items.php']++;
            }
        }

    }
}
}
}
}

/*
$fn = $rootPath_2vuslwos.'/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/news/mainmenu.rewriteRules.htaccess.txt';
$fa = file_get_contents ($fn);
$counts['.../NicerAppWebOS/apps/NicerAppWebOS/applications/2D/news'] = substr_count ($fa, 'RewriteRule');
$fc .= $fa;

$fn = $rootPath_2vuslwos.'/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/news/mainmenu.reverseRewriteRulesCSVlines.csv';
$fa = file_get_contents ($fn);
$fc2 .= $fa;


$fc .= '</IfModule>'.PHP_EOL;


$fc .= PHP_EOL.PHP_EOL;
$fc .= file_get_contents (dirname(__FILE__).'/.htaccess.build.partLast.txt');
$fc .= PHP_EOL.PHP_EOL;
*/

$fn = $rootPath_2vuslwos.'/NicerAppWebOS/apps/NicerAppWebOS/applications/2D/news/mainmenu.reverseRewriteRulesCSVlines.csv';
$counts[$fn] = 0;
$f = fopen ($fn, 'r');
while (($data = fgetcsv($f, 10*1000, ',')) !== false) {
    $id1 = randomString(50);
    $id2 = randomString(50);
    $seo_value = substr($data[0], 1, strlen($data[0])-2);
    $viewSettings = json_decode(base64_decode_url($data[1]), true);

    //echo $seo_value."\n"; var_dump ($viewSettings); echo PHP_EOL;


    $rec1 = [
        '_id' => $id1,
        'view' => $viewSettings
    ];

    try {
        $cdb->setDatabase($dataSetName1, false);
        $cdb->post($rec1);
    } catch (Throwable $e) {
        echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName1.'" : $e->getMessage()='.$e->getMessage();
        exit();
    } catch (Exception $e) {
        echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName1.'" : $e->getMessage()='.$e->getMessage();
        exit();
    }

    if (!array_key_exists('SEO_value', $viewSettings)) {
        $rec2 = [
            '_id' => $id2,
            'seo_value' => $seo_value,
            'viewID' => $id1
        ];
        try {
            $cdb->setDatabase($dataSetName2, false);
            $cdb->post($rec2);
        } catch (Throwable $e) {
            echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
            exit();
        } catch (Exception $e) {
            echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
            exit();
        }
        $counts[$fn]++;

    } elseif (is_string($viewSettings['SEO_value'])) {
        $rec2 = [
            '_id' => $id2,
            'seo_value' => $viewSettings['SEO_value'],
            'viewID' => $id1
        ];
        try {
            $cdb->setDatabase($dataSetName2, false);
            $cdb->post($rec2);
        } catch (Throwable $e) {
            echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
            exit();
        } catch (Exception $e) {
            echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
            exit();
        }
        $counts[$fn]++;

    } elseif (is_array($viewSettings['SEO_value'])) {
        foreach ($viewSettings['SEO_value'] as $idx => $seoValue) {
            $id2 = randomString(40);
            $rec2 = [
                '_id' => $id2,
                'seo_value' => $seoValue,
                'viewID' => $id1
            ];
            try {
                $cdb->setDatabase($dataSetName2, false);
                $cdb->post($rec2);
            } catch (Throwable $e) {
                echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
                exit();
            } catch (Exception $e) {
                echo $fncn.' : FATAL ERROR : Could not add record to dataSet "'.$dataSetName2.'" : $e->getMessage()='.$e->getMessage();
                exit();
            }
            $counts[$fn]++;

        }
    }




}


echo 'RewriteRule entries added :'.PHP_EOL;
$totalCount = 0;
foreach ($counts as $countID => $count) {
    $totalCount = $totalCount + $count;
    echo $countID.' : '.$count.PHP_EOL;
}
echo 'Total : '.$totalCount.PHP_EOL;

//$bytes = file_put_contents (realpath(dirname(__FILE__).'/../..').'/.htaccess', $fc);
//echo $bytes.' bytes written to .../.htaccess and .../.htaccess-reverse'.PHP_EOL;
//$bytes = file_put_contents (realpath(dirname(__FILE__).'/../..').'/NicerAppWebOS/siteCache/mainmenu.reverse.csv', $fc2);
//echo $bytes.' bytes written to .../NicerAppWebOS/siteCache/mainmenu.reverse.csv'.PHP_EOL;



?>
