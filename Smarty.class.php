<?php
/*
 * Project:     Smarty: the PHP compiling template engine
 * File:        Smarty.class.php
 * Author:      Monte Ohrt <monte@ispi.net>
 *              Andrei Zmievski <andrei@php.net>
 *
 * Version:             1.4.0
 * Copyright:           2001 ispi of Lincoln, Inc.
 *              
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * For questions, help, comments, discussion, etc., please join the
 * Smarty mailing list. Send a blank e-mail to smarty-subscribe@lists.ispi.net
 *
 * You may contact the authors of Smarty by e-mail at:
 * monte@ispi.net
 * andrei@php.net
 *
 * Or, write to:
 * Monte Ohrt
 * CTO, ispi
 * 237 S. 70th suite 220
 * Lincoln, NE 68510
 *
 * The latest version of Smarty can be obtained from:
 * http://www.phpinsider.com/
 *
 */

require('Smarty.addons.php');

define("SMARTY_PHP_PASSTHRU",0);
define("SMARTY_PHP_QUOTE",1);
define("SMARTY_PHP_REMOVE",2);
define("SMARTY_PHP_ALLOW",3);

class Smarty
{

/**************************************************************************/
/* BEGIN SMARTY CONFIGURATION SECTION                                     */    
/* Set the following config variables to your liking.                     */
/**************************************************************************/

    // public vars
    var $template_dir    =  './templates';     // name of directory for templates  
    var $compile_dir     =  './templates_c';   // name of directory for compiled templates 
    var $config_dir      =  './configs';       // directory where config files are located

    var $global_assign   =  array( 'HTTP_SERVER_VARS' => array( 'SCRIPT_NAME' )
                                 );     // variables from the GLOBALS array
                                        // that are implicitly assigned
                                        // to all templates
    var $undefined       =  null;       // undefined variables in $global_assign will be
                                        // created with this value
    var $compile_check   =  true;       // whether to check for compiling step or not:
                                        // This is generally set to false once the
                                        // application is entered into production and
                                        // initially compiled. Leave set to true
                                        // during development. true/false default true.

    var $force_compile   =  false;      // force templates to compile every time.
                                        // if caching is on, a cached file will
                                        // override compile_check and force_compile.
                                        // true/false. default false.

    var $caching         =  false;      // whether to use caching or not. true/false
    var $cache_dir       =  './cache';  // name of directory for template cache
    var $cache_lifetime  =  3600;       // number of seconds cached content will persist.
                                        // 0 = never expires. default is one hour (3600)
    var $insert_tag_check    = true;    // if you have caching turned on and you
                                        // don't use {insert} tags anywhere
                                        // in your templates, set this to false.
                                        // this will tell Smarty not to look for
                                        // insert tags and speed up cached page
                                        // fetches.

    var $tpl_file_ext    =  '.tpl';     // template file extention

    var $php_handling    =  SMARTY_PHP_PASSTHRU;
                                        // how smarty handles php tags in the templates
                                        // possible values:
                                        // SMARTY_PHP_PASSTHRU -> echo tags as is
                                        // SMARTY_PHP_QUOTE    -> escape tags as entities
                                        // SMARTY_PHP_REMOVE   -> remove php tags
                                        // SMARTY_PHP_ALLOW    -> execute php tags
                                        // default: SMARTY_PHP_PASSTHRU

    var $left_delimiter  =  '{';        // template tag delimiters.
    var $right_delimiter =  '}';
    
    var $compiler_funcs  =  array(
                                 );

    var $custom_funcs    =  array(  'html_options'      => 'smarty_func_html_options',
                                    'html_select_date'  => 'smarty_func_html_select_date',
                                    'html_select_time'  => 'smarty_func_html_select_time',
                                    'math'              => 'smarty_func_math',
                                    'fetch'             => 'smarty_func_fetch'
                                 );
    
