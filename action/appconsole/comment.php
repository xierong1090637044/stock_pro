<?php
  include_once '../../lib/Bmob/BmobObject.class.php';

  $type = $_POST["type"];

  if($type =="comment")
  {
      $id = $_POST["id"];
      $objectid = $_POST["objectid"];

      $comment = new BmobObject("Comment");
      $res = $comment->addRelPointer(array(array("author","_User",$id),array("post","find_work",$objectid)));
      $result = $comment->update($res->objectId, array("comment"=>$_POST["comment"]));

      if($result->updatedAt != null)
      {
          echo true;
      }
  }elseif ($type =="comment_user") {
      $id = $_POST["id"];
      $objectid = $_POST["objectid"];
      $commentid = $_POST["commentid"];

      $comment = new BmobObject("Comment_user");
      $res = $comment->addRelPointer(array(array("author","_User",$id),array("post","find_work",$objectid),array("post_com","Comment",$commentid)));
      $result = $comment->update($res->objectId, array("comment"=>$_POST["comment"]));

      if($result->updatedAt != null)
      {
          echo true;
      }
  }elseif ($type =="get_comment") {
      header('Content-Type:application/json');//这个类型声明非常关键
      $commentid = $_POST["commentid"];

      $comment_user = new BmobObject("Comment_user");
      $getcommet_user=$comment_user->get("",array('where={"post_com":{"__type":"Pointer","className":"Comment","objectId":'."\"".$commentid."\"".'}}','include=author'))->results;

      $res = json_encode($getcommet_user);
      echo $res;
  }elseif ($type =="get_all_comment") {
      header('Content-Type:application/json');//这个类型声明非常关键

      $objectid = $_POST["objectid"];
      $comment = new BmobObject("Comment");
      $getcommet=$comment->get("",array('where={"post":{"__type":"Pointer","className":"find_work","objectId":'."\"".$objectid."\"".'}}','include=author'))->results;

      foreach ($getcommet as $item) {
          $comment_user = new BmobObject("Comment_user");
          $getcommet_user=$comment_user->get("",array('where={"post_com":{"__type":"Pointer","className":"Comment","objectId":'."\"".$item->objectId."\"".'}}','include=author'))->results;
          $item->commentlist=$getcommet_user;
      }

      $getcommet_result = json_encode($getcommet);

      echo $getcommet_result;
  }

?>
