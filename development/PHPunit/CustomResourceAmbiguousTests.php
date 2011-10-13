<?php
/**
* Smarty PHPunit tests for File resources
*
* @package PHPunit
* @author Uwe Tews
*/


/**
* class for file resource tests
*/
class CustomResourceAmbiguousTests extends PHPUnit_Framework_TestCase {
    public $_resource = null;
    
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
        
        // empty the template dir
        $this->smarty->setTemplateDir(array());
        
        // load and register custom resource handler
        require_once dirname(__FILE__) . '/PHPunitplugins/resource.ambiguous.php';
        if (isset(Smarty_Resource::$resources['ambiguous'])) {
            $this->_resource = Smarty_Resource::$resources['ambiguous'];
        } else {
            $this->_resource = new Smarty_Resource_Ambiguous(dirname(__FILE__) . '/templates/ambiguous/');
        }
        $this->smarty->registerResource('ambiguous', $this->_resource);
        $this->smarty->default_resource_type = 'ambiguous';
    }

    public static function isRunnable()
    {
        return true;
    }

    protected function relative($path)
    {
        $path = str_replace( dirname(__FILE__), '.', $path );
        if (DS == "\\") {
            $path = str_replace( "\\", "/", $path );
        }
        return $path;
    }

    public function testNone()
    {
        $tpl = $this->smarty->createTemplate('foobar.tpl');
        $this->assertFalse($tpl->source->exists);
    }
    
    public function testCase1()
    {
        $this->_resource->setSegment('case1');
        $tpl = $this->smarty->createTemplate('foobar.tpl');
        $this->assertTrue($tpl->source->exists);
        $this->assertEquals('case1', $tpl->source->content);
    }
    
    public function testCase2()
    {
        $this->_resource->setSegment('case2');
        $tpl = $this->smarty->createTemplate('foobar.tpl');
        $this->assertTrue($tpl->source->exists);
        $this->assertEquals('case2', $tpl->source->content);
    }
    
    public function testCaseSwitching()
    {
        $this->_resource->setSegment('case1');
        $tpl = $this->smarty->createTemplate('foobar.tpl');
        $this->assertTrue($tpl->source->exists);
        $this->assertEquals('case1', $tpl->source->content);
        
        $this->_resource->setSegment('case2');
        $tpl = $this->smarty->createTemplate('foobar.tpl');
        $this->assertTrue($tpl->source->exists);
        $this->assertEquals('case2', $tpl->source->content);
    }

    /**
    * final cleanup
    */
    public function testFinalCleanup()
    {
        $this->smarty->clearCompiledTemplate();
        $this->smarty->clearAllCache();
    }
}

?>
