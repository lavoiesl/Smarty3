<?php
/**
* Smarty PHPunit tests for deleting compiled templates
*
* @package PHPunit
* @author Uwe Tews
*/


/**
* class for delete compiled template tests
*/
class ClearCompiledTests extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        $this->smartyBC = SmartyTests::$smartyBC;
        SmartyTests::init();
    }

    public static function isRunnable()
    {
        return true;
    }

    /**
    * test clearCompiledTemplate method for all files
    */
    public function testClearCompiledAll()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->getCompileDir() . 'dummy.php', 'test');
        file_put_contents($this->smarty->getCompileDir() . 'dummy2.php', 'test');
        $this->assertEquals(2, $this->smarty->clearCompiledTemplate());
       	$this->assertFalse(file_exists($this->smarty->getCompileDir() . 'dummy.php'));
        $this->assertFalse(file_exists($this->smarty->getCompileDir() . 'dummy2.php'));
    }
    public function testSmarty2ClearCompiledAll()
    {
        $this->smartyBC->clearCompiledTemplate();
        file_put_contents($this->smartyBC->getCompileDir() . 'dummy.php', 'test');
        file_put_contents($this->smartyBC->getCompileDir() . 'dummy2.php', 'test');
        $this->smartyBC->clear_compiled_tpl();
        $this->assertFalse(file_exists($this->smartyBC->getCompileDir() . 'dummy.php'));
        $this->assertFalse(file_exists($this->smartyBC->getCompileDir() . 'dummy2.php'));
    }
    /**
    * test clearCompiledTemplate method for a specific resource
    */
    public function testClearCompiledResource()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->getCompileDir() . sha1($this->smarty->getTemplateDir(0) . 'helloworld.tpl').'.file.helloworld.tpl.php', 'test');
        file_put_contents($this->smarty->getCompileDir() . sha1($this->smarty->getTemplateDir(0) . 'helloworld.tpl').'.file.helloworld.tpl.cache.php', 'test');
        file_put_contents($this->smarty->getCompileDir() . 'dummy2.php', 'test');
        $this->assertEquals(2, $this->smarty->clearCompiledTemplate('helloworld.tpl'));
        $this->assertFalse(file_exists($this->smarty->getCompileDir() . sha1($this->smarty->getTemplateDir(0) . 'helloworld.tpl').'.file.helloworld.tpl.php'));
        $this->assertFalse(file_exists($this->smarty->getCompileDir() . sha1($this->smarty->getTemplateDir(0) . 'helloworld.tpl').'.file.helloworld.tpl.cache.php'));
        $this->assertTrue(file_exists($this->smarty->getCompileDir() . 'dummy2.php'));
    }
    public function testSmarty2ClearCompiledResource()
    {
        $this->smartyBC->clearCompiledTemplate();
        file_put_contents($this->smartyBC->getCompileDir() . sha1($this->smartyBC->getTemplateDir(0) . 'helloworld.tpl').'.file.helloworld.tpl.php', 'test');
        file_put_contents($this->smartyBC->getCompileDir() . sha1($this->smartyBC->getTemplateDir(0) . 'helloworld.tpl').'.file.helloworld.tpl.cache.php', 'test');
        file_put_contents($this->smartyBC->getCompileDir() . 'dummy2.php', 'test');
        $this->smartyBC->clear_compiled_tpl('helloworld.tpl');
        $this->assertFalse(file_exists($this->smartyBC->getCompileDir() . sha1($this->smartyBC->getTemplateDir(0) . 'helloworld.tpl').'.file.helloworld.tpl.php'));
        $this->assertFalse(file_exists($this->smartyBC->getCompileDir() . sha1($this->smartyBC->getTemplateDir(0) . 'helloworld.tpl').'.file.helloworld.tpl.cache.php'));
        $this->assertTrue(file_exists($this->smartyBC->getCompileDir() . 'dummy2.php'));
    }
    /**
    * test clearCompiledTemplate method not expired
    */
    public function testClearCompiledNotExpired()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->getCompileDir() . 'dummy.php', 'test');
        touch($this->smarty->getCompileDir() . 'dummy.php', time()-1000);
        $this->assertEquals(0, $this->smarty->clearCompiledTemplate(null, null, 2000));
        $this->assertTrue(file_exists($this->smarty->getCompileDir() . 'dummy.php'));
    }
    public function testSnarty2ClearCompiledNotExpired()
    {
        $this->smartyBC->clearCompiledTemplate();
        file_put_contents($this->smartyBC->getCompileDir() . 'dummy.php', 'test');
        touch($this->smartyBC->getCompileDir() . 'dummy.php', time()-1000);
        $this->smartyBC->clear_compiled_tpl(null, null, 2000);
        $this->assertTrue(file_exists($this->smartyBC->getCompileDir() . 'dummy.php'));
    }
    /**
    * test clearCompiledTemplate method expired
    */
    public function testClearCompiledExpired()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->getCompileDir() . 'dummy.php', 'test');
        touch($this->smarty->getCompileDir() . 'dummy.php', time()-1000);
        $this->assertEquals(1, $this->smarty->clearCompiledTemplate(null, null, 500));
        $this->assertFalse(file_exists($this->smarty->getCompileDir() . 'dummy.php'));
    }
    public function testSmarty2ClearCompiledExpired()
    {
        $this->smartyBC->clearCompiledTemplate();
        file_put_contents($this->smartyBC->getCompileDir() . 'dummy.php', 'test');
        touch($this->smartyBC->getCompileDir() . 'dummy.php', time()-1000);
        $this->smartyBC->clear_compiled_tpl(null, null, 500);
        $this->assertFalse(file_exists($this->smartyBC->getCompileDir() . 'dummy.php'));
    }
    /**
    * test clearCompiledTemplate with compile_id
    */
    public function testClearCompiledCompileId()
    {
        $this->smarty->use_sub_dirs = true;
        $tpl = $this->smarty->createTemplate('helloworld.tpl', null, 'blar');
        Smarty_Internal_Write_File::writeFile($tpl->compiled->filepath, 'hello world', $this->smarty);
        $tpl2 = $this->smarty->createTemplate('helloworld.tpl', null, 'blar2');
        Smarty_Internal_Write_File::writeFile($tpl2->compiled->filepath, 'hello world', $this->smarty);
        $tpl3 = $this->smarty->createTemplate('helloworld2.tpl', null, 'blar');
        Smarty_Internal_Write_File::writeFile($tpl3->compiled->filepath, 'hello world', $this->smarty);
        $this->assertTrue(file_exists($tpl->compiled->filepath));
        $this->assertTrue(file_exists($tpl2->compiled->filepath));
        $this->assertTrue(file_exists($tpl3->compiled->filepath));
        $this->assertEquals(2, $this->smarty->clearCompiledTemplate (null, 'blar'));
        $this->assertFalse(file_exists($tpl->compiled->filepath));
        $this->assertTrue(file_exists($tpl2->compiled->filepath));
        $this->assertFalse(file_exists($tpl3->compiled->filepath));
    }
    public function testSmarty2ClearCompiledCompileId()
    {
        $this->smartyBC->use_sub_dirs = true;
        $tpl = $this->smartyBC->createTemplate('helloworld.tpl', null, 'blar');
        Smarty_Internal_Write_File::writeFile($tpl->compiled->filepath, 'hello world', $this->smarty);
        $tpl2 = $this->smartyBC->createTemplate('helloworld.tpl', null, 'blar2');
        Smarty_Internal_Write_File::writeFile($tpl2->compiled->filepath, 'hello world', $this->smarty);
        $tpl3 = $this->smartyBC->createTemplate('helloworld2.tpl', null, 'blar');
        Smarty_Internal_Write_File::writeFile($tpl3->compiled->filepath, 'hello world', $this->smarty);
        $this->assertTrue(file_exists($tpl->compiled->filepath));
        $this->assertTrue(file_exists($tpl2->compiled->filepath));
        $this->assertTrue(file_exists($tpl3->compiled->filepath));
        $this->smartyBC->clear_compiled_tpl(null, 'blar');
        $this->assertFalse(file_exists($tpl->compiled->filepath));
        $this->assertTrue(file_exists($tpl2->compiled->filepath));
        $this->assertFalse(file_exists($tpl3->compiled->filepath));
    }
}

?>
