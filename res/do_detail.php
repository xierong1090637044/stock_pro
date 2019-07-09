<?php
include_once '../lib/BmobObject.class.php';
include_once '../lib/BmobUser.class.php';

    $type = $_POST["type"];
    if($type ==1)
    {
      $bmobObj1 = new BmobObject("money1");
      $money1=$bmobObj1->get("",array('where={"state":true}','limit=1','order=-createdAt'))->results;
      if($money1 != null)   {
        $linkurl1 = $money1[0]->url;
        $objectid1 = $money1[0]->objectId;

        $bmobObj1->delete($objectid1);
        echo $linkurl1;
      }else {
        $linkurl1 = null;
        echo false;
      }
    }elseif ($type ==2){
      $bmobObj2 = new BmobObject("money2");
      $money2=$bmobObj2->get("",array('where={"state":true}','limit=1','order=-createdAt'))->results;
      if($money2 != null)   {
        $linkurl2 = $money2[0]->url;
        $objectid2 = $money2[0]->objectId;

        $bmobObj2->delete($objectid2);
        echo $linkurl2;
      }else {
        $linkurl2 = null;
        echo false;
      }
    }elseif ($type ==3) {
      $bmobObj3 = new BmobObject("money3");
      $money3=$bmobObj3->get("",array('where={"state":true}','limit=1','order=-createdAt'))->results;
      if($money3 != null)   {
        $linkurl3 = $money3[0]->url;
        $objectid3 = $money3[0]->objectId;

        $bmobObj3->delete($objectid3);
        echo $linkurl3;
      }else {
        $linkurl3 = null;
        echo false;
      }
    }
?>