    var $custom_mods     =  array(  'lower'             => 'strtolower',
                                    'upper'             => 'strtoupper',
                                    'capitalize'        => 'ucwords',
                                    'escape'            => 'smarty_mod_escape',
                                    'truncate'          => 'smarty_mod_truncate',
                                    'spacify'           => 'smarty_mod_spacify',
                                    'date_format'       => 'smarty_mod_date_format',
                                    'string_format'     => 'smarty_mod_string_format',
                                    'replace'           => 'smarty_mod_replace',
                                    'strip_tags'        => 'smarty_mod_strip_tags',
                                    'default'           => 'smarty_mod_default',
                                    'count_characters'  => 'smarty_mod_count_characters',
                                    'count_words'       => 'smarty_mod_count_words',
                                    'count_sentences'   => 'smarty_mod_count_sentences',
                                    'count_paragraphs'  => 'smarty_mod_count_paragraphs'
                                 );
                                 
    var $version               =   '1.4.0';  // Smarty version number                     
    var $show_info_header      =   false;     // display HTML info header at top of page output

    var $compiler_class        =   'Smarty_Compiler'; // the compiler class used by
                                                      // Smarty to compile templates
    var $resource_funcs        =  array();  // what functions resource handlers are mapped to
    var $prefilter_funcs       =  array();  // what functions templates are prefiltered through
                                            // before being compiled

/**************************************************************************/
/* END SMARTY CONFIGURATION SECTION                                       */    
/* There should be no need to touch anything below this line.             */
/**************************************************************************/
    
