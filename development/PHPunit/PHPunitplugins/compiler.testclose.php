<?php
// compiler.testclose.php
class smarty_compiler_testclose extends Smarty_Internal_CompileBase
{
    public function execute($args, $compiler)
    {
        $this->compiler=$compiler;

        $this->_close_tag('test');

        return '';
    }

}

?>
