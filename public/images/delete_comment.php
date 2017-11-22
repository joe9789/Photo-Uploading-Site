<?php
require_once '../../includes/intialize.php';

if(!empty($_GET['id'])){
  $comment=Comment::find_by_id($_GET['id']);

  if($comment && $comment->delete()){
    echo "Comment deleted successfully!!!";
    redirect_to("show_comments.php?id={$comment->photograph_id}");
  }else{
    echo "Error Deleting Comment";
    redirect_to("show_comments.php");
  }

}else{
  echo "Id is not provided";
  redirect_to("index_photos.php");

}

 ?>
