<?php
    include_once '../lib/Bmob/BmobFile.class.php';
    ini_set('upload_max_filesize', '5m');

    header('Content-Type:application/json');//这个类型声明非常关键
    $result = new \stdClass;

    $type = $_POST["type"];

    if ($type == "upload") {
        $image = $_POST["image"];
        $name = $_POST["name"];

        $bmobFile = new BmobFile();
        //第一个参数是文件的名称,第二个参数是文件的url(可以是本地路径,最终是通过file_get_contents获取文件内容)
        $res=$bmobFile->uploadFile2($name,$image);

        $result->state = true;
        $result->url = $res->url;
        $result->filename = $res->filename;

        echo json_encode($result);
    }
    elseif ($type == "delete") {
        $image = $_POST["image"];

        $bmobFile = new BmobFile();
        $res=$bmobFile->delete2("upyun",$image);

        echo true;
    }

?>
