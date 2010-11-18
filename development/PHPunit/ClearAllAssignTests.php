<?php
/**
* Smarty PHPunit tests clearing all assigned variables
* 
* @package PHPunit
* @author Uwe Tews 
*/

/**
* class for clearing all assigned variables tests
*/
class ClearAllAssignTests extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
        $this->smarty->deprecation_notices = false;
        $this->smarty->assign('foo','foo');
        $this->smarty->data = new Smarty_Data($this->smarty);
        $this->smarty->data->assign('bar','bar');
        $this->smarty->tpl = $this->smarty->createTemplate('eval:{$foo}{$bar}{$blar}', null, null, $this->smarty->data);
        $this->smarty->tpl->assign('blar','blar');
    } 

    public static function isRunnable()
    {
        return true;
    } 

    /**
    * test all variables accessable
    */
    public function testAllVariablesAccessable()
    {
		$this->assertEquals('foobarblar', $this->smarty->fetch($this->smarty->tpl));
    } 

    /**
    * test clear all assign in template
    */
    public function testClearAllAssignInTemplate()
    {
 		$this->smarty->error_reporting  = error_reporting() & ~(E_NOTICE|E_USER_NOTICE);
        $this->smarty->tpl->clearAllAssign();
		$this->assertEquals('foobar', $this->smarty->fetch($this->smarty->tpl));
    } 
    /**
    * test clear all assign in data
    */
    public function testClearAllAssignInData()
    {
 		$this->smarty->error_reporting  = error_reporting() & ~(E_NOTICE|E_USER_NOTICE);
        $this->smarty->data->clearAllAssign();
		$this->assertEquals('fooblar', $this->smarty->fetch($this->smarty->tpl));
    } 
    /**
    * test clear all assign in Smarty object
    */
    public function testClearAllAssignInSmarty()
    {
 		$this->smarty->error_reporting  = error_reporting() & ~(E_NOTICE|E_USER_NOTICE);
        $this->smarty->clearAllAssign();
		$this->assertEquals('barblar', $this->smarty->fetch($this->smarty->tpl));
    } 
    public function testSmarty2ClearAllAssignInSmarty()
    {
 		$this->smarty->error_reporting  = error_reporting() & ~(E_NOTICE|E_USER_NOTICE);
        $this->smarty->clear_all_assign();
		$this->assertEquals('barblar', $this->smarty->fetch($this->smarty->tpl));
    } 
} 

?>
