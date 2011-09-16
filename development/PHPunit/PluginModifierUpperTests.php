<?php
/**
* Smarty PHPunit tests of modifier
* 
* @package PHPunit
* @author Rodney Rehm 
*/

/**
* class for modifier tests
*/
class PluginModifierUpperTests extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
    } 

    public static function isRunnable()
    {
        return true;
    } 

    public function testDefault()
    {
        $result = "IF STRIKE ISN'T SETTLED QUICKLY IT MAY LAST A WHILE.";
        $tpl = $this->smarty->createTemplate('eval:{"If Strike isn\'t Settled Quickly it may Last a While."|upper}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testDefaultWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "IF STRIKE ISN'T SETTLED QUICKLY IT MAY LAST A WHILE.";
        $tpl = $this->smarty->createTemplate('eval:{"If Strike isn\'t Settled Quickly it may Last a While."|upper}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    

	public function testUmlauts()
    {
        $result = "IF STRIKE ISN'T SÄTTLED ÜQUICKLY IT MAY LAST A WHILE.";
        $tpl = $this->smarty->createTemplate('eval:{"If Strike isn\'t Sättled ÜQuickly it may Last a While."|upper}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testUmlautsWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "IF STRIKE ISN'T SÄTTLED ÜQUICKLY IT MAY LAST A WHILE.";
        $tpl = $this->smarty->createTemplate('eval:{"If Strike isn\'t Sättled ÜQuickly it may Last a While."|upper}');
        $this->assertNotEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }

} 

?>