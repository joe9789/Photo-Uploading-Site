<?php
require_once '../../includes/intialize.php';

if(empty($_GET['id'])){
  echo "Id is not provided!!";
}
$photo=Photograph::find_by_id($_GET['id']);
$comments=$photo->comments();
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Show Comments</title>
  </head>
  <body>
    <table border="1px" padding="2px" style="margin:0px auto;">
      <tr>
        <th>Wrote By</th>
        <th>Comment</th>
        <th>Created on</th>
        <th>&nbsp;</th>
      </tr>
      <?php foreach($comments as $comment):?>
      <tr>
        <td><?php echo $comment->author;?></td>
        <td><?php echo $comment->body; ?></td>
        <td><?php echo $comment->created; ?></td>
        <td><a href="delete_comment.php?id=<?php echo $comment->id?>">Delete</a></td>
      </tr>
    <?php endforeach;?>
    </table>
  </body>
</html>
