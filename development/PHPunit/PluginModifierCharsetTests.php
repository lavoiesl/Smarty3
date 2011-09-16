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
class PluginModifierCharsetTests extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
    } 

    public static function isRunnable()
    {
        return true;
    } 

    public function testToLatin1()
    {
        $encoded = "hällö wörld";
        $result = utf8_decode($encoded);
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|to_charset}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testToLatin1WithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $encoded = "hällö wörld";
        $result = utf8_decode($encoded);
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|to_charset}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    public function testFromLatin1()
    {
        $result = "hällö wörld";
        $encoded = utf8_decode($result);
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|from_charset}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testFromLatin1WithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "hällö wörld";
        $encoded = utf8_decode($result);
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|from_charset}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testFromUtf32le()
    {
        $result = "hällö wörld";
        $encoded = mb_convert_encoding($result, "UTF-32LE", "UTF-8");
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|from_charset:"UTF-32LE"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testFromUtf32leWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $result = "hällö wörld";
        $encoded = mb_convert_encoding($result, "UTF-32LE", "UTF-8");
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|from_charset:"UTF-32LE"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testToUtf32le()
    {
        $encoded = "hällö wörld";
        $result = mb_convert_encoding($encoded, "UTF-32LE", "UTF-8");
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|to_charset:"UTF-32LE"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testToUtf32leWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $encoded = "hällö wörld";
        $result = mb_convert_encoding($encoded, "UTF-32LE", "UTF-8");
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|to_charset:"UTF-32LE"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
} 

?>