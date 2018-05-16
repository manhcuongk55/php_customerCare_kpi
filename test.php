<?php
if(isset($_POST)) {
  var_dump($_POST);
}
?>
<form action="" method="POST">
  <input type="radio" name="test1[]" value="0" checked="true">
  <input type="radio" name="test1[]" value="1" >
  <input type="radio" name="test2[]" value="0" checked="true">
  <input type="radio" name="test2[]" value="1" >
  <input type="submit" name="cmd" value="OK">
</form>