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
class PluginModifierUnescapeTests extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
    } 

    public static function isRunnable()
    {
        return true;
    } 

    public function testHtml()
    {
        $encoded = "a&#228;&#1047;&#1076;&#1088;&#1072;&gt;&lt;&amp;amp;&auml;&#228;&#1074;&#1089;&#1089;&#1090;&#1074;&#1091;&#1081;&#1090;&#1077;";
        $result = "a&#228;&#1047;&#1076;&#1088;&#1072;><&amp;&auml;&#228;&#1074;&#1089;&#1089;&#1090;&#1074;&#1091;&#1081;&#1090;&#1077;";
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|unescape:"html"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testHtmlWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $encoded = "a&#228;&#1047;&#1076;&#1088;&#1072;&gt;&lt;&amp;amp;&auml;&#228;&#1074;&#1089;&#1089;&#1090;&#1074;&#1091;&#1081;&#1090;&#1077;";
        $result = "a&#228;&#1047;&#1076;&#1088;&#1072;><&amp;&auml;&#228;&#1074;&#1089;&#1089;&#1090;&#1074;&#1091;&#1081;&#1090;&#1077;";
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|unescape:"html"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
    
    public function testHtmlall()
    {
        $encoded = "a&#228;&#1047;&#1076;&#1088;&#1072;&gt;&lt;&amp;amp;&auml;&#228;&#1074;&#1089;&#1089;&#1090;&#1074;&#1091;&#1081;&#1090;&#1077;";
        $result = "aäЗдра><&amp;ääвсствуйте";
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|unescape:"htmlall"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
    }
    
    public function testHtmlallWithoutMbstring()
    {
        $_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING'] = true;
        $encoded = "a&#228;&#1047;&#1076;&#1088;&#1072;&gt;&lt;&amp;amp;&auml;&#228;&#1074;&#1089;&#1089;&#1090;&#1074;&#1091;&#1081;&#1090;&#1077;";
        $result = "aäЗдра><&amp;ääвсствуйте";
        $tpl = $this->smarty->createTemplate('eval:{"' . $encoded . '"|unescape:"htmlall"}');
        $this->assertEquals($result, $this->smarty->fetch($tpl));
        unset($_SERVER['SMARTY_PHPUNIT_DISABLE_MBSTRING']);
    }
    
} 

?>