<?php

function smarty_modifier_autolink($text) {
  $text = preg_replace("/((http|https|ftp):\/\/(\S*?\.\S*?))(\W\s)/ie",
    "'<a href=\"$1\" target=\"_blank\">$3</a>$4'",
    $text
  );
  $text = preg_replace("/^[A-Z0-9\._%\+\-]+@[A-Z0-9\.\-]+\.(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/i",
    "'<a href=\"mailto:$0\" target=\"_blank\">$0</a>'",
    $text
  );
  return $text;
}