    // internal vars
    var $_error_msg             =   false;      // error messages. true/false
    var $_tpl_vars              =   array();    // where assigned template vars are kept
    var $_smarty_md5            =   'f8d698aea36fcbead2b9d5359ffca76f'; // md5 checksum of the string 'Smarty'    
    

/*======================================================================*\
    Function: Smarty
    Purpose:  Constructor
\*======================================================================*/
    function Smarty()
    {
        foreach ($this->global_assign as $key => $var_name) {
            if (is_array($var_name)) {
                foreach ($var_name as $var) {
                    if (isset($GLOBALS[$key][$var])) {
                        $this->assign($var, $GLOBALS[$key][$var]);
                    } else {
                        $this->assign($var, $this->undefined);
                    }
                }
            } else {
                if (isset($GLOBALS[$var_name])) {
                    $this->assign($var_name, $GLOBALS[$var_name]);
                } else {
                    $this->assign($var_name, $this->undefined);
                }
            }
        }
    }


/*======================================================================*\
    Function:   assign()
    Purpose:    assigns values to template variables
\*======================================================================*/
    function assign($tpl_var, $value = NULL)
    {
        if (is_array($tpl_var)){
            foreach ($tpl_var as $key => $val) {
                if (!empty($key))
                    $this->_tpl_vars[$key] = $val;
            }
        } else {
            if (!empty($tpl_var) && isset($value))
                $this->_tpl_vars[$tpl_var] = $value;
        }
    }

    
/*======================================================================*\
    Function: append
    Purpose:  appens values to template variables
\*======================================================================*/
    function append($tpl_var, $value = NULL)
    {
        if (is_array($tpl_var)) {
            foreach ($tpl_var as $key => $val) {
                if (!empty($key)) {
                    if (!is_array($this->_tpl_vars[$key]))
                        settype($this->_tpl_vars[$key], 'array');
                    $this->_tpl_vars[$key][] = $val;
                }
            }
        } else {
            if (!empty($tpl_var) && isset($value)) {
                if (!is_array($this->_tpl_vars[$tpl_var]))
                    settype($this->_tpl_vars[$tpl_var], 'array');
                $this->_tpl_vars[$tpl_var][] = $value;
            }
        }
    }


/*======================================================================*\
    Function:   clear_assign()
    Purpose:    clear the given assigned template variable.
\*======================================================================*/
    function clear_assign($tpl_var)
    {
        if (is_array($tpl_var))
            foreach ($tpl_var as $curr_var)
                unset($this->_tpl_vars[$curr_var]);
        else
            unset($this->_tpl_vars[$tpl_var]);
    }

    
/*======================================================================*\
    Function: register_function
    Purpose:  Registers custom function to be used in templates
\*======================================================================*/
    function register_function($function, $function_impl)
    {
        $this->custom_funcs[$function] = $function_impl;
    }

/*======================================================================*\
    Function: unregister_function
    Purpose:  Unregisters custom function
\*======================================================================*/
    function unregister_function($function)
    {
        unset($this->custom_funcs[$function]);
    }

/*======================================================================*\
    Function: register_compiler_function
    Purpose:  Registers compiler function
\*======================================================================*/
    function register_compiler_function($function, $function_impl)
    {
        $this->compiler_funcs[$function] = $function_impl;
    }

/*======================================================================*\
    Function: unregister_compiler_function
    Purpose:  Unregisters compiler function
\*======================================================================*/
    function unregister_compiler_function($function)
    {
        unset($this->compiler_funcs[$function]);
    }
        
/*======================================================================*\
    Function: register_modifier
    Purpose:  Registers modifier to be used in templates
\*======================================================================*/
    function register_modifier($modifier, $modifier_impl)
    {
        $this->custom_mods[$modifier] = $modifier_impl;
    }

/*======================================================================*\
    Function: unregister_modifier
    Purpose:  Unregisters modifier
\*======================================================================*/
    function unregister_modifier($modifier)
    {
        unset($this->custom_mods[$modifier]);
    }

/*======================================================================*\
    Function: register_resource
    Purpose:  Registers a resource to fetch a template
\*======================================================================*/
    function register_resource($name, $function_name)
    {
        $this->resource_funcs[$name] = $function_name;
    }

/*======================================================================*\
    Function: unregister_resource
    Purpose:  Unregisters a resource
\*======================================================================*/
    function unregister_resource($name)
    {
        unset($this->resource_funcs[$name]);
    }

/*======================================================================*\
    Function: register_prefilter
    Purpose:  Registers a prefilter function to apply
              to a template before compiling
\*======================================================================*/
    function register_prefilter($function_name)
    {
        $this->prefilter_funcs[] = $function_name;
    }

/*======================================================================*\
    Function: unregister_prefilter
    Purpose:  Unregisters a prefilter
\*======================================================================*/
    function unregister_prefilter($function_name)
    {
        $tmp_array = array();
        foreach($this->prefilter_funcs as $curr_func) {
            if($curr_func != $function_name) {
                $tmp_array[] = $curr_func;
            }
        }
        $this->prefilter_funcs = $tmp_array;
    }
    
/*======================================================================*\
    Function:   clear_cache()
    Purpose:    clear cached content for the given template and cache id
\*======================================================================*/
    function clear_cache($tpl_file, $cache_id = null)
    {
        $cache_tpl_md5 = md5(realpath($this->template_dir.'/'.$tpl_file));
        $cache_dir = $this->cache_dir.'/'.$cache_tpl_md5;
        
        if (!is_dir($cache_dir))
            return false;

        if (isset($cache_id)) {
            $cache_id_md5 = md5($cache_id);
            $cache_id_dir = substr($cache_id_md5, 0, 2);
            $cache_file = "$cache_dir/$cache_id_dir/{$cache_tpl_md5}_$cache_id_md5.cache";
            return (bool)(is_file($cache_file) && unlink($cache_file));
        } else 
            return $this->_clear_tpl_cache_dir($cache_tpl_md5);
    }
    
    
/*======================================================================*\
    Function:   clear_all_cache()
    Purpose:    clear the entire contents of cache (all templates)
\*======================================================================*/
    function clear_all_cache()
    {
        if (!is_dir($this->cache_dir))
            return false;

        $dir_handle = opendir($this->cache_dir);
        while ($curr_dir = readdir($dir_handle)) {
            if ($curr_dir == '.' || $curr_dir == '..' ||
                !is_dir($this->cache_dir.'/'.$curr_dir))
                continue;

            $this->_clear_tpl_cache_dir($curr_dir);
        }
        closedir($dir_handle);

        return true;
    }


/*======================================================================*\
    Function:   is_cached()
    Purpose:    test to see if valid cache exists for this template
\*======================================================================*/
    function is_cached($tpl_file, $cache_id = null)
    {
        if (!$this->caching)
            return false;

        // cache name = template path + cache_id
        $cache_tpl_md5 = md5(realpath($this->template_dir.'/'.$tpl_file));
        $cache_id_md5 = md5($cache_id);
        $cache_id_dir = substr($cache_id_md5, 0, 2);
        $cache_file = $this->cache_dir."/$cache_tpl_md5/$cache_id_dir/{$cache_tpl_md5}_$cache_id_md5.cache";

        if (file_exists($cache_file) &&
            ($this->cache_lifetime == 0 ||
             (time() - filemtime($cache_file) <= $this->cache_lifetime)))
            return true;
        else
            return false;
        
    }
    
        
/*======================================================================*\
    Function:   clear_all_assign()
    Purpose:    clear all the assigned template variables.
\*======================================================================*/
    function clear_all_assign()
    {
        $this->_tpl_vars = array();
    }

/*======================================================================*\
    Function:   clear_compile_dir()
	Purpose:    clears compiled version of specified template resource,
				or all compiled template files if one is not specified.
                This function is for advanced use only, not normally needed.
\*======================================================================*/
    function clear_compile_dir($tpl_file = null)
    {
        if (!is_dir($this->compile_dir))
            return false;

		if (isset($tpl_file)) {
			// remove compiled template file if it exists
			$tpl_file = urlencode($tpl_file).'.php';
            if (file_exists($this->compile_dir.'/'.$tpl_file)) {
                unlink($this->compile_dir.'/'.$tpl_file);
			}
		} else {
			// remove everything in $compile_dir
        	$dir_handle = opendir($this->compile_dir);
        	while ($curr_file = readdir($dir_handle)) {
            	if ($curr_file == '.' || $curr_dir == '..' ||
                	!is_file($this->compile_dir.'/'.$curr_file)) {
                        continue;
                    }
            	unlink($this->compile_dir.'/'.$curr_file);
			}
        	closedir($dir_handle);
        }

        return true;
    }

/*======================================================================*\
    Function: get_template_vars
    Purpose:  Returns an array containing template variables
\*======================================================================*/
    function &get_template_vars()
    {
        return $this->_tpl_vars;
    }


/*======================================================================*\
    Function:   display()
    Purpose:    executes & displays the template results
\*======================================================================*/
    function display($tpl_file, $cache_id = null)
    {
        $this->fetch($tpl_file, $cache_id, true);
    }   
        
/*======================================================================*\
    Function:   fetch()
    Purpose:    executes & returns or displays the template results
\*======================================================================*/
    function fetch($tpl_file, $cache_id = null, $display = false)
    {
        global $HTTP_SERVER_VARS;

        if ($this->caching) {
            // cache name = template path + cache_id
            $cache_tpl_md5 = md5(realpath($this->template_dir.'/'.$tpl_file));
            $cache_id_md5 = md5($cache_id);
            $cache_id_dir = substr($cache_id_md5, 0, 2);
            $cache_file = $this->cache_dir."/$cache_tpl_md5/$cache_id_dir/{$cache_tpl_md5}_$cache_id_md5.cache";
            
            if (file_exists($cache_file) &&
                ($this->cache_lifetime == 0 ||
                 (time() - filemtime($cache_file) <= $this->cache_lifetime))) {
                $results = $this->_read_file($cache_file);
                if($this->insert_tag_check) {
                    $results = $this->_process_cached_inserts($results);
                }
                if ($display) {
                    echo $results;
                    return;
                } else {
                    return $results;
                }
            }
        }

        extract($this->_tpl_vars);

        if ($this->show_info_header) {
            $info_header = '<!-- Smarty '.$this->version.' '.strftime("%Y-%m-%d %H:%M:%S %Z").' -->'."\n\n";
        } else {
            $info_header = "";          
        }

        // if we just need to display the results, don't perform output
        // buffering - for speed
        if ($display && !$this->caching) {
            echo $info_header;
            $this->_process_template($tpl_file, $compile_path);
            include($compile_path);
        } else {
            ob_start();
            echo $info_header;
            $this->_process_template($tpl_file, $compile_path);
            include($compile_path);
            $results = ob_get_contents();
            ob_end_clean();
        }

        if ($this->caching) {
            $this->_write_file($cache_file, $results, true);
            $results = $this->_process_cached_inserts($results);
        }
                
        if ($display) {
            if (isset($results)) { echo $results; }
            return;
        } else {
            if (isset($results)) { return $results; }
        }
    }   

/*======================================================================*\
    Function:   _process_template()
    Purpose:    
\*======================================================================*/
    function _process_template($tpl_file, &$compile_path)
    {
        // get path to where compiled template is (to be) saved
        $this->_fetch_compile_path($tpl_file, $compile_path);

        // test if template needs to be compiled
        if (!$this->force_compile && $this->_compiled_template_exists($compile_path)) {
            if (!$this->compile_check) {
                // no need to check if the template needs recompiled
                return true;                
            } else {               
                // get template source and timestamp
                $this->_fetch_template_source($tpl_file, $template_source, $template_timestamp);
                if ($template_timestamp <= $this->_fetch_compiled_template_timestamp($compile_path)) {
                    // template not expired, no recompile
                    return true;
                } else {
                    // compile template
                    $this->_compile_template($tpl_file, $template_source, $template_compiled);
                    $this->_write_compiled_template($compile_path, $template_compiled);
                    return true;
                }
            }
        } else {
            // compiled template does not exist, or forced compile
            $this->_fetch_template_source($tpl_file, $template_source, $template_timestamp);
            $this->_compile_template($tpl_file, $template_source, $template_compiled);
            $this->_write_compiled_template($compile_path, $template_compiled);
            return true;
        }
    }    
    
/*======================================================================*\
    Function:   _fetch_compile_path()
    Purpose:    fetch the path to save the comiled template
\*======================================================================*/
    function _fetch_compile_path($tpl_file, &$compile_path)
    {
        // everything is in $compile_dir
        $compile_path = $this->compile_dir.'/'.urlencode($tpl_file).'.php';
        return true;
    }    

/*======================================================================*\
    Function:   _compiled_template_exists
    Purpose:    
\*======================================================================*/
    function _compiled_template_exists($include_path)
    {
        // everything is in $compile_dir
        return file_exists($include_path);
    }    

/*======================================================================*\
    Function:   _fetch_compiled_template_timestamp
    Purpose:    
\*======================================================================*/
    function _fetch_compiled_template_timestamp($include_path)
    {
        // everything is in $compile_dir
        return filemtime($include_path);
    }    

/*======================================================================*\
    Function:   _write_compiled_template
    Purpose:    
\*======================================================================*/
    function _write_compiled_template($compile_path, $template_compiled)
    {
        // we save everything into $compile_dir
        $this->_write_file($compile_path, $template_compiled);
        return true;
    }    

/*======================================================================*\
    Function:   _fetch_template_source()
    Purpose:    fetch the template source and timestamp
\*======================================================================*/
    function _fetch_template_source($tpl_path, &$template_source, &$template_timestamp)
    {
        // split tpl_path by the first colon
        $tpl_path_parts = explode(':', $tpl_path, 2);
        
        if (count($tpl_path_parts) == 1) {
            // no resource type, treat as type "file"
            $resource_type = 'file';
            $resource_name = $tpl_path_parts[0];
        } else {
            $resource_type = $tpl_path_parts[0];   
            $resource_name = $tpl_path_parts[1];
        }
        
        switch ($resource_type) {
            case 'file':
                if (!preg_match("/^([\/\\\\]|[a-zA-Z]:[\/\\\\])/",$resource_name)) {
                    // relative pathname to $template_dir
                    $resource_name = $this->template_dir.'/'.$resource_name;   
                }
                if (file_exists($resource_name)) {
                    $template_source = $this->_read_file($resource_name);
                    $template_timestamp = filemtime($resource_name);
                    return true;
                } else {
                    $this->_trigger_error_msg("unable to read template resource: \"$tpl_path.\"");
                    return false;
                }
                break;
            default:
                if (isset($this->resource_funcs[$resource_type])) {
                    $funcname = $this->resource_funcs[$resource_type];
                    if (function_exists($funcname)) {
                        // call the function to fetch the template
                        $funcname($resource_name, $template_source, $template_timestamp);
                        return true;
                    } else {
                        $this->_trigger_error_msg("function: resource function \"$funcname\" does not exist for resource type: \"$resource_type\".");
                        return false;
                    }
                } else {
                    $this->_trigger_error_msg("unknown resource type: \"$resource_type\". Register this resource first.");
                    return false;
                }
                break;
        }

        return true;
    }

        
/*======================================================================*\
    Function:   _compile_template()
    Purpose:    called to compile the templates
\*======================================================================*/
    function _compile_template($tpl_file, $template_source, &$template_compiled)
    {
        include_once "Smarty_Compiler.class.php";

        $smarty_compiler = new $this->compiler_class;

        $smarty_compiler->template_dir      = $this->template_dir;
        $smarty_compiler->compile_dir       = $this->compile_dir;
        $smarty_compiler->config_dir        = $this->config_dir;
        $smarty_compiler->force_compile     = $this->force_compile;
        $smarty_compiler->caching           = $this->caching;
        $smarty_compiler->php_handling      = $this->php_handling;
        $smarty_compiler->left_delimiter    = $this->left_delimiter;
        $smarty_compiler->right_delimiter   = $this->right_delimiter;
        $smarty_compiler->custom_funcs      = $this->custom_funcs;
        $smarty_compiler->custom_mods       = $this->custom_mods;
        $smarty_compiler->version           = $this->version;
        $smarty_compiler->prefilter_funcs      = $this->prefilter_funcs;
        $smarty_compiler->compiler_funcs    = $this->compiler_funcs;

        if ($smarty_compiler->_compile_file($tpl_file, $template_source, $template_compiled))
            return true;
        else {
            $this->_trigger_error_msg($smarty_compiler->_error_msg);
            return false;
        }
    }

/*======================================================================*\
    Function:   _smarty_include()
    Purpose:    called for included templates
\*======================================================================*/
    function _smarty_include($_smarty_include_tpl_file, $_smarty_include_vars,
                             &$_smarty_config_parent)
    {
        $_smarty_config = $_smarty_config_parent;
        $this->_tpl_vars = array_merge($this->_tpl_vars, $_smarty_include_vars);
        extract($this->_tpl_vars);
 
        $this->_process_template($_smarty_include_tpl_file, $compile_path);
        include($compile_path);
    }
        
/*======================================================================*\
    Function: _process_cached_inserts
    Purpose:  Replace cached inserts with the actual results
\*======================================================================*/
    function _process_cached_inserts($results)
    {
        preg_match_all('!'.$this->_smarty_md5.'{insert_cache (.*)}'.$this->_smarty_md5.'!Uis',
                       $results, $match);
        list($cached_inserts, $insert_args) = $match;

        for ($i = 0; $i < count($cached_inserts); $i++) {

            $args = unserialize($insert_args[$i]);

            $name = $args['name'];
            unset($args['name']);

            $function_name = 'insert_' . $name;
            $replace = $function_name($args);

            $results = str_replace($cached_inserts[$i], $replace, $results);
        }

        return $results;
    } 
    
/*======================================================================*\
    Function: _dequote
    Purpose:  Remove starting and ending quotes from the string
\*======================================================================*/
    function _dequote($string)
    {
        if (($string{0} == "'" || $string{0} == '"') &&
            $string{strlen($string)-1} == $string{0})
            return substr($string, 1, -1);
        else
            return $string;
    }

    
/*======================================================================*\
    Function:   _read_file()
    Purpose:    read in a file
\*======================================================================*/
    function _read_file($filename)

