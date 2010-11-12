<?php
function smarty_insert_insertplugintest($params,$smarty,$template){
   global $insertglobal;
   return 'param foo '.$params['foo'].' globalvar '.$insertglobal;
}
?>