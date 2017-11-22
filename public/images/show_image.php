<?php
require_once('../../includes/intialize.php');
//echo $_GET['id'];
//returns a single result set
$photo=Photograph::find_by_id($_GET['id']);

if(empty($_GET['id'])){
  echo "Id Is Not Provided";
  redirect_to("list_photos.php");
}

if(isset($_POST['submit_comment'])){
  $author=trim($_POST['author']);
  $body=trim($_POST['body']);

  $new_comment=Comment::make_comment($photo->id,$author,$body);
if($new_comment && $new_comment->save()){
    //success
    //We could just let the page render from here
    //But if we do like this browser trys to resubmit
    //the form so redirect to any other page
    redirect_to("show_image.php?id={$photo->id}");
  }else{
    //failed
    $_SESSION['message']="There was an error that prevented comment being saved";
    echo $_SESSION['message'];
  }
}else{
  $author="";
  $body="";
}

$comments=$photo->comments();
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Show Image</title>
   </head>
   <body>
     <table style="margin:0px auto;">
       <tr>
         <th>Caption</th>
         <th>Image</th>
       </tr>

       <tr>
         <td><?php echo $photo->caption; ?></td>
         <td><img src="../<?php echo $photo->retrive_image();?>" ></td>
       </tr>

     </table>
     <div class="comment-section"  style="padding:2px; margin:0px auto;">
     <div class="comments">
       <h3>Comments</h3>
       <table >
         <tr>
           <th>Wrote</th>
           <th>Comment</th>
           <th>Time</th>
         </tr>
         <?php foreach ($comments as $comment): ?>
         <tr>
           <td><?php echo htmlentities($comment->author);?></td>
           <td><?php echo strip_tags($comment->body,"<strong><em><p>")?></td>
           <td><?php echo datetime_to_text($comment->created); ?></td>
         </tr>
       <?php endforeach; ?>
       </table>
     </div>
     <div>
       <h3>New Comment</h3>
       <form  action="show_image.php?id=<?php echo $photo->id?>" method="post">
         <table>
           <tr>
             <td><input type="text" name="author" value="<?php echo $author;?>" placeholder="Enter Your Name"></td>
           </tr>
           <tr>
             <td><textarea name="body" rows="8" cols="40" placeholder="Enter your comments"><?php echo $body;?></textarea></td>
           </tr>
           <tr>

             <td><input type="submit" name="submit_comment" value="Comment"></td>
           </tr>
         </table>
       </form>
     </div>
   </div>
   </body>
 </html>
