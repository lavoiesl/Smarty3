<?php
/**
* Test script for registered objects
* @author Uwe Tews 
* @package SmartyTestScripts
*/

require('../../distribution/libs/Smarty.class.php');

$smarty = new Smarty;

$smarty->force_compile = true;
$smarty->caching = false;
$smarty->cache_lifetime = 60;
$smarty->use_sub_dirs = false;

 class TestClass
{
    
    public function hello($params)
    {
        var_dump($params);
        return 'Hello World';
    }
    
}  

$object = new TestClass;

$smarty->register_object('test',$object,'hello');

$smarty->display('test_object2.tpl');
?>
