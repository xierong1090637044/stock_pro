<?php
include_once '../lib/Bmob/BmobObject.class.php';
include_once '../lib/Bmob/BmobUser.class.php';
class GetOptions{

    public function __construct($id){
        $this->userid = $id; //用户id
    }

    //商品列表
	public function getClass() {
        $bmobObj = new BmobObject("class_user");
        $res=$bmobObj->get("",array('where={"parent":'."\"".$this->userid."\"".'}'));
        return $res;
	}

}

