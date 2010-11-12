<?php
/**
 * Smarty PHPunit tests of filter
 * 
 * @package PHPunit
 * @author Uwe Tews 
 */

/**
 * class for filter tests
 */
class FilterTests extends PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->smarty = SmartyTests::$smarty;
        SmartyTests::init();
        $this->smarty->deprecation_notices = false;
        // $this->smarty->force_compile = true;
    } 

    public static function isRunnable()
    {
        return true;
    } 

    /**
     * test autoload filter
     */
    public function testAutoloadOutputFilter()
    {
        $this->smarty->autoload_filters['output'] = 'trimwhitespace';
        $tpl = $this->smarty->createTemplate('eval:{"    <br>hello world"}');
        $this->assertEquals("<br>hello world", $this->smarty->fetch($tpl));
    } 
    /**
     * test loaded filter
     */
    public function testLoadedOutputFilter()
    {
        $this->smarty->loadFilter(Smarty::FILTER_OUTPUT, 'trimwhitespace');
        $tpl = $this->smarty->createTemplate('eval:{"    <br>hello world"}');
        $this->assertEquals("<br>hello world", $this->smarty->fetch($tpl));
    } 
    /**
     * test registered output filter
     */
    public function testRegisteredOutputFilter()
    {
        $this->smarty->registerFilter(Smarty::FILTER_OUTPUT,'myoutputfilter');
        $tpl = $this->smarty->createTemplate('eval:{"hello   world"}');
        $this->assertEquals("hello world", $this->smarty->fetch($tpl));
    } 
    public function testRegisteredOutputFilterWrapper()
    {
       $this->smarty->register_outputfilter('myoutputfilter');
        $tpl = $this->smarty->createTemplate('eval:{"hello   world"}');
        $this->assertEquals("hello world", $this->smarty->fetch($tpl));
    } 
    /**
     * test registered pre filter
     */
    public function testRegisteredPreFilter()
    {
        function myprefilter($input)
        {
            return '{$foo}' . $input;
        } 
        $this->smarty->registerFilter(Smarty::FILTER_PRE,'myprefilter');
        $tpl = $this->smarty->createTemplate('eval:{" hello world"}');
        $tpl->assign('foo', 'bar');
        $this->assertEquals("bar hello world", $this->smarty->fetch($tpl));
    } 
    /**
     * test registered pre filter class
     */
    public function testRegisteredPreFilterClass()
    {
        $this->smarty->registerFilter(Smarty::FILTER_PRE,array('myprefilterclass', 'myprefilter'));
        $tpl = $this->smarty->createTemplate('eval:{" hello world"}');
        $tpl->assign('foo', 'bar');
        $this->assertEquals("bar hello world", $this->smarty->fetch($tpl));
    } 
    /**
     * test registered post filter
     */
    public function testRegisteredPostFilter()
    {
        function mypostfilter($input)
        {
            return '{$foo}' . $input;
        } 
        $this->smarty->registerFilter(Smarty::FILTER_POST,'mypostfilter');
        $tpl = $this->smarty->createTemplate('eval:{" hello world"}');
        $tpl->assign('foo', 'bar');
        $this->assertEquals('{$foo} hello world', $this->smarty->fetch($tpl));
    } 
    /**
     * test variable filter
     */
    public function testLoadedVariableFilter()
    {
        $this->smarty->loadFilter("variable", "htmlspecialchars");
        $tpl = $this->smarty->createTemplate('eval:{$foo}');
        $tpl->assign('foo', '<?php ?>');
        $this->assertEquals('&lt;?php ?&gt;', $this->smarty->fetch($tpl));
    } 
   /**
     * test registered post filter
     */
    public function testRegisteredVariableFilter()
    {
        function myvariablefilter($input, $smarty)
        {
            return 'var{$foo}' . $input;
        } 
        $this->smarty->registerFilter(Smarty::FILTER_VARIABLE,'myvariablefilter');
        $tpl = $this->smarty->createTemplate('eval:{$foo}');
        $tpl->assign('foo', 'bar');
        $this->assertEquals('var{$foo}bar', $this->smarty->fetch($tpl));
    } 
} 

function myoutputfilter($input)
{
	return str_replace('   ', ' ', $input);
} 
 
 class myprefilterclass {
    static function myprefilter($input)
    {
        return '{$foo}' . $input;
    } 
} 

?>