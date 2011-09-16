<?php
/**
 * Smarty PHPunit tests register->resource
 *
 * @package PHPunit
 * @author Uwe Tews
 */

/**
 * class for register->resource tests
 */
class RegisteredResourceTests extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
        $this->smarty->registerResource("rr", array("rr_get_template",
                "rr_get_timestamp",
                "rr_get_secure",
                "rr_get_trusted"));
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
        $this->assertEquals('hello world', $this->smarty->fetch('rr:test'));
    }
    public function testClearCompiledResourcePlugin()
    {
        $this->assertEquals(1, $this->smarty->clearCompiledTemplate('rr:test'));
    }
    /**
     * test resource plugin timesatmp
     */
    public function testResourcePluginTimestamp()
    {
        $tpl = $this->smarty->createTemplate('rr:test');
        $this->assertTrue(is_integer($tpl->source->timestamp));
        $this->assertEquals(10, strlen($tpl->source->timestamp));
    }
}

/**
 * resource functions
 */
function rr_get_template ($tpl_name, &$tpl_source, $smarty_obj)
{
    // populating $tpl_source
    $tpl_source = '{$x="hello world"}{$x}';
    return true;
}

function rr_get_timestamp($tpl_name, &$tpl_timestamp, $smarty_obj)
{
    // $tpl_timestamp.
    $tpl_timestamp = (int)floor(time() / 100) * 100;
    return true;
}

function rr_get_secure($tpl_name, $smarty_obj)
{
    // assume all templates are secure
    return true;
}

function rr_get_trusted($tpl_name, $smarty_obj)
{
    // not used for templates
}

?>