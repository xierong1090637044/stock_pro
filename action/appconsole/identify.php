<?php
    include_once '../../lib/Bmob/BmobObject.class.php';
    include_once '../../lib/Bmob/BmobUser.class.php';

    $masterKey = "b08344302e157680c76af7cde677957f";

    $User = new BmobUser();

    $id = $_POST["id"];
    $type = $_POST["type"];

    if($type == 1)
    {
        $object = new BmobObject("identify");
        $res=$object->get($id);
        $parentid = $res->parent->objectId;
        $parent_user = $bmobUser->get($parentid);//得到此条的记录的用户信息

        $User->updateByMasterKey($parentid, $masterKey,array("identity"=>"未通过"));
        $object->delete($id);
   }elseif ($type == 0) {
        $object = new BmobObject("identify");
        $res=$object->get($id);
        $parentid = $res->parent->objectId;

        $User->updateByMasterKey($parentid, $masterKey,array("identity"=>"大学生/毕业生"));
        $object->update($id,array("isactive"=>"false"));
    }elseif ($type == 3) {
        $parent= new BmobObject("parent_identify");
        $res=$parent->get($id);
        $parentid = $res->parent->objectId;

        $User->updateByMasterKey($parentid, $masterKey,array("identity"=>"未通过"));
        $parent->delete($id);
    }elseif ($type == 4) {
        $parent= new BmobObject("parent_identify");
        $res=$parent->get($id);
        $parentid = $res->parent->objectId;

        $User->updateByMasterKey($parentid, $masterKey,array("identity"=>"家长"));
        $parent->update($id,array("isactive"=>"false"));
    }
?>
