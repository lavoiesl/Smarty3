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
class PluginModifierLowerTests extends PHPUnit_Framework_TestCase {
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
        $result = "two convicts evade noose, jury hung.";
        $tpl = $this->smarty->createTemplate('eval:{"Two Convicts Evade Noose, Jury Hung."|lower}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testDefaultWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "two convicts evade noose, jury hung.";
        $tpl = $this->smarty->createTemplate('eval:{"Two Convicts Evade Noose, Jury Hung."|lower}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    

	public function testUmlauts()
    {
        $result = "two convicts eväde nööse, jury hung.";
        $tpl = $this->smarty->createTemplate('eval:{"Two Convicts Eväde NöÖse, Jury Hung."|lower}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testUmlautsWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "two convicts eväde nööse, jury hung.";
        $tpl = $this->smarty->createTemplate('eval:{"Two Convicts Eväde NöÖse, Jury Hung."|lower}');
        $this->assertNotEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }

} 

?>