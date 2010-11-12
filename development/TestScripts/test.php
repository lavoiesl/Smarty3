<?php
/**
* Test script for the {debug} tag
* @author Uwe Tews 
* @package SmartyTestScripts
*/

require('../../distribution/libs/Smarty.class.php');

$smarty = new Smarty;
$smarty->force_compile = true;

$smarty->left_delimiter='<{';
$smarty->right_delimiter='}>';

//$smarty->display('test.tpl');
$smarty->display("string:<{if \$var ne 'a'}>a<{/if}> \n<{if \$var ne 'b'}>b<{/if}>");


?>                                   
