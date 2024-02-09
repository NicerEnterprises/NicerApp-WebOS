<?php
    require_once(dirname(__FILE__).'/../../boot.php');
    $yourLicenseKey = trim(file_get_contents(dirname(__FILE__).'/apiKey.txt'));
    
    $downloadsFolder = dirname(__FILE__).'/downloads/*';
    $exec = 'rm -rf "'.$downloadsFolder.'"';
    exec ($exec, $output, $result);    
    
    $url = 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key='.$yourLicenseKey.'&suffix=tar.gz';
    $fn = dirname(__FILE__).'/downloads/GeoLite2-City.tar.gz';
    file_put_contents ($fn, file_get_contents($url));
    $unzipFolder = dirname(__FILE__).'/downloads/GeoLite2-City/';
    $exec = 'tar -xvzf "'.$fn.'" -C "'.$unzipFolder.'"';
    exec ($exec, $output, $result);
    
    $files = getFilePathList ($unzipFolder, true, '/.*.mmdb/', null, array('file'), 3);
    $exec = 'mv "'.$files[0].'" "'.dirname(__FILE__).'"';
    exec ($exec, $output, $result);
    //var_dump ($files);
    
    $url = 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key='.$yourLicenseKey.'&suffix=tar.gz.sha256';
    $fn = dirname(__FILE__).'/downloads/GeoLite2-City.tar.gz.sha256';
    file_put_contents ($fn, file_get_contents($url));

    $url = 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-Country&license_key='.$yourLicenseKey.'&suffix=tar.gz';
    $fn = dirname(__FILE__).'/downloads/GeoLite2-Country.tar.gz';
    file_put_contents ($fn, file_get_contents($url));
    $unzipFolder = dirname(__FILE__).'/downloads/GeoLite2-Country/';
    $exec = 'tar -xvzf "'.$fn.'" -C "'.$unzipFolder.'"';
    exec ($exec, $output, $result);
    
    $files = getFilePathList ($unzipFolder, true, '/.*.mmdb/', null, array('file'), 3);
    $exec = 'mv "'.$files[0].'" "'.dirname(__FILE__).'"';
    exec ($exec, $output, $result);

    $url = 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-Country&license_key='.$yourLicenseKey.'&suffix=tar.gz.sha256';
    $fn = dirname(__FILE__).'/downloads/GeoLite2-Country.tar.gz.sha256';
    file_put_contents ($fn, file_get_contents($url));
    
    $downloadsFolder = dirname(__FILE__).'/downloads/*';
    $exec = 'rm -rf "'.$downloadsFolder.'"';
    exec ($exec, $output, $result);    
?>
