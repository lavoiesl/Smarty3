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
class PluginModifierCountWordsTests extends PHPUnit_Framework_TestCase {
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
        $result = "7";
        $tpl = $this->smarty->createTemplate('eval:{"Dealers Will Hear Car Talk at Noon."|count_words}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testDefaultWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "7";
        $tpl = $this->smarty->createTemplate('eval:{"Dealers Will Hear Car Talk at Noon."|count_words}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    

	public function testDashes()
    {
        $result = "7";
        $tpl = $this->smarty->createTemplate('eval:{"Smalltime-Dealers Will Hear Car Talk at Noon."|count_words}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testDashesWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "7";
        $tpl = $this->smarty->createTemplate('eval:{"Smalltime-Dealers Will Hear Car Talk at Noon."|count_words}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }


	public function testUmlauts()
    {
        $result = "7";
        $tpl = $this->smarty->createTemplate('eval:{"Dealers Will Hear Cär Talk at Nöön."|count_words}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testUmlautsWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "7";
        $tpl = $this->smarty->createTemplate('eval:{"Dealers Will Hear Cär Talk at Nöön."|count_words}');
        $this->assertNotEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }

} 

?>