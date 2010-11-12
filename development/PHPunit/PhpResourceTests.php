<?php
/**
* Smarty PHPunit tests for PHP resources
* 
* @package PHPunit
* @author Uwe Tews 
*/

/**
* class for PHP resource tests
*/
class PhpResourceTests extends PHPUnit_Framework_TestCase {
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
    * test getTemplateFilepath
    */
    public function testGetTemplateFilepath()
    {
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertEquals('./templates/phphelloworld.php', str_replace('\\', '/', $tpl->getTemplateFilepath()));
    } 
    /**
    * test getTemplateTimestamp
    */
    public function testGetTemplateTimestamp()
    {
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertTrue(is_integer($tpl->getTemplateTimestamp()));
        $this->assertEquals(10, strlen($tpl->getTemplateTimestamp()));
    } 
    /**
    * test getTemplateSource
    */
    public function testGetTemplateSource()
    {
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertContains('php hello world', $tpl->getTemplateSource());
    } 
    /**
    * test usesCompiler
    */
    public function testUsesCompiler()
    {
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->resource_object->usesCompiler);
    } 
    /**
    * test isEvaluated
    */
    public function testIsEvaluated()
    {
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->resource_object->isEvaluated);
    } 
    /**
    * test getCompiledFilepath
    */
    public function testGetCompiledFilepath()
    {
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->getCompiledFilepath());
    } 
    /**
    * test getCompiledTimestamp
    */
    public function testGetCompiledTimestamp()
    {
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->getCompiledTimestamp());
    } 
    /**
    * test mustCompile
    */
    public function testMustCompile()
    {
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->mustCompile());
    } 
    /**
    * test getCompiledTemplate
    */
    public function testGetCompiledTemplate()
    {
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->getCompiledTemplate());
    } 
    /**
    * test getCachedFilepath if caching disabled
    */
    public function testGetCachedFilepathCachingDisabled()
    {
        $this->smarty->allow_php_templates = true;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->getCachedFilepath());
    } 
    /**
    * test getCachedFilepath
    */
    public function testGetCachedFilepath()
    {
        $this->smarty->allow_php_templates = true;
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 1000;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $expected = './cache/' . sha1('./templates/phphelloworld.php') . '.phphelloworld.php.php';
        $this->assertEquals(realpath($expected), realpath($tpl->getCachedFilepath()));
    } 
    /**
    * test create cache file used by the following tests
    */
    public function testCreateCacheFile()
    { 
        // create dummy cache file
        $this->smarty->allow_php_templates = true;
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 1000;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertContains('php hello world', $this->smarty->fetch($tpl));
    } 
    /**
    * test getCachedTimestamp caching disabled
    */
    public function testGetCachedTimestampCachingDisabled()
    {
        $this->smarty->caching = false;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->getCachedTimestamp());
    } 
    /**
    * test getCachedTimestamp caching enabled
    */
    public function testGetCachedTimestamp()
    {
        $this->smarty->allow_php_templates = true;
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 1000;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertTrue(is_integer($tpl->getCachedTimestamp()));
        $this->assertEquals(10, strlen($tpl->getCachedTimestamp()));
    } 
    /**
    * test getCachedContent caching disabled
    */
    public function testGetCachedContentCachingDisabled()
    {
        $this->smarty->allow_php_templates = true;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->getCachedContent());
    } 
    /**
    * test getCachedContent
    */
    public function testGetCachedContent()
    {
        $this->smarty->allow_php_templates = true;
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 1000;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertContains('php hello world', $tpl->getCachedContent());
    } 
    /**
    * test isCached
    */
    public function testIsCached()
    {
        $this->smarty->allow_php_templates = true;
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 1000;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertTrue($tpl->isCached());
        $this->assertEquals(null, $tpl->rendered_content);
    } 
    /**
    * test isCached caching disabled
    */
    public function testIsCachedCachingDisabled()
    {
        $this->smarty->allow_php_templates = true;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($tpl->isCached());
    } 
    /**
    * test isCached on touched source
    */
    public function testIsCachedTouchedSource()
    {
        $this->smarty->allow_php_templates = true;
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 1000;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        sleep(1);
        touch ($tpl->getTemplateFilepath ());
        $this->assertFalse($tpl->isCached());
    } 
    /**
    * test is cache file is written
    */
    public function testWriteCachedContent()
    {
        $this->smarty->allow_php_templates = true;
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 1000;
        $this->smarty->clearAllCache();
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->smarty->fetch($tpl);
        $this->assertTrue(file_exists($tpl->getCachedFilepath()));
    } 
    /**
    * test getRenderedTemplate
    */
    public function testGetRenderedTemplate()
    {
        $this->smarty->allow_php_templates = true;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertContains('php hello world', $tpl->getRenderedTemplate());
    } 
    /**
    * test $smarty->is_cached
    */
    public function testSmartyIsCachedPrepare()
    {
        $this->smarty->allow_php_templates = true; 
        // prepare files for next test
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 1000; 
        // clean up for next tests
        $this->smarty->clearAllCache();
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->smarty->fetch($tpl);
    } 
    public function testSmartyIsCached()
    {
        $this->smarty->allow_php_templates = true;
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 1000;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertTrue($this->smarty->isCached($tpl));
        $this->assertEquals(null, $tpl->rendered_content);
    } 
    /**
    * test $smarty->is_cached  caching disabled
    */
    public function testSmartyIsCachedCachingDisabled()
    {
        $this->smarty->allow_php_templates = true;
        $tpl = $this->smarty->createTemplate('php:phphelloworld.php');
        $this->assertFalse($this->smarty->isCached($tpl));
    } 
    /**
    * final cleanup
    */
    public function testFinalCleanup()
    {
        $this->smarty->clearAllCache();
    } 
} 

?>
