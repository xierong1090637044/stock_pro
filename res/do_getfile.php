<?php
header("content-type:text/html;charset=utf-8");
include_once '../lib/Bmob/BmobObject.class.php';
include_once '../lib/Bmob/BmobUser.class.php';

$userid = $_REQUEST["userid"];
var_dump($userid);
addExcel();
//接收前台文件
function addExcel()
{
	//接收前台文件
	$ex = $_FILES['file'];
	//重设置文件名
	$filename = time() . substr($ex['name'], stripos($ex['name'], '.'));
	$path = 'upload/' . $filename;//设置移动路径
	move_uploaded_file($ex['tmp_name'], $path);
	//表用函数方法 返回数组
	$exfn = _readExcel($path); // 读取内容
	upload_file($exfn, $path); // 上传数据 
}

//创建一个读取excel数据，可用于入库
function _readExcel($path)
{
	//引用PHPexcel 类
	include_once('PHPExcel.php');
	include_once('PHPExcel/IOFactory.php');//静态类
	$type = 'Excel2007';//设置为Excel5代表支持2003或以下版本，Excel2007代表2007版
	$xlsReader = PHPExcel_IOFactory::createReader($type);
	$xlsReader->setReadDataOnly(true);
	$xlsReader->setLoadSheetsOnly(true);
	$Sheets = $xlsReader->load($path);
	//开始读取上传到服务器中的Excel文件，返回一个二维数组
	$dataArray = $Sheets->getSheet(0)->toArray();
	return $dataArray;
}

//将数据以json格式输出
function upload_file($data, $path)
{
	//global $db;
	$arr = array();
	array_push($arr, $data[0]);
	//删除第一项
	unset($data[0]);
	//$sql = 'insert into media_platform (user,phone,passwd,head,nickname,platform) values (?,?,?,?,?,?)';
	//$stmt = $db->prepare($sql);
	foreach ($data as $v) {
		  
			$goodsName = (string)$v[0];
			$costPrice = (string)$v[1];
			$retailPrice = (string)$v[2];
			$reserve = (int)$v[3];
			$packingUnit = $v[4];
			$productCode = $v[5];
			$userid = $_REQUEST["userid"];
			
			$bmobObj = new BmobObject("Goods");
			$res=$bmobObj->addRelPointer(array(array("userId","_User",$userid)));//添加关联关系
			$res=$bmobObj->update($res->objectId,array("retailPrice"=>$retailPrice,"costPrice"=>$costPrice,"goodsName"=>$goodsName,"reserve"=>$reserve,"productCode"=>$productCode,"packingUnit"=>$packingUnit)); //添加对象
	}
	$result=array("code"=>"1","msg"=>"上传成功");
	echo json_encode($result);
	unlink($path); // 上传完文件之后删除文件，避免造成垃圾文件的堆积
}

?>