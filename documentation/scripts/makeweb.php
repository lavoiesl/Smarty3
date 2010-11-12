<?php

// make website templates from HTML pages
// open the current directory

$langdir = dirname(__FILE__).'/../'.$argv[1];
$webdir = !empty($argv[2]) ? dirname(__FILE__).'/../'.$argv[2] : dirname(__FILE__).'/../htmlweb';

if(empty($argv[1]))
  die("usage: {$argv[0]} [manual-dir]\n");
if(!is_dir($langdir))
  die("manual dir ({$langdir})) must exist\n");

if(!is_dir($webdir))
  mkdir($webdir)||die("unable to make dir ({$webdir})\n");

$dhandle = new RecursiveDirectoryIterator($langdir);

foreach (new RecursiveIteratorIterator($dhandle) as $fpath) {
     if(substr($fpath,-4)=='.tpl') {
        $content = file_get_contents($fpath);
	$fname = basename($fpath);
	preg_match('!<title>(.*?)</title>!s',$content,$match);
	$title = $match[1];
	preg_match('!<body[^>]*>(.*?)</body>!s',$content,$match);
	$body = $match[1];
        $body = str_replace(array('{','}','@@LDELIM@@','@@RDELIM@@'),array('@@LDELIM@@','@@RDELIM@@','{ldelim}','{rdelim}'),$body);
        $title = str_replace(array('{','}','@@LDELIM@@','@@RDELIM@@'),array('@@LDELIM@@','@@RDELIM@@','{ldelim}','{rdelim}'),$title);
        // fix link filenames, remove .tpl
	$body = preg_replace('!href="(.*)\.tpl(#.*)?"!','href="$1$2"',$body);
        $template = "{extends file='layout.tpl'}\n{block name=title}@TITLE@{/block}{block name=main_content}@BODY@{/block}";
        $template = str_replace(array('@TITLE@','@BODY@'),array($title,$body),$template);
	if(!is_dir($webdir))
          mkdir($webdir,0755,true);
        file_put_contents($webdir.'/'.$fname,$template);
     }
}

?>
