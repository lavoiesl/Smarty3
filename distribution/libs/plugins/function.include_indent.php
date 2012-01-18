<?php 
/** 
 * Smarty plugin 
 * @package Smarty 
 * @subpackage plugins 
 */ 

/** 
 * called for included files within templates with specific indentation 
 * indentation will be apply on all lines, except first one 
 * 
 * @param array Format : 
 * <pre> 
 * array('file' => file to be included 
 *       'depth' => number of indentations 
 *       'indent' => string to use for indentation) 
 * </pre> 
 * @param Smarty 
 */ 

function smarty_function_include_indent($params, &$smarty) 
{ 
    // config vars are treated as local, so push a copy of the 
    // current ones onto the front of the stack 
    $_file = isset($params['file']) ? $params['file'] : null; 
    $_depth = isset($params['depth']) ? $params['depth'] : 0; 
    $_indent = isset($params['indent']) ? $params['indent'] : "  "; 

    if (!isset($_file) || strlen($_file) == 0) { 
        $smarty->trigger_error("missing 'file' attribute in include_indent tag", E_USER_ERROR, __FILE__, __LINE__); 
    } 

    $_smarty_compile_path = $smarty->_get_compile_path($_file); 

    if (!$smarty->_is_compiled($_file, $_smarty_compile_path)) { 
        $smarty->_compile_resource($_file, $_smarty_compile_path); 
    } 
        
    $_code = file_get_contents($_smarty_compile_path); 
    $_code = str_replace('<'.'?php', '<'.'?', $_code); 
    $_code = '?'.'>'.trim($_code).'<'.'?'; 
    ob_start(); 
    $smarty->_eval($_code); 
    $_result = ob_get_contents(); 
    ob_end_clean(); 
    $_order = array("\r\n", "\n", "\r"); 
    foreach($_order as $_search) { 
        $_replace = "$_search" . str_repeat($_indent, $_depth); 
        $_result = str_replace($_search, $_replace, $_result); 
    } 

    if ($smarty->caching) { 
        $smarty->_cache_info['template'][$file] = true; 
    } 

    return $_result; 
} 


