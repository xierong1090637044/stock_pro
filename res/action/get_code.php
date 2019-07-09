<?php

/****/
class Code
{

    function __construct($content)
    {
        header("Content-Type:text/html;charset=UTF-8");
        date_default_timezone_set("PRC");
        $showapi_appid = '66939';  //替换此值,在官网的"我的应用"中找到相关值
        $this->showapi_secret = '8741e2d8bba64bed81f7a27dacd63189';  //替换此值,在官网的"我的应用"中找到相关值
        $this->paramArr = array(
            'showapi_appid'=> $showapi_appid,
            'content'=> $content,
            'size'=> "5",
            'imgExtName'=> "jpg"
            //添加其他参数
        );
    }

    public function createParam ($paramArr,$showapi_secret) {
        $paraStr = "";
        $signStr = "";
        ksort($this->paramArr);
        foreach ($this->paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $signStr .= $key.$val;
                $paraStr .= $key.'='.urlencode($val).'&';
            }
        }
        $signStr .= $this->showapi_secret;//排好序的参数加上secret,进行md5
        $sign = strtolower(md5($signStr));
        $paraStr .= 'showapi_sign='.$sign;//将md5后的值作为参数,便于服务器的效验
        return $paraStr;
    }

    public function getcodeimg()
    {
        $param = $this->createParam($this->paramArr,$this->showapi_secret);
        $url = 'http://route.showapi.com/887-1?'.$param;
        $result = file_get_contents($url);
        $result = json_decode($result);
        return $result->showapi_res_body->imgUrl;
    }
}
?>
