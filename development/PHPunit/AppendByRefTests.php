<?php
/**
* Smarty PHPunit tests appendByRef methode
* 
* @package PHPunit
* @author Uwe Tews 
*/

/**
* class for appendByRef tests
*/
class AppendByRefTests extends PHPUnit_Framework_TestCase {
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
    * test appendByRef
    */
    public function testAppendByRef()
    {
        $bar = 'bar';
        $bar2 = 'bar2';
        $this->smarty->appendByRef('foo', $bar);
        $this->smarty->appendByRef('foo', $bar2);
        $bar = 'newbar';
        $bar2 = 'newbar2';
        $this->assertEquals('newbar newbar2', $this->smarty->fetch('eval:{$foo[0]} {$foo[1]}'));
    } 
    public function testSmarty2AppendByRef()
    {
        $bar = 'bar';
        $bar2 = 'bar2';
        $this->smarty->append_by_ref('foo', $bar);
        $this->smarty->append_by_ref('foo', $bar2);
        $bar = 'newbar';
        $bar2 = 'newbar2';
        $this->assertEquals('newbar newbar2', $this->smarty->fetch('eval:{$foo[0]} {$foo[1]}'));
    } 
    /**
    * test appendByRef to unassigned variable
    */
    public function testAppendByRefUnassigned()
    {
        $bar2 = 'bar2';
        $this->smarty->appendByRef('foo', $bar2);
        $bar2 = 'newbar2';
        $this->assertEquals('newbar2', $this->smarty->fetch('eval:{$foo[0]}'));
    } 
     public function testSmarty2AppendByRefUnassigned()
    {
        $bar2 = 'bar2';
        $this->smarty->append_by_ref('foo', $bar2);
        $bar2 = 'newbar2';
        $this->assertEquals('newbar2', $this->smarty->fetch('eval:{$foo[0]}'));
    } 
    /**
    * test appendByRef merge
    * 
    * @todo fix testAppendByRefMerge
    */
    public function testAppendByRefMerge()
    {
        /*
        $bar = array('b' => 'd');
        $this->smarty->assign('foo', array('a' => 'a', 'b' => 'b', 'c' => 'c'));
        $this->smarty->appendByRef('foo', $bar, true);
        $this->assertEquals('a d c', $this->smarty->fetch('eval:{$foo["a"]} {$foo["b"]} {$foo["c"]}'));
        $bar = array('b' => 'newd');
        $this->assertEquals('a newd c', $this->smarty->fetch('eval:{$foo["a"]} {$foo["b"]} {$foo["c"]}'));
*/
    } 
} 

?>
