Input form for parser testing <BR>
<form name="Testparser" action="test_parser.php{if isset($smarty.request.XDEBUG_PROFILE)}?XDEBUG_PROFILE{/if}" method="post">
<strong>Template input</strong>
<textarea name="template" rows="10" cols="60">{$template|escape}</textarea> 
<input name="Update" type="submit" value="Update">
</form >

