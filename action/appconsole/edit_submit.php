<?php
  include_once '../../lib/Bmob/BmobObject.class.php';

  $type = $_POST["type"];
  $userid = $_POST["userid"];

  if($type =="index")
  {
      $title = $_POST["title"];
      $content = $_POST["content"];
      $images = $_POST["images"];

      if(count($images) == 0)
      {
          $object = new BmobObject("find_work");
          $res=$object->create(array("title"=>$title,"content"=>$content,"isactive"=>true,"sort"=>2 )); //添加对象
          $res=$object->updateRelPointer($res->objectId, "parent", "_User", $userid);
      }else {
          $object = new BmobObject("find_work");
          $res=$object->create(array("title"=>$title,"content"=>$content,"image1" =>$images[0],"image2"=>$images[1],"image3" =>$images[2], "image4" =>$images[3],"image5" =>$images[4],"image6" =>$images[5],"isactive"=>true,"sort"=>999999 )); //添加对象
          $res=$object->updateRelPointer($res->objectId, "parent", "_User", $userid);
      }
  }elseif ($type =="love_marry") {

      $title = $_POST["title"];
      $content = $_POST["content"];
      $images = $_POST["images"];

      if(count($images) == 0)
      {
          $object = new BmobObject("love_marry");
          $res=$object->create(array("title"=>$title,"content"=>$content,"isactive"=>true,"sort"=>2 )); //添加对象
          $res=$object->updateRelPointer($res->objectId, "parent", "_User", $userid);
      }else {
          $object = new BmobObject("love_marry");
          $res=$object->create(array("title"=>$title,"content"=>$content,"image1" =>$images[0],"image2"=>$images[1],"image3" =>$images[2], "image4" =>$images[3],"image5" =>$images[4],"image6" =>$images[5],"isactive"=>true,"sort"=>999999 )); //添加对象
          $res=$object->updateRelPointer($res->objectId, "parent", "_User", $userid);
      }
  }elseif ($type =="make_friend") {

      $title = $_POST["title"];
      $content = $_POST["content"];
      $images = $_POST["images"];

      if(count($images) == 0)
      {
          $object = new BmobObject("make_friend");
          $res=$object->create(array("title"=>$title,"content"=>$content,"isactive"=>true,"sort"=>2 )); //添加对象
          $res=$object->updateRelPointer($res->objectId, "parent", "_User", $userid);
      }else {
          $object = new BmobObject("make_friend");
          $res=$object->create(array("title"=>$title,"content"=>$content,"image1" =>$images[0],"image2"=>$images[1],"image3" =>$images[2], "image4" =>$images[3],"image5" =>$images[4],"image6" =>$images[5],"isactive"=>true,"sort"=>999999 )); //添加对象
          $res=$object->updateRelPointer($res->objectId, "parent", "_User", $userid);
      }
  }


?>
