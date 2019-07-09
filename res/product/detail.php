<?php
    //error_reporting(E_ALL^E_NOTICE);
    include_once '../../lib/Bmob/BmobObject.class.php';
    include_once '../../lib/Bmob/BmobUser.class.php';

    $product_id = $_REQUEST["product_id"];

    $bmobObj = new BmobObject("Goods");
    $res=$bmobObj->get($product_id);

    $arr = array();
    $arr["code"] = 0;
    $arr["msg"] = "ok";
    $arr["data"] = $res;

    echo json_encode($arr);
?>
