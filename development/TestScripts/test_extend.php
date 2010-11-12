<?php
/**
* Test script for extend
* @author Uwe Tews 
* @package SmartyTestScripts
*/

require('../../distribution/libs/Smarty.class.php');

$smarty = new Smarty;
$smarty->debugging = true;
$smarty->force_compile = true;
$smarty->caching = false;
$smarty->cache_lifetime=1000;

$smarty->assign('foo', 'foo');

$smarty->display('test_block.tpl');


?>
