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
        SmartyTests::init();
        $this->smarty->deprecation_notices = false;
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
        file_put_contents($this->smarty->compile_dir . 'dummy.php', 'test');
        file_put_contents($this->smarty->compile_dir . 'dummy2.php', 'test');
        $this->assertEquals(2, $this->smarty->clearCompiledTemplate());
       	$this->assertFalse(file_exists($this->smarty->compile_dir . 'dummy.php'));
        $this->assertFalse(file_exists($this->smarty->compile_dir . 'dummy2.php'));
    } 
    public function testSmarty2ClearCompiledAll()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->compile_dir . 'dummy.php', 'test');
        file_put_contents($this->smarty->compile_dir . 'dummy2.php', 'test');
        $this->smarty->clear_compiled_template();
        $this->assertFalse(file_exists($this->smarty->compile_dir . 'dummy.php'));
        $this->assertFalse(file_exists($this->smarty->compile_dir . 'dummy2.php'));
    } 
    /**
    * test clearCompiledTemplate method for a specific resource
    */
    public function testClearCompiledResource()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->compile_dir . 'dummy.php', 'test');
        file_put_contents($this->smarty->compile_dir . 'dummy2.php', 'test');
        $this->assertEquals(1, $this->smarty->clearCompiledTemplate('dummy'));
        $this->assertFalse(file_exists($this->smarty->compile_dir . 'dummy.php'));
        $this->assertTrue(file_exists($this->smarty->compile_dir . 'dummy2.php'));
    } 
    public function testSmarty2ClearCompiledResource()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->compile_dir . 'dummy.php', 'test');
        file_put_contents($this->smarty->compile_dir . 'dummy2.php', 'test');
        $this->smarty->clear_compiled_template('dummy');
        $this->assertFalse(file_exists($this->smarty->compile_dir . 'dummy.php'));
        $this->assertTrue(file_exists($this->smarty->compile_dir . 'dummy2.php'));
    } 
    /**
    * test clearCompiledTemplate method not expired
    */
    public function testClearCompiledNotExpired()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->compile_dir . 'dummy.php', 'test');
        touch($this->smarty->compile_dir . 'dummy.php', time()-1000);
        $this->assertEquals(0, $this->smarty->clearCompiledTemplate(null, null, 2000));
        $this->assertTrue(file_exists($this->smarty->compile_dir . 'dummy.php'));
    } 
    public function testSnarty2ClearCompiledNotExpired()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->compile_dir . 'dummy.php', 'test');
        touch($this->smarty->compile_dir . 'dummy.php', time()-1000);
        $this->smarty->clear_compiled_template(null, null, 2000);
        $this->assertTrue(file_exists($this->smarty->compile_dir . 'dummy.php'));
    } 
    /**
    * test clearCompiledTemplate method expired
    */
    public function testClearCompiledExpired()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->compile_dir . 'dummy.php', 'test');
        touch($this->smarty->compile_dir . 'dummy.php', time()-1000);
        $this->assertEquals(1, $this->smarty->clearCompiledTemplate(null, null, 500));
        $this->assertFalse(file_exists($this->smarty->compile_dir . 'dummy.php'));
    } 
    public function testSmarty2ClearCompiledExpired()
    {
        $this->smarty->clearCompiledTemplate();
        file_put_contents($this->smarty->compile_dir . 'dummy.php', 'test');
        touch($this->smarty->compile_dir . 'dummy.php', time()-1000);
       $this->smarty->clear_compiled_template(null, null, 500);
        $this->assertFalse(file_exists($this->smarty->compile_dir . 'dummy.php'));
    } 
    /**
    * test clearCompiledTemplate with compile_id
    */
    public function testClearCompiledCompileId()
    {
        $this->smarty->use_sub_dirs = true;
        $tpl = $this->smarty->createTemplate('helloworld.tpl', null, 'blar');
        Smarty_Internal_Write_File::writeFile($tpl->getCompiledFilepath(), 'hello world', $this->smarty);
        $tpl2 = $this->smarty->createTemplate('helloworld.tpl', null, 'blar2');
        Smarty_Internal_Write_File::writeFile($tpl2->getCompiledFilepath(), 'hello world', $this->smarty);
        $tpl3 = $this->smarty->createTemplate('helloworld2.tpl', null, 'blar');
        Smarty_Internal_Write_File::writeFile($tpl3->getCompiledFilepath(), 'hello world', $this->smarty);
        $this->assertTrue(file_exists($tpl->getCompiledFilepath()));
        $this->assertTrue(file_exists($tpl2->getCompiledFilepath()));
        $this->assertTrue(file_exists($tpl3->getCompiledFilepath()));
        $this->assertEquals(2, $this->smarty->clearCompiledTemplate (null, 'blar'));
        $this->assertFalse(file_exists($tpl->getCompiledFilepath()));
        $this->assertTrue(file_exists($tpl2->getCompiledFilepath()));
        $this->assertFalse(file_exists($tpl3->getCompiledFilepath()));
    } 
    public function testSmarty2ClearCompiledCompileId()
    {
        $this->smarty->use_sub_dirs = true;
        $tpl = $this->smarty->createTemplate('helloworld.tpl', null, 'blar');
        Smarty_Internal_Write_File::writeFile($tpl->getCompiledFilepath(), 'hello world', $this->smarty);
        $tpl2 = $this->smarty->createTemplate('helloworld.tpl', null, 'blar2');
        Smarty_Internal_Write_File::writeFile($tpl2->getCompiledFilepath(), 'hello world', $this->smarty);
        $tpl3 = $this->smarty->createTemplate('helloworld2.tpl', null, 'blar');
        Smarty_Internal_Write_File::writeFile($tpl3->getCompiledFilepath(), 'hello world', $this->smarty);
        $this->assertTrue(file_exists($tpl->getCompiledFilepath()));
        $this->assertTrue(file_exists($tpl2->getCompiledFilepath()));
        $this->assertTrue(file_exists($tpl3->getCompiledFilepath()));
        $this->smarty->clear_compiled_template(null, 'blar');
        $this->assertFalse(file_exists($tpl->getCompiledFilepath()));
        $this->assertTrue(file_exists($tpl2->getCompiledFilepath()));
        $this->assertFalse(file_exists($tpl3->getCompiledFilepath()));
    } 
} 

?>
