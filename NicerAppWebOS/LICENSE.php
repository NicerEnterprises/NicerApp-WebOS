<?php global $naWebOS; require_once (dirname(__FILE__).'/domainConfigs/'.$naWebOS->domain.'/pageHeader.php');?>
<pre class="license">
<?php
    $fn = dirname(__FILE__).'/LICENSE.html';
    $fc = file_get_contents($fn);
    $fileFinal = str_replace('{LASTMODIFIED_LICENSE_html}', date('Ymd-His', filemtime($fn)), $fc);
    echo $fileFinal;
?>
</pre>
