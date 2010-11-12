<?php
/**
* Smarty PHPunit tests assignByRef methode
* 
* @package PHPunit
* @author Uwe Tews 
*/

/**
* class for assignByRef tests
*/
class AssignByRefTests extends PHPUnit_Framework_TestCase {
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
    * test simple assignByRef
    */
    public function testSimpleAssignByRef()
    {
        $bar = 'bar';
        $this->smarty->assignByRef('foo', $bar);
        $bar = 'newbar';
        $this->assertEquals('newbar', $this->smarty->fetch('eval:{$foo}'));
    } 
    /**
    * test Smarty2 assign_By_Ref
    */
    public function testSmarty2AssignByRef()
    {
        $bar = 'bar';
        $this->smarty->assign_by_ref('foo', $bar);
        $bar = 'newbar';
        $this->assertEquals('newbar', $this->smarty->fetch('eval:{$foo}'));
    } 
} 

?>
