<?php
    include_once '../lib/Bmob/BmobObject.class.php';

    $id = $_POST["id"];
    $type = $_POST["type"];
    $object = $_POST["object"];

    if($type == "delete")
    {
        $object = new BmobObject($object);
        $object->delete($id);

        echo true;
   }
?>
