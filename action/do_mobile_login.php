<?php
  include_once '../lib/Bmob/BmobSms.class.php';

  $bmobSms = new BmobSms();
  $type = $_POST["type"];

  if($type == 0 )
  {
      try {
          $phonenumber = $_POST["phonenumber"];
          $res = $bmobSms->sendSmsVerifyCode($phonenumber, "领英");
          if($res->smsId !=null)
          {
              $res = json_encode("success");
              echo $res;
          }
      } catch (\Exception $e) {
          $res = json_encode("fail");
          echo $res;
      }
  }
  elseif ($type == 1) {
      $phonenumber = $_POST["phonenumber"];
      $code = $_POST["code"];
      try {
          $res = $bmobSms->verifySmsCode($phonenumber,$code);
          if($res->msg =="ok")
          {
              $res = json_encode("success");
              echo $res;
          }else {
              $res = json_encode("fail");
              echo $res;
          }
      } catch (\Exception $e) {
          $res = json_encode("fail");
          echo $res;
      }
  }


?>
