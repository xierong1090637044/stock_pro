<?php
    error_reporting(E_ALL^E_NOTICE);
    include_once '../lib/Bmob/BmobObject.class.php';
    include_once '../lib/Bmob/BmobUser.class.php';

    if (!function_exists('cal_days_in_month'))
    {
        function cal_days_in_month($calendar, $month, $year)
        {
            return date('t', mktime(0, 0, 0, $month, 1, $year));
        }
    } 

    $curr = $_REQUEST["curr"];
    $userid = $_REQUEST["userid"];
    $data = $_REQUEST["data"];
    $datas = explode("-", $data);

    $max_data = cal_days_in_month(CAL_GREGORIAN, $datas[1], $datas[0]);
    $min_selected = $data."-01 00:00:00";
    $max_selected = $data."-".$max_data." 23:59:59";

    $skipnum = ($curr - 1)*10;

    $bmobObj = new BmobObject("Bills");
    //$res1=$bmobObj->get("",array('where={"$and",[{"userId":{"$all",'."\"".$userid."\"".'}},{"$all","type":{-1}}]}','order=-createdAt'));
    $res1=$bmobObj->get("",array('where={"$and":[{"userId":'."\"".$userid."\"".'},{"type":-1},{"createdAt":{"$gte":{"__type": "Date", "iso": '."\"".$min_selected."\"".'}}},{"createdAt":{"$lte":{"__type": "Date", "iso": '."\"".$max_selected."\"".'}}}]}','order=-createdAt'));

    $data1 = array();
    $result2 = $res1->results;

    for ($i=0; $i < count($result2); $i++) {
        $object2 = new stdClass();
        $object2->id = $result2[$i]->objectId;
        $object2->name = $result2[$i]->goodsName;
        //$object2->pic = ($result2[$i]->goodsIcon == null )?null:$result2[$i]->goodsIcon;
        //$object2->long_pic = $result2[$i]->single_code;
        $object2->retailPrice = $result2[$i]->retailPrice;
        $object2->num = $result2[$i]->num;
        $object2->total_money = $result2[$i]->total_money;
        $object2->createdAt = $result2[$i]->createdAt;
        $data1[$i] = $object2;
    }

    $arr = array();
    $arr["code"] = 0;
    $arr["msg"] = "";
    $arr["count"] = count($res1->results);
    $arr["data"] = $data;
    $arr["alldata"] = $data1;

    echo json_encode($arr);
?>
