<?php 

function smarty_function_stylesheet($params, &$smarty) { 
  $params = array_merge(array(
    'rel'   => "stylesheet",
    'href'  => null,
    'media' => null,
    'type'  => null,
    'tag'   => 'link',
    'text'  => null,
    ), $params);
    if (strlen($params['href']) == 0) 
      return false;
    else {
      if (!empty($_GET['debug'])) {
        $params['href'] .= "?debug=1";
      }
      $smarty->loadPlugin("smarty_function_tag");
      return smarty_function_tag($params, $smarty);
    }
} 
