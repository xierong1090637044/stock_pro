<?php
    error_reporting(E_ALL^E_NOTICE);
    include_once '../lib/Bmob/BmobObject.class.php';
    include_once '../lib/Bmob/BmobUser.class.php';

    $curr = $_REQUEST["curr"];
    $userid = $_REQUEST["userid"];
    $skipnum = ($curr - 1)*10;

    $bmobObj = new BmobObject("Goods");
    $res1=$bmobObj->get("",array('where={"userId":'."\"".$userid."\"".'}','order=-createdAt','limit=500'));

    $data1 = array();

   
    if(count($res1->results) == 500)
    {
        $bmobObj = new BmobObject("Goods");
        $res2=$bmobObj->get("",array('where={"userId":'."\"".$userid."\"".'}','order=-createdAt','limit=500','skip=500'));
        $result1 = array_merge($res1->results,$res2->results);
    }else{
        $result1 = $res1->results;
    }

    for ($i=0; $i < count($result1); $i++) {
        $object2 = new stdClass();
        $object2->id = $result1[$i]->objectId;
        $object2->name = $result1[$i]->goodsName;
        $object2->image = ($result1[$i]->goodsIcon == null )?null:$result1[$i]->goodsIcon;
        //$object2->long_pic = $result1[$i]->single_code;
        $object2->costPrice = $result1[$i]->costPrice;
        $object2->retailPrice = $result1[$i]->retailPrice;
        $object2->reserve = $result1[$i]->reserve;
        $object2->packingUnit = ($result1[$i]->packingUnit == null)?"":$result1[$i]->packingUnit;
        $object2->packageContent = ($result1[$i]->packageContent == null)?"":$result1[$i]->packageContent;
        $object2->packModel = ($result1[$i]->packModel == null)?"":$result1[$i]->packModel;
        $object2->regNumber = $result1[$i]->regNumber;
        $object2->createdTime = $result1[$i]->createdAt;
        $data1[$i] = $object2;
    }

    $arr = array();
    $arr["code"] = 0;
    $arr["msg"] = "";
    $arr["count"] = count($result1);
    $arr["data"] = $data;
    $arr["alldata"] = $data1;

    echo json_encode($arr);
?>
