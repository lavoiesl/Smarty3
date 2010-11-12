<?php
 /**
* Test script for the function plugin tag
* @author Uwe Tews 
* @package SmartyTestScripts
*/

require('../../distribution/libs/Smarty.class.php');

function plugintest($params, &$smarty)
{
    return "plugin test called $params[foo]";
} 

class tp extends Smarty { 
public $imageURL = 'localhost//';
function smarty_function_imageRef($params, &$smarty) { 
return $this->imageURL . $params['file'];
} // imageRef
}
 
$smarty = new tp;
$smarty->register_function('imageRef', array($smarty, 'smarty_function_imageRef'), true, array('file'));
$smarty->force_compile = false;
$smarty->caching = true;
$smarty->cache_lifetime = 10;

$smarty->register_function('plugintest','plugintest');
$smarty->display('string:{imageRef file="test.img"}');


?>
