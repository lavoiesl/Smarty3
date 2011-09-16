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
class PluginModifierCountCharactersTests extends PHPUnit_Framework_TestCase {
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
        $result = "29";
        $tpl = $this->smarty->createTemplate('eval:{"Cold Wave Linked to Temperatures."|count_characters}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testDefaultWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "29";
        $tpl = $this->smarty->createTemplate('eval:{"Cold Wave Linked to Temperatures."|count_characters}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    

	public function testSpaces()
    {
        $result = "33";
        $tpl = $this->smarty->createTemplate('eval:{"Cold Wave Linked to Temperatures."|count_characters:true}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testSpacesWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "33";
        $tpl = $this->smarty->createTemplate('eval:{"Cold Wave Linked to Temperatures."|count_characters:true}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }


	public function testUmlauts()
    {
        $result = "29";
        $tpl = $this->smarty->createTemplate('eval:{"Cold Wäve Linked tö Temperatures."|count_characters}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testUmlautsWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "29";
        $tpl = $this->smarty->createTemplate('eval:{"Cold Wäve Linked tö Temperatures."|count_characters}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }

	
	public function testUmlautsSpaces()
    {
        $result = "33";
        $tpl = $this->smarty->createTemplate('eval:{"Cold Wäve Linked tö Temperatures."|count_characters:true}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testUmlautsSpacesWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "33";
        $tpl = $this->smarty->createTemplate('eval:{"Cold Wäve Linked tö Temperatures."|count_characters:true}');
        $this->assertNotEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
} 

?>