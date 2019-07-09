<?php

define('APPID',         	"wxcae7e19d9799a9d3");
define('APPSECRET',        	"7da130fb94bccf11736a823ec21a94ad");

class class_weixin
{
    var $appid = APPID;
    var $appsecret = APPSECRET;

    //构造函数，获取Access Token
    public function __construct($appid = NULL, $appsecret = NULL)
    {
        if($appid && $appsecret){
            $this->appid = $appid;
            $this->appsecret = $appsecret;
        }

        if (isset($_SERVER['HTTP_APPNAME'])){		//SAE环境，需要开通memcache
			//1. 缓存形式
            $mem = memcache_init();
			$this->access_token = $mem->get($this->appid);
			if (!isset($this->access_token) || empty($this->access_token)){
				$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
				$res = $this->http_request($url);
				$result = json_decode($res, true);
				$this->access_token = $result["access_token"];
				$mem->set($this->appid, $this->access_token, 0, 3600);
			}
        }else {										//当前目录有写权限的环境
            //2. 本地写入
			$res = file_get_contents('../token.json');
			$result = json_decode($res, true);
			$this->expires_time = $result["expires_time"];
			$this->access_token = $result["access_token"];

			if (time() > ($this->expires_time + 3600)){
				$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
				$res = $this->http_request($url);
				$result = json_decode($res, true);
				$this->access_token = $result["access_token"];
				$this->expires_time = time();
				file_put_contents('../token.json', '{"access_token": "'.$this->access_token.'", "expires_time": '.$this->expires_time.'}');
			}
        }
    }

    /*
    测试接口，获取微信服务器IP地址
    */
    public function get_callback_ip()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$this->access_token;
        $res = $this->http_request($url);
        return json_decode($res, true);
    }

    /*
    *  PART1 网页授权部分
    */

    //生成OAuth2的URL
    public function oauth2_authorize($redirect_url, $scope, $state = NULL)
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_url."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
        return $url;
    }

    //生成OAuth2的Access Token
    public function oauth2_access_token($code)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->appsecret."&code=".$code."&grant_type=authorization_code";
        $res = $this->http_request($url);
        return json_decode($res, true);
    }

    //获取用户基本信息（OAuth2 授权的 Access Token 获取 未关注用户，Access Token为临时获取）
    public function oauth2_get_user_info($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->http_request($url);
        return json_decode($res, true);
    }

    //获取用户基本信息（全局Access Token 获取 已关注用户，注意和OAuth时的区别）
    public function get_user_info($openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->http_request($url);
        return json_decode($res, true);
    }

    //HTTP请求（支持HTTP/HTTPS，支持GET/POST）
    protected function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 500000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('Y-m-d H:i:s').$log_content."\r\n", FILE_APPEND);
        }
    }
}
