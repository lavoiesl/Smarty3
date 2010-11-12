<?php
/**
 * Smarty PHPunit test suite
 * 
 * @package PHPunit
 * @author Uwe Tews 
 */
require_once 'PHPUnit/Framework.php';

define ('SMARTY_DIR', '../../distribution/libs/');

require_once SMARTY_DIR . 'Smarty.class.php';

/**
 * class for running test suite
 */
class SmartyTests extends PHPUnit_Framework_TestSuite {
    static $smarty = null ;

    public function __construct()
    {
        SmartyTests::$smarty = new Smarty();
    } 

    public static function init()
    {
        error_reporting(E_ALL + E_STRICT);
        $smarty = SmartyTests::$smarty;
        $smarty->template_objects = null;
        $smarty->cache_resource_objects = array();
        $smarty->config_vars = array();
        Smarty::$global_tpl_vars = array();
        $smarty->template_functions = array();
        $smarty->tpl_vars = array();
        $smarty->force_compile = false;
        $smarty->auto_literal = true;
        $smarty->caching = false;
        $smarty->_smarty_vars = array();
        $smarty->registered_plugins = array();
        $smarty->default_plugin_handler_func = null;
        $smarty->registered_objects = array();
        $smarty->registered_filters = array();
        $smarty->autoload_filters = array();
        $smarty->variable_filter = true;
        $smarty->use_sub_dirs = false;
        $smarty->config_overwrite = true;
        $smarty->config_booleanize = true;
        $smarty->config_read_hidden = true;
        $smarty->security_policy = null;
        $smarty->left_delimiter = '{';
        $smarty->right_delimiter = '}';
        $smarty->php_handling = Smarty::PHP_PASSTHRU;
        $smarty->allow_php_tag = false;
        $smarty->allow_php_templates = false;
        $smarty->block_data = null;
        $smarty->enableSecurity();
    } 
    /**
     * look for test units and run them
     */
    public static function suite()
    {
        $testorder = array('CompileInsertTests');
        $smarty_libs_dir = dirname(__FILE__) . '/../../distribution/libs';
        if (method_exists('PHPUnit_Util_Filter', $smarty_libs_dir)) {
            // Older versions of PHPUnit did not have this function,
            // which is used when determining which PHP files are
            // included in the PHPUnit code coverage result.
            PHPUnit_Util_Filter::addDirectoryToWhitelist($smarty_libs_dir); 
            // PHPUnit_Util_Filt<er::removeDirectoryFromWhitelist('../');
            // PHPUnit_Util_Filter::addDirectoryToWhitelist('../libs/plugins');
        } 
        $suite = new self('Smarty 3 - Unit Tests Report'); 
        // load test which should run in specific order
        foreach ($testorder as $class) {
            require_once $class . '.php';
            $suite->addTestSuite($class);
        } 

        if (false) {
            foreach (new DirectoryIterator(dirname(__FILE__)) as $file) {
                if (!$file->isDot() && !$file->isDir() && (string) $file !== 'smartytests.php' && (string) $file !== 'smartysingletests.php' && substr((string) $file, -4) === '.php') {
                    $class = basename($file, '.php');
                    if (!in_array($class, $testorder)) {
                        require_once $file->getPathname(); 
                        // to have an optional test suite, it should implement a public static function isRunnable
                        // that returns true only if all the conditions are met to run it successfully, for example
                        // it can check that an external library is present
                        if (!method_exists($class, 'isRunnable') || call_user_func(array($class, 'isRunnable'))) {
                            $suite->addTestSuite($class);
                        } 
                    } 
                } 
            } 
        } 
        return $suite;
    } 
} 

?>
<?php
/**
 * Smarty PHPunit test suite
 * 
 * @package PHPunit
 * @author Uwe Tews 
 */
require_once 'PHPUnit/Framework.php';

define ('SMARTY_DIR', '../../distribution/libs/');

require_once SMARTY_DIR . 'Smarty.class.php';

/**
 * class for running test suite
 */
class SmartyTests extends PHPUnit_Framework_TestSuite {
    static $smarty = null ;

    public function __construct()
    {
        SmartyTests::$smarty = new Smarty();
    } 

    public static function init()
    {
        error_reporting(E_ALL + E_STRICT);
        $smarty = SmartyTests::$smarty;
        $smarty->error_reporting = E_ALL + E_STRICT;
        $smarty->template_objects = null;
        $smarty->cache_resource_objects = array();
        $smarty->config_vars = array();
        $smarty->global_tpl_vars = array();
        $smarty->template_functions = array();
        $smarty->tpl_vars = array();
        $smarty->force_compile = false;
        $smarty->auto_literal = true;
        $smarty->caching = false;
        $smarty->_smarty_vars = array();
        $smarty->registered_plugins = array();
        $smarty->default_plugin_handler_func = null;
        $smarty->registered_objects = array();
        $smarty->registered_filters = array();
        $smarty->autoload_filters = array();
        $smarty->variable_filter = true;
        $smarty->use_sub_dirs = false;
        $smarty->config_overwrite = true;
        $smarty->config_booleanize = true;
        $smarty->config_read_hidden = true;
        $smarty->security_policy = null;
        $smarty->left_delimiter = '{';
        $smarty->right_delimiter = '}';
        $smarty->php_handling = Smarty::PHP_PASSTHRU;
        $smarty->allow_php_tag = false;
        $smarty->allow_php_templates = false;
        $smarty->block_data = null;
        $smarty->enableSecurity();
    } 
    /**
     * look for test units and run them
     */
    public static function suite()
    {
        $testorder = array('CompileInsertTests');
        $smarty_libs_dir = dirname(__FILE__) . '/../../distribution/libs';
        if (method_exists('PHPUnit_Util_Filter', $smarty_libs_dir)) {
            // Older versions of PHPUnit did not have this function,
            // which is used when determining which PHP files are
            // included in the PHPUnit code coverage result.
            PHPUnit_Util_Filter::addDirectoryToWhitelist($smarty_libs_dir); 
            // PHPUnit_Util_Filt<er::removeDirectoryFromWhitelist('../');
            // PHPUnit_Util_Filter::addDirectoryToWhitelist('../libs/plugins');
        } 
        $suite = new self('Smarty 3 - Unit Tests Report'); 
        // load test which should run in specific order
        foreach ($testorder as $class) {
            require_once $class . '.php';
            $suite->addTestSuite($class);
        } 

        if (false) {
            foreach (new DirectoryIterator(dirname(__FILE__)) as $file) {
                if (!$file->isDot() && !$file->isDir() && (string) $file !== 'smartytests.php' && (string) $file !== 'smartysingletests.php' && substr((string) $file, -4) === '.php') {
                    $class = basename($file, '.php');
                    if (!in_array($class, $testorder)) {
                        require_once $file->getPathname(); 
                        // to have an optional test suite, it should implement a public static function isRunnable
                        // that returns true only if all the conditions are met to run it successfully, for example
                        // it can check that an external library is present
                        if (!method_exists($class, 'isRunnable') || call_user_func(array($class, 'isRunnable'))) {
                            $suite->addTestSuite($class);
                        } 
                    } 
                } 
            } 
        } 
        return $suite;
    } 
} 

?>
