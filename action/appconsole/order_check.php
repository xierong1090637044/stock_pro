<?php
  include_once '../../lib/Bmob/BmobObject.class.php';

  $id = $_POST["id"];
  $type = $_POST["type"];

  if($type == 1)
  {
      $object = new BmobObject("order");
      $object->update($id, array("ischeck"=>"refuse"));
  }elseif ($type == 0) {
      $object = new BmobObject("order");
      $object->update($id, array("ischeck"=>"true"));
  }
?>
