<?php
require_once (realpath(dirname(__FILE__).'/../').'/boot.php');
global $naDebugAll;
$debug_naWebOS_traceroute_data_gathering = $dbgDG = true; //$naDebugAll;
global $dbgDG;
global $naWebOS;

$fn = realpath(dirname(__FILE__)).'/naWebOS_traceroute_data_gathering.css';
$fnWeb = $naWebOS->adjustPath($fn);
echo '<!DOCTYPE html>';
echo '<head>';
echo '<link type="text/css" src="'.$fnWeb.'?m='.$naWebOS->fileDateTimeStamp($fn).'">'.PHP_EOL;
echo '</head>';
echo '<body>';

naWebOS_gather_desktop_OS_info();
naWebOS_gather_traceroute_data();

function naWebOS_gather_traceroute_data () {
    $ctv = naWebOS_gather_traceroute_version();
    var_dump ($ctv);
}

function naWebOS_output_debug_info ($di) {
    global $dbgDG;
    if ($dbgDG) {
        echo '<pre class="naWebOS-debug-info '.$di['mainPreClassName'].'">'.PHP_EOL;
            echo
                '<span class="naWebOS-field-name">$xec</span>=<span class="naWebOS-field-value naWebOS_execcall_string">'
                .json_encode($di['execString'],JSON_PRETTY_PRINT).'</span>'.PHP_EOL;
            echo
                '<span class="naWebOS-field-name">$result_code</span>=<span class="naWebOS-field-value naWebOS_execcall_result_code">'
                .json_encode($di['result_code'],JSON_PRETTY_PRINT).'</span>'.PHP_EOL;
            echo
                '<span class="naWebOS-field-name">$output</span>=<span class="naWebOS-field-value naWebOS_execcall_output">'
                .json_encode($di['output'],JSON_PRETTY_PRINT).'</span>';PHP_EOL;
        echo '</pre>';
    }
}


function naWebOS_gather_desktop_OS_info() {
    global $dbgDG;
    $xec = 'hostnamectl';
    exec ($xec, $output, $result_code);
    $di = [
        'mainPreClassName' => 'naWebOS_desktopos_info',
        'execString' => $xec,
        'output' => $output,
        'result_code' => $result_code
    ];
    naWebOS_output_debug_info ($di);

    $output2 = preg_match ('/\s+\([a-z][A-Z[0-0]\):\s([a-z][A-Z[0-0]\)/)', $ouput);
    var_dump($output2);
}

function naWebOS_gather_traceroute_version () {
    $xec = 'traceroute --v';
    exec ($xec, $output, $result_code);
    $di = [
        'mainPreClassName' => 'naWebOS_traceroute_version',
        'execString' => $xec,
        'output' => $output,
        'result_code' => $result_code
    ];
    naWebOS_output_debug_info ($di);

    $expectedOutputs = [
        0    => [
            'traceroute (GNU inetutils) 2.5',
            'Copyright (C) 2023 Free Software Foundation, Inc.',
            'License GPLv3+: GNU GPL version 3 or later <https://gnu.org/licenses/gpl.html>.',
            'This is free software: you are free to change and redistribute it.',
            'There is NO WARRANTY, to the extent permitted by law.',
            '',
            'Written by Elian Gidoni.'
        ]
    ];

    $cr = false;
    foreach ($expectedOutputs as $k => $v) {
        if ($result_code === $k && join('<br/>>',$v) == join('<br/>>',$output)) $cr = true;
    }
    return $cr;
}

function naWebOS_gather_traceroute_data_for_VPN_incoming_connections () {

}

function naWebOS_gather_traceroute_data_for_regular_incoming_connections () {

}

function naWebOS_calculate_VPN_traceroute_averages_phase001 () {

}

function naWebOS_put_VPN_traceroute_activity_averages_into_DB_couchdb () {

}

function naWebOS_get_new_couchdb_IDs_for_VPN_traceroute_averages () {

}

?>
</body>
</html>
