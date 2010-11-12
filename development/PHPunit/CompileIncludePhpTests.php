<?php
/**
* Smarty PHPunit tests compilation of the {include_php} tag
* 
* @package PHPunit
* @author Uwe Tews 
*/

/**
* class for {include_php} tests
*/
class CompileIncludePHPTests extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
        $this->smarty->force_compile = true;
        $this->smarty->allow_php_tag = true;
    } 

    public static function isRunnable()
    {
        return true;
    } 

    /**
    * test include_php string file_name function
    */
    public function testIncludePhpStringFileName()
    {
        $this->smarty->disableSecurity();
        $tpl = $this->smarty->createTemplate("eval:start {include_php file='scripts/test_include_php.php'} end");
        $result= $this->smarty->fetch($tpl);
        $this->assertContains("test include php", $result);
    } 
    /**
    * test include_php string file_name function
    */
    public function testIncludePhpVariableFileName()
    {
        $this->smarty->disableSecurity();
         $tpl = $this->smarty->createTemplate('eval:start {include_php file=$filename once=false} end');
        $tpl->assign('filename','scripts/test_include_php.php');
        $result= $this->smarty->fetch($tpl);
        $this->assertContains("test include php", $result);
    } 
    public function testIncludePhpVariableFileNameShortag()
    {
        $this->smarty->disableSecurity();
         $tpl = $this->smarty->createTemplate('eval:start {include_php $filename once=false} end');
        $tpl->assign('filename','scripts/test_include_php.php');
        $result= $this->smarty->fetch($tpl);
        $this->assertContains("test include php", $result);
    } 
}
?>