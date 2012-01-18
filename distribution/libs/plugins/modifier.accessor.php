<?php
function smarty_modifier_accessor($entity, $field) { 
  if (!$entity) return false;
  if (!method_exists($entity, $m = "get_$field")) return false;
  return $entity->$m();
} 
