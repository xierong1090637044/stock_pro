<?php

/*** 登录操作*/
class Dologin
{

    function __construct()
    {
        // code...
    }

    public function getuser()
    {

        $bmobUser = new BmobUser();
        $username = $_COOKIE["username"];
        $password = $_COOKIE["password"];

        if($username ==null || $password ==null)
        {
            $weixin = new class_weixin();

            if (!isset($_GET["code"])){
        		$redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        		$jumpurl = $weixin->oauth2_authorize($redirect_url, "snsapi_userinfo", "123");
        		Header("Location: $jumpurl");
        	}else{
                $access_token_oauth2 = $weixin->oauth2_access_token($_GET["code"]);
        		$userinfo = $weixin->oauth2_get_user_info($access_token_oauth2['access_token'], $access_token_oauth2['openid']);
        		$name = $userinfo["nickname"];
        		$password = $userinfo["openid"];
                $city = $userinfo["city"];
                $province = $userinfo["province"];

                $expire=time()+60*60*24*30;
                setcookie("username", $name, $expire);
                setcookie("password", $password, $expire);

                try {
                    $res = $bmobUser->register(array("username"=>$userinfo["nickname"], "password"=>$userinfo["openid"],"openid"=>$userinfo["openid"],"avatar"=>str_replace("/0","/46",$userinfo["headimgurl"]),"sex"=>$userinfo["sex"],"city"=>$province.$city));

                    return $res;
                } catch (Exception $e) {
                    $res = $bmobUser->login($name,$password);

                    return $res;
                }
            }
        }else {
            $res = $bmobUser->login($username,$password);

            return $res;
        }
    }
}
?>
