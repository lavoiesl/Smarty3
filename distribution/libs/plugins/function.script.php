<?php 

function smarty_function_script($params, &$smarty) { 
  $params = array_merge(array(
    'src'   => null,
    'type'  => null,
    'tag'   => 'script',
    'text'  => "",
    ), $params);
    if (strlen($params['src']) == 0) 
      return false;
    else {
      if (!empty($_GET['debug'])) {
        $params['src'] .= "?debug=1";
      }
      $smarty->loadPlugin("smarty_function_tag");
      return smarty_function_tag($params, $smarty);
    }
} 
