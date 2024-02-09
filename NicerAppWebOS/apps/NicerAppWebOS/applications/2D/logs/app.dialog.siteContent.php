<?php
global $naWebOS;
global $naLAN;
if (!$naLAN) die('403 Forbidden.');
//echo '<pre style="color:yellow;background:rgba(0,0,50,0.5);border-radius:10px;margin:10px;">'; var_dump ($naWebOS->view); echo '</pre>';
foreach ($naWebOS->view as $appID => $appRec) break;
if ($appRec['page']=='index') {
    $db = $naWebOS->dbs->findConnection('couchdb');
    $cdb = $db->cdb;

    $debug = false;
    $dbName = $db->dataSetName('logentries');
    $cdb->setDatabase($dbName);

        // fetch dataRecord
        $findCommand2 = [
            'selector' => [
                's2' => [ '$gt' => 0 ],
                'isIndex' => true,
                'isBot' => false,
                'isLAN' => false
            ],
            'fields' => ['_id', 's2', 'isIndex', 'isBot', 'isLAN' ],
            'sort' => [
                [ 's2' => 'desc' ],
                [ 'isIndex' => 'desc' ],
                [ 'isBot' => 'desc' ],
                [ 'isLAN' => 'desc' ]
            ],
            'use_index' => $naWebOS->globals['cdbDesignDocs']['logentries_pageLoad']
        ];
        //echo '<pre style="padding:8px;border-radius:10px;background:rgba(255,255,255,0.5);color:green;">'; var_dump ($findCommand2); echo '</pre>';
    try {
        $call = $cdb->find ($findCommand2);
    } catch (Exception $e) {
        echo '<pre>app.dialog.siteContent.php::';var_dump ($cdb);echo '</pre>';

        $msg = $fncn.' FAILED (siteContent) while trying to find in \''.$dbName.'\' : '.$e->getMessage();
        //trigger_error ($msg, E_USER_ERROR);
        echo $msg;
        //return false;
        die();
    }



    //echo '<pre style="color:white;background:rgba(0,50,0,0.5);border-radius:10px;margin:10px;">'; var_dump($call); echo '</pre>';
    foreach ($call->body->docs as $docID => $doc) {
        //echo '<pre style="padding:5px;margin:8px;color:white;background:rgba(0,50,0,0.5);">'; var_dump ($doc); echo '</pre>';
        $call2 = $cdb->get($doc->_id);
        //echo $call2->body->entry->request->html;

        //echo '<pre style="color:white;background:rgba(0,50,0,0.5);border-radius:10px;padding:5px;margin:10px;">'; var_dump($call2->body); echo '</pre>';


        $marginLeft = 10;
        if (!$doc->isIndex) $marginLeft = 50;
        $docA = json_decode(json_encode($call2->body), true);

        $url = '';
        if (array_key_exists('request', $docA))
            $url = $docA['request']['$_SERVER']['REQUEST_URI'];
        if (array_key_exists('httpOpts', $docA))
            if (array_key_exists('ALL cURL fields', $docA['httpOpts']))
                $url = $docA['httpOpts']['ALL cURL fields']['CURLOPT_URL'];
            else
                $url = $docA['httpOpts']['CURLOPT_URL'];


        if (array_key_exists('request', $docA)) {
            $now = DateTime::createFromFormat('U', $call2->body->s1);
            $now2 = $now->format("Y-m-d H:i:s");

            echo '<div id="'.$doc->_id.'" i="'.$call2->body->i.'" style="margin:10px;margin-left:'.$marginLeft.'px" onclick="naLog.onclick_logEntry(event);">';
            echo '<h2><span class="datetimeAccurate">'.$now2.'</span> <span class="ip">'.$call2->body->ip.'</span> '.$url.'</h2>';
            //echo hmJSON ($docA['request'], 'Request response');
            echo '</div>';
        }


        $marginLeft = 50;
        $docB = json_decode(json_encode($call2->body), true);
        echo '<div style="margin-left:'.$marginLeft.'px">';
        echo '<h3><span class="datetimeAccurate">'.$now2.'</span> <span class="ip">'.$call2->body->ip.'</span> '.$docB['request']['$_SERVER']['REQUEST_URI'].'</h3>';
        if (array_key_exists('request', $docB)) echo hmJSON ($docB['request'], 'Request response');
        if (array_key_exists('httpOpts', $docB)) echo hmJSON ($docB['httpOpts'], 'HTTP options');
        if (array_key_exists('httpResponse', $docB)) echo hmJSON ($docB['httpResponse'], 'HTTP response');
        //else { echo '<pre>'; var_dump ($docB); echo '</pre>'; };
        echo '</div>';

    }
    $html = '';
    $html .= '<script type="text/javascript">setTimeout (function() {na.site.settings.current.running_loadTheme = false; na.site.settings.current.loadingApps = false; na.hms.startProcessing()}, 1500); na.site.transformLinks()</script>';
    echo $html;



}
//require_once(dirname(__FILE__).'/../../../../../logs.php');
?>
