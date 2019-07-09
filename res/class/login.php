<?php
    header("Content-Type:text/html;   charset=utf-8");//防止乱码
    include_once '../weixin.class.php';
    include_once '../lib/Bmob/BmobUser.class.php';
    include_once '../lib/Bmob/BmobObject.class.php';

    $bmobObj = new BmobObject("_User");
    $username = "啦啦啦、岁月无恙";//模拟微信登录暂时要设置用户名

    if($username !="")
    {
        $res=$bmobObj->get("",array('where={"username":'."\"".$username."\"".'}'));
        $objectid = $res->results[0]->objectId;
        $expire=time()+60*60*24*30;
        setcookie("objectId", $objectid, $expire);
    }else {
        $weixin = new class_weixin();
        if (!isset($_GET["code"])){
    		$redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		$jumpurl = $weixin->oauth2_authorize($redirect_url, "snsapi_userinfo", "123");
    		Header("Location: $jumpurl");
    	}else{
            $access_token_oauth2 = $weixin->oauth2_access_token($_GET["code"]);
    		$userinfo = $weixin->oauth2_get_user_info($access_token_oauth2['access_token'], $access_token_oauth2['openid']);
    		$name = $userinfo["nickname"];

            $res=$bmobObj->get("",array('where={"username":'."\"".$name."\"".'}'));

            $objectid = $res->results[0]->objectId;
            $expire=time()+60*60*24*30;
            setcookie("objectId", $objectid, $expire);
        }
    }

?>
