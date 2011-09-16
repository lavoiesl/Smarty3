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
class PluginModifierTruncateTests extends PHPUnit_Framework_TestCase {
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
        $result = 'Two Sisters Reunite after Eighteen Years at Checkout Counter.';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testDefaultWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = 'Two Sisters Reunite after Eighteen Years at Checkout Counter.';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testLength()
    {
        $result = 'Two Sisters Reunite after...';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testLengthWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = 'Two Sisters Reunite after...';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testEtc()
    {
        $result = 'Two Sisters Reunite after';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:""}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testEtcWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = 'Two Sisters Reunite after';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:""}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testEtc2()
    {
        $result = 'Two Sisters Reunite after---';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:"---"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testEtc2WithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = 'Two Sisters Reunite after---';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:"---"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testBreak()
    {
        $result = 'Two Sisters Reunite after Eigh';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:"":true}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testBreakWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = 'Two Sisters Reunite after Eigh';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:"":true}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testBreak2()
    {
        $result = 'Two Sisters Reunite after E...';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:"...":true}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testBreak2WithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = 'Two Sisters Reunite after E...';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:"...":true}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testMiddle()
    {
        $result = 'Two Sisters Re..ckout Counter.';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:"..":true:true}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testMiddleWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = 'Two Sisters Re..ckout Counter.';
        $tpl = $this->smarty->createTemplate('eval:{"Two Sisters Reunite after Eighteen Years at Checkout Counter."|truncate:30:"..":true:true}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
} 

?>