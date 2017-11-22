<?php
require_once("../../includes/intialize.php");
echo $_GET['id'];
if(empty($_GET['id'])){
  $_SESSION['message']="Id is not Provided";
  echo $_SESSION['message'];
  redirect_to("index_admin.php");
}else {
  $photo=Photograph::find_by_id($_GET['id']);

  if($photo && $photo->destroy()){
    $_SESSION['message']="Photo Deleted succesfully";
    echo $_SESSION['message'];
    redirect_to("list_photos.php");
  }else{
    $_SESSION['message']="Unable to delete photo some parameter is missing";
    echo $_SESSION['message']."  ".$_GET['id'];
    redirect_to("list_photos.php");
  }

}


if(isset($database)){
  $database->close_connection();
}
 ?>
