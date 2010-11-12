<?php
/**
* Montes smoke test
* @author Monte Ohrt <monte at ohrt dot com> 
* @package SmartyTestScripts
*/

require('../../distribution/libs/Smarty.class.php');

$smarty = new Smarty;

$smarty->force_compile = false;
$smarty->caching = 1;
$smarty->cache_lifetime = 100;
$smarty->debugging = true;



$smarty->assign('foo','bar');
$smarty->assign('foo2','bar2');
$smarty->assign('baz',array(1,2,3));
$smarty->assign('blah',array('a'=>1,'b'=>2,'c'=>3));

$smarty->assign('includeme','header.tpl');
$smarty->assign('top','header');

$smarty->assign('one',1);

$smarty->assign('myint',4);

$myobj = new MyObj();
$smarty->assign('myobj',$myobj);

$smarty->display('test_smoke.tpl');
$i=0;
class MyObj
{
  var $foo = 'bar';

  function test($p1=null,$p2=null)
  {
    return "This is my test, \$p1 is {$p1}, \$p2 is {$p2}";
  }

}

?>
