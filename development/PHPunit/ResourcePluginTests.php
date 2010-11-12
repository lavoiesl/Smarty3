<?php
/**
 * Smarty PHPunit tests resource plugins
 * 
 * @package PHPunit
 * @author Uwe Tews 
 */

/**
 * class for resource plugins tests
 */
class ResourcePluginTests extends PHPUnit_Framework_TestCase {
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
     * test resource plugin rendering
     */
    public function testResourcePlugin()
    {
        $this->assertEquals('hello world', $this->smarty->fetch('db:test'));
    } 
    /**
     * test resource plugin timesatmp
     */
    public function testResourcePluginTimestamp()
    {
        $tpl = $this->smarty->createTemplate('db:test');
        $this->assertTrue(is_integer($tpl->getTemplateTimestamp()));
        $this->assertEquals(10, strlen($tpl->getTemplateTimestamp()));
    } 
} 

?>