<?php 
//require_once(dirname(__FILE__).'/functions.php');
require_once(realpath(dirname(__FILE__).'/../../..').'/3rd-party/sag/src/Sag.php');

require_once(dirname(__FILE__).'/class.naForums-1.0.0.php');
global $naForums;
$naForums = new class_naForums();
?>
