<?php
/**
* Test script for the Smarty compiler
* 
* It displays a form in which a template source code can be entered.
* The template source will be compiled, rendered and the result is displayed.
* The compiled code is displayed as well
* 
* @author Uwe Tews 
* @package SmartyTestScripts
*/

require('../../distribution/libs/Smarty.class.php');

$smarty = new Smarty;

$smarty->force_compile = false;
$smarty->caching = false;
$smarty->cache_lifetime = -1;
// $smarty->enableSecurity();

 $array = array('james', 'dan', 'basit', 'ayman'); $string = null; 
 foreach ($array as $value) {
         $smarty->assign('name', $value);
         $string .= $smarty->fetch('bug.tpl');

 }
 
 echo $string;


?>
