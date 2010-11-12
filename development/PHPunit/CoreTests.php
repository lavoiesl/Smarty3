<?php
/**
* Smarty PHPunit basic core function tests
* 
* @package PHPunit
* @author Uwe Tews 
*/


/**
* class core function tests
*/
class CoreTests extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
    } 

    public static function isRunnable()
    {
        return true;
    } 


    /**
    * loadPlugin test unkown plugin
    */
    public function testLoadPluginErrorReturn()
    {
        $this->assertFalse(Smarty_Internal_Plugin_Loader::loadPlugin('Smarty_Not_Known', $this->smarty->plugins_dir));
    } 
    /**
    * loadPlugin test Smarty_Internal_Debug exists
    */
    public function testLoadPluginSmartyInternalDebug()
    {
        $this->assertTrue(Smarty_Internal_Plugin_Loader::loadPlugin('Smarty_Internal_Debug', $this->smarty->plugins_dir) == true);
    } 
    /**
    * loadPlugin test $template_class exists
    */
    public function testLoadPluginSmartyTemplateClass()
    {
        $this->assertTrue(Smarty_Internal_Plugin_Loader::loadPlugin($this->smarty->template_class, $this->smarty->plugins_dir) == true);
    } 
    /**
    * loadPlugin test loaging from plugins_dir
    */
    public function testLoadPluginSmartyPluginCounter()
    {
        $this->assertTrue(Smarty_Internal_Plugin_Loader::loadPlugin('Smarty_Function_Counter', $this->smarty->plugins_dir) == true);
    } 
} 

?>
