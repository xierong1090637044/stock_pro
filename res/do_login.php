<?php
    include_once '../lib/Bmob/BmobObject.class.php';
    include_once '../lib/Bmob/BmobUser.class.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    $bmobUser = new BmobUser();
    $bmobObj = new BmobObject("_User");

    $message = [];

    try {
        $user_info=$bmobObj->get($username);
    } catch (\Exception $e) {
        array_push($message,"账户名或者密码不正确",false);
        echo json_encode($message);
        return;
    }

    try {
        $res = $bmobUser->login("$user_info->username","$password");
        array_push($message,$res->objectId,true);
        echo json_encode($message);
    } catch (\Exception $e) {
        array_push($message,"账户名或者密码不正确",false);
        echo json_encode($message);
    }



?>
