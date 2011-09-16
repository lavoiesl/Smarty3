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
class PluginModifierCapitalizeTests extends PHPUnit_Framework_TestCase {
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
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, delayed. ümlauts äre cööl."|capitalize}');
        $this->assertEquals("Next X-Men FiLm, x3, Delayed. Ümlauts Äre Cööl.", $this->smarty->fetch($tpl));
    }
    
    public function testDigits()
    {
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, delayed. ümlauts äre cööl."|capitalize:true}');
        $this->assertEquals("Next X-Men FiLm, X3, Delayed. Ümlauts Äre Cööl.", $this->smarty->fetch($tpl));
    }
    
    public function testTrueCaptials()
    {
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, delayed. ümlauts äre cööl."|capitalize:true:true}');
        $this->assertEquals("Next X-Men Film, X3, Delayed. Ümlauts Äre Cööl.", $this->smarty->fetch($tpl));
    }
    
    
    public function testDefaultWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, delayed."|capitalize}');
        $this->assertEquals("Next X-Men FiLm, x3, Delayed.", $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    public function testDigitsWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, delayed."|capitalize:true}');
        $this->assertEquals("Next X-Men FiLm, X3, Delayed.", $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    public function testTrueCaptialsWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, delayed."|capitalize:true:true}');
        $this->assertEquals("Next X-Men Film, X3, Delayed.", $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testQuotes()
    {
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \"delayed. umlauts\" foo."|capitalize}');
        $this->assertEquals("Next X-Men FiLm, x3, \"Delayed. Umlauts\" Foo.", $this->smarty->fetch($tpl));
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \'delayed. umlauts\' foo."|capitalize}');
        $this->assertEquals("Next X-Men FiLm, x3, 'Delayed. Umlauts' Foo.", $this->smarty->fetch($tpl));
    }
    
    public function testQuotesWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \"delayed. umlauts\" foo."|capitalize}');
        $this->assertEquals("Next X-Men FiLm, x3, \"Delayed. Umlauts\" Foo.", $this->smarty->fetch($tpl));
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \'delayed. umlauts\' foo."|capitalize}');
        $this->assertEquals("Next X-Men FiLm, x3, 'Delayed. Umlauts' Foo.", $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    public function testQuotesDigits()
    {
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \"delayed. umlauts\" foo."|capitalize:true}');
        $this->assertEquals("Next X-Men FiLm, X3, \"Delayed. Umlauts\" Foo.", $this->smarty->fetch($tpl));
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \'delayed. umlauts\' foo."|capitalize:true}');
        $this->assertEquals("Next X-Men FiLm, X3, 'Delayed. Umlauts' Foo.", $this->smarty->fetch($tpl));
    }
    
    public function testQuotesDigitsWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \"delayed. umlauts\" foo."|capitalize:true}');
        $this->assertEquals("Next X-Men FiLm, X3, \"Delayed. Umlauts\" Foo.", $this->smarty->fetch($tpl));
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \'delayed. umlauts\' foo."|capitalize:true}');
        $this->assertEquals("Next X-Men FiLm, X3, 'Delayed. Umlauts' Foo.", $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    public function testQuotesTrueCapitals()
    {
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \"delayed. umlauts\" foo."|capitalize:true:true}');
        $this->assertEquals("Next X-Men Film, X3, \"Delayed. Umlauts\" Foo.", $this->smarty->fetch($tpl));
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \'delayed. umlauts\' foo."|capitalize:true:true}');
        $this->assertEquals("Next X-Men Film, X3, 'Delayed. Umlauts' Foo.", $this->smarty->fetch($tpl));
    }
    
    public function testQuotesTrueCapitalsWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \"delayed. umlauts\" foo."|capitalize:true:true}');
        $this->assertEquals("Next X-Men Film, X3, \"Delayed. Umlauts\" Foo.", $this->smarty->fetch($tpl));
        $tpl = $this->smarty->createTemplate('eval:{"next x-men fiLm, x3, \'delayed. umlauts\' foo."|capitalize:true:true}');
        $this->assertEquals("Next X-Men Film, X3, 'Delayed. Umlauts' Foo.", $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    public function testQuotesBeginning()
    {
        $tpl = $this->smarty->createTemplate('eval:{"\"delayed. umlauts\" foo."|capitalize}');
        $this->assertEquals("\"Delayed. Umlauts\" Foo.", $this->smarty->fetch($tpl));
        $tpl = $this->smarty->createTemplate('eval:{"\'delayed. umlauts\' foo."|capitalize}');
        $this->assertEquals("'Delayed. Umlauts' Foo.", $this->smarty->fetch($tpl));
    }
    
    public function testQuotesBeginningWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $tpl = $this->smarty->createTemplate('eval:{"\"delayed. umlauts\" foo."|capitalize}');
        $this->assertEquals("\"Delayed. Umlauts\" Foo.", $this->smarty->fetch($tpl));
        $tpl = $this->smarty->createTemplate('eval:{"\'delayed. umlauts\' foo."|capitalize}');
        $this->assertEquals("'Delayed. Umlauts' Foo.", $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
} 

?>