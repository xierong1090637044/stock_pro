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
    $skipnum = ($curr - 1)*10;

    $data = $_REQUEST["data"];
    $datas = explode("-", $data);
    $max_data = cal_days_in_month(CAL_GREGORIAN, $datas[1], $datas[0]);
    $min_selected = $data."-01 00:00:00";
    $max_selected = $data."-".$max_data." 23:59:59";

    $bmobObj = new BmobObject("order_opreations");
    $bmobBills = new BmobObject("Bills");
    //$res1=$bmobObj->get("",array('where={"$and",[{"userId":{"$all",'."\"".$userid."\"".'}},{"$all","type":{-1}}]}','order=-createdAt'));
    $res1=$bmobObj->get("",array('where={"$and":[{"master":'."\"".$userid."\"".'},{"createdAt":{"$gte":{"__type": "Date", "iso": '."\"".$min_selected."\"".'}}},{"createdAt":{"$lte":{"__type": "Date", "iso": '."\"".$max_selected."\"".'}}}]}','order=-createdAt','include=custom,opreater'));

    $data1 = array();
    $result2 = $res1->results;

    for ($i=0; $i < count($result2); $i++) {
        $temp_bills = [];
        $object2 = new stdClass();
        $object2->id = $result2[$i]->objectId;
        $object2->type = ($result2[$i]->type == 1)?"入库":"出库";
        $object2->opreater = $result2[$i]->opreater->username;
        $object2->custom = $result2[$i]->custom->custom_name;
        $object2->all_money = $result2[$i]->all_money;
        $object2->real_money = $result2[$i]->real_money;
        $object2->debt = $result2[$i]->debt;
        $object2->beizhu = $result2[$i]->beizhu;

        $res_relation = $bmobBills->get("",array('where={"$relatedTo":{"object":{"__type":"Pointer","className":"order_opreations","objectId":'."\"".$result2[$i]->objectId."\"".'},"key":"relations"}}'));
        $relation_bills = $res_relation->results;
        for ($j=0; $j < count($relation_bills) ; $j++) {
            array_push($temp_bills,$relation_bills[$j]->objectId);
        }
        $object2->bills_relation = str_replace(',', ' ', implode(",", $temp_bills));

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