    {
        if (!($fd = fopen($filename, 'r'))) {
            $this->_trigger_error_msg("problem reading '$filename.'");
            return false;
        }
        flock($fd, LOCK_SH);
        $contents = fread($fd, filesize($filename));
        fclose($fd);
        return $contents;
    }

/*======================================================================*\
    Function:   _write_file()
    Purpose:    write out a file
\*======================================================================*/
    function _write_file($filename, $contents, $create_dirs = false)
    {
        if ($create_dirs)
            $this->_create_dir_structure(dirname($filename));
        
        if (!($fd = fopen($filename, 'a'))) {
            $this->_trigger_error_msg("problem writing '$filename.'");
            return false;
        }
        if (flock($fd, LOCK_EX) && ftruncate($fd, 0)) { 
            fwrite( $fd, $contents );
            fclose($fd);
            chmod($filename,0644);
        }

        return true;
    }    


/*======================================================================*\
    Function: _clear_tpl_cache_dir
    Purpose:  Clear the specified template cache
\*======================================================================*/
    function _clear_tpl_cache_dir($cache_tpl_md5)
    {
        $cache_dir = $this->cache_dir.'/'.$cache_tpl_md5;

        if (!is_dir($cache_dir))
            return false;

        $dir_handle = opendir($cache_dir);
        while ($curr_dir = readdir($dir_handle)) {
            $cache_path_dir = $cache_dir.'/'.$curr_dir;
            if ($curr_dir == '.' || $curr_dir == '..' ||
                !is_dir($cache_path_dir))
                continue;

            $dir_handle2 = opendir($cache_path_dir);
            while ($curr_file = readdir($dir_handle2)) {
                if ($curr_file == '.' || $curr_file == '..')
                    continue;

                $cache_file = $cache_path_dir.'/'.$curr_file;
                if (is_file($cache_file))
                    unlink($cache_file);
            }
            closedir($dir_handle2);
            @rmdir($cache_path_dir);
        }
        closedir($dir_handle);
        @rmdir($cache_dir);

        return true;
    }

/*======================================================================*\
    Function: _create_dir_structure
    Purpose:  create full directory structure
\*======================================================================*/
    function _create_dir_structure($dir)
    {
        if (!file_exists($dir)) {
            $dir_parts = preg_split('!/+!', $dir, -1, PREG_SPLIT_NO_EMPTY);
            $new_dir = ($dir{0} == '/') ? '/' : '';
            foreach ($dir_parts as $dir_part) {
                $new_dir .= $dir_part;
                if (!file_exists($new_dir) && !mkdir($new_dir, 0701)) {
                    $this->_trigger_error_msg("problem creating directory \"$dir\"");
                    return false;               
                }
                $new_dir .= '/';
            }
        }
    }    
    
/*======================================================================*\
    Function:   quote_replace
    Purpose:    Quote subpattern references
\*======================================================================*/
    function quote_replace($string)
    {
        return preg_replace('![\\$]\d!', '\\\\\\0', $string);
    }


/*======================================================================*\
    Function: _trigger_error_msg
    Purpose:  trigger Smarty error
\*======================================================================*/
    function _trigger_error_msg($error_msg, $error_type = E_USER_WARNING)
    {
        trigger_error("Smarty error: $error_msg", $error_type);
    }

}

/* vim: set expandtab: */

?>
