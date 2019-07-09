<?php
require_once '../lib/Bmob/BmobUser.class.php';
require_once '../lib/Bmob/BmobObject.class.php';

class GetUser {

  public function __construct($id)
  {
      $this->id = $id;

      $bmobObj = new BmobObject("_User");
      $result=$bmobObj->get("",array('where={"mobilePhoneNumber":'."\"".$this->id."\"".'}'));
      $this->res=$result->results[0];
  }

  public function nickname() {
      return $this->res->username;
  }

  public function avatar() {
     return $this->res->avatar;
  }

  public function appconsole() {
     return $this->res->appconsole;
  }

  private $id;

}
?>
