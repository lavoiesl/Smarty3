<?php
/**
* Test script for the {insert} tag
* @author Uwe Tews 
* @package SmartyTestScripts
*/

require('../../distribution/libs/Smarty.class.php');

$smarty = new Smarty;

$smarty->enableSecurity();

$smarty->force_compile = true;
$smarty->caching = false;
$smarty->cache_lifetime = 10;

$smarty->display('test_security.tpl');


?>
