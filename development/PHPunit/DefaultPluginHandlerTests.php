<?php
/**
* Smarty PHPunit tests deault plugin handler
*
* @package PHPunit
* @author Uwe Tews
*/


/**
* class for plugin handler tests
*/
class DefaultPluginHandlerTests extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
        $this->smarty->force_compile = true;
        $this->smarty->disableSecurity();
        $this->smarty->registerDefaultPluginHandler('my_plugin_handler');
    }

    public static function isRunnable()
    {
        return true;
    }

    public function testDefaultFunctionScript()
    {
        $this->assertEquals("scriptfunction foo bar", $this->smarty->fetch('test_default_function_script.tpl'));
    }

    public function testDefaultFunctionLocal()
    {
        $this->assertEquals("localfunction foo bar", $this->smarty->fetch('test_default_function_local.tpl'));
    }
    public function testDefaultCompilerFunctionScript()
    {
        $this->assertEquals("scriptcompilerfunction foo bar", $this->smarty->fetch('test_default_compiler_function_script.tpl'));
    }
    public function testDefaultBlockScript()
    {
        $this->assertEquals("scriptblock foo bar", $this->smarty->fetch('test_default_block_script.tpl'));
    }

}

function my_plugin_handler ($tag, $type, $template, &$callback, &$script)
{
    switch ($type) {
        case Smarty::PLUGIN_FUNCTION:
            switch ($tag) {
                case 'scriptfunction':
                    $script = './scripts/script_function_tag.php';
                    $callback = 'default_script_function_tag';
                    return true;
                case 'localfunction':
                    $callback = 'default_local_function_tag';
                    return true;
                default:
                return false;
            }
        case Smarty::PLUGIN_COMPILER:
            switch ($tag) {
                case 'scriptcompilerfunction':
                    $script = './scripts/script_compiler_function_tag.php';
                    $callback = 'default_script_compiler_function_tag';
                    return true;
                default:
                return false;
            }
        case Smarty::PLUGIN_BLOCK:
            switch ($tag) {
                case 'scriptblock':
                    $script = './scripts/script_block_tag.php';
                    $callback = 'default_script_block_tag';
                    return true;
                default:
                return false;
            }
        default:
        return false;
    }
 }
function default_local_function_tag ($params, $template) {
    return 'localfunction '.$params['value'];
}
?>