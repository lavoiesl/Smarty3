<?php 

function smarty_function_tag($params, &$smarty) { 
  $params = array_merge(array(
    'tag'   => 'null',
    'text'  => null,
    ),$params);

    if (strlen($params['tag']) == 0) 
      return false;

    $empty_attr = true;
    $close_tag = false; 
    $tag = $params['tag'];
    $text = $params['text'];

    unset($params['tag'], $params['text']);

    $attrs = array($tag);
    foreach ($params as $attr => $value) {
      if (is_null($value)) continue;
      if ($value === false) {
        $attrs[] = $empty_attr ? $attr : "$attr=\"$attr\"";
      } else {
        $attrs[] = "$attr=\"$value\"";
      }
    }

    $return = "<" . implode(" ", $attrs);
    if (is_null($text)) {
      $return .= $close_tag ? " />" : ">";
    } else {
      $return .= ">$text</$tag>";
    }

    return $return;
} 

