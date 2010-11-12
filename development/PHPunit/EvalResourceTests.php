<?php
/**
* Smarty PHPunit tests for eval resources
* 
* @package PHPunit
* @author Uwe Tews 
*/


/**
* class for eval resource tests
*/
class EvalResourceTests extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
    } 

    public static function isRunnable()
    {
        return true;
    } 

    /**
    * test template eval exits
    */
    public function testTemplateEvalExists1()
    {
        $tpl = $this->smarty->createTemplate('eval:{$foo}');
        $this->assertTrue($tpl->isExisting());
    } 
    public function testTemplateEvalExists2()
    {
        $this->assertTrue($this->smarty->templateExists('eval:{$foo}'));
    } 
    /**
    * test getTemplateFilepath
    */
    public function testGetTemplateFilepath()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertEquals('eval:', $tpl->getTemplateFilepath());
    } 
    /**
    * test getTemplateTimestamp
    */
    public function testGetTemplateTimestamp()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertFalse($tpl->getTemplateTimestamp());
    } 
    /**
    * test getTemplateSource
    */
    public function testGetTemplateSource()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world{$foo}');
        $this->assertEquals('hello world{$foo}', $tpl->getTemplateSource());
    } 
    /**
    * test usesCompiler
    */
    public function testUsesCompiler()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertTrue($tpl->resource_object->usesCompiler);
    } 
    /**
    * test isEvaluated
    */
    public function testIsEvaluated()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertTrue($tpl->resource_object->isEvaluated);
    } 
    /**
    * test mustCompile
    */
    public function testMustCompile()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertTrue($tpl->mustCompile());
    } 
    /**
    * test getCompiledFilepath
    */
    public function testGetCompiledFilepath()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertFalse($tpl->getCompiledFilepath());
    } 
    /**
    * test getCompiledTimestamp
    */
    public function testGetCompiledTimestamp()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertFalse($tpl->getCompiledTimestamp());
    } 
    /**
    * test getCompiledTemplate
    */
    public function testGetCompiledTemplate()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $result = $tpl->getCompiledTemplate();
        $this->assertContains('hello world', $result);
        $this->assertContains('<?php /* Smarty version ', $result);
    } 
    /**
    * test getCachedFilepath
    */
    public function testGetCachedFilepath()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertFalse($tpl->getCachedFilepath());
    } 
    /**
    * test getCachedTimestamp
    */
    public function testGetCachedTimestamp()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertFalse($tpl->getCachedTimestamp());
    } 
    /**
    * test getCachedContent
    */
    public function testGetCachedContent()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertFalse($tpl->getCachedContent());
    } 
    /**
    * test writeCachedContent
    */
    public function testWriteCachedContent()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertFalse($tpl->writeCachedContent('dummy'));
    } 
    /**
    * test isCached
    */
    public function testIsCached()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertFalse($tpl->isCached());
    } 
    /**
    * test getRenderedTemplate
    */
    public function testGetRenderedTemplate()
    {
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertEquals('hello world', $tpl->getRenderedTemplate());
    } 
    /**
    * test that no complied template and cache file was produced
    */
    public function testNoFiles()
    {
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 20;
        $this->smarty->clearCompiledTemplate();
        $this->smarty->clearAllCache();
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertEquals('hello world', $this->smarty->fetch($tpl));
        $this->assertEquals(0, $this->smarty->clearAllCache());
        $this->assertEquals(0, $this->smarty->clearCompiledTemplate());
    } 
    /**
    * test $smarty->is_cached
    */
    public function testSmartyIsCached()
    {
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 20;
        $tpl = $this->smarty->createTemplate('eval:hello world');
        $this->assertEquals('hello world', $this->smarty->fetch($tpl));
        $this->assertFalse($this->smarty->isCached($tpl));
    } 
} 

?>
