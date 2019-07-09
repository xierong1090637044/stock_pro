<?php
    //error_reporting(E_ALL^E_NOTICE);
    include_once '../../lib/Bmob/BmobObject.class.php';
    include_once '../../lib/Bmob/BmobUser.class.php';

    $goodsIcon = $_REQUEST["goodsIcon"];
    $goodsName = $_REQUEST["goodsName"];
    $goodsClass = $_REQUEST["goodsClass"];
    $costPrice = (string)$_REQUEST["costPrice"];
    $retailPrice = (string)$_REQUEST["retailPrice"];
    $producttime = (int)$_REQUEST["producttime"];
    $nousetime = (int)$_REQUEST["nousetime"];
    $reserve = (int)$_REQUEST["reserve"];
    $warning_num = (int)$_REQUEST["warning_num"];
    $regNumber = $_REQUEST["regNumber"];
    $productCode = $_REQUEST["productCode"];
    $product_info = $_REQUEST["product_info"];
    $producer = $_REQUEST["producer"];
    $userid = $_REQUEST["userid"];

    $bmobObj = new BmobObject("Goods");
    $res=$bmobObj->addRelPointer(array(array("userId","_User",$userid)));//添加关联关系
    $res=$bmobObj->update($res->objectId,array("nousetime_t"=>$nousetime,"producttime_t"=>$producttime,"regNumber"=>$regNumber,"warning_num"=>$warning_num,"retailPrice"=>$retailPrice,"costPrice"=>$costPrice,"goodsName"=>$goodsName,"reserve"=>$reserve,"goodsIcon"=>$goodsIcon,"product_info"=>$product_info,"producer"=>$producer,"productCode"=>$productCode)); //添加对象


    $arr = array();
    $arr["code"] = 0;
    $arr["msg"] = "ok";
    $arr["data"] = $res;

    echo json_encode($arr);
?>
