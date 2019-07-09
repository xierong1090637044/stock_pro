<?php
  include_once '../../lib/Bmob/BmobObject.class.php';
  include_once '../../lib/Bmob/BmobUser.class.php';

  $bmobObj = new BmobObject("student");

  $number = $_POST["number"];

  $result = json_encode($bmobObj->get('','',"limit=20*$number"));
  echo $result;

?>
