<?php
require_once("../../includes/intialize.php");
// if(!isset($_SESSION['user_id'])){
//   redirect_to("login.php");
// }

?>

<?php

// $user->username="Vaathu muta";
// $user->password="fordgt56";
// $user->first_name="Vaathu";
// $user->last_name="muta";
// echo $user->create();

// $user=User::find_by_id(12);
// $user->delete();

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Photo Gallery</title>
  </head>
  <body>
    <div class="header">
      <h2>Index Page</h2>
    </div>
    <?php
        $max_file_size= 1048576;
        $message="";
        if(isset($_POST['submit_photo'])){
          $photo=new Photograph();
          $photo->caption=$_POST['caption'];
          $photo->attach_file($_FILES['file_upload']);
          if($photo->save_file()){
            //success
            $_SESSION['message']="Photograph Uploaded Successfully";
            redirect_to("list_photos.php");
          }else{
            //Error
            $message=join("<br>",$photo->errors);
          }
        }

     ?>

    <div class="menu">
      <a href="log_file.php">View Log File</a>
      <?php echo $message; ?>
      <form class="" action="photo_upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file_upload" value="<?php echo $max_file_size; ?> ">
        <input type="text" name="caption" value="" placeholder="Enter A Caption">
        <input type="submit" name="submit_photo" value="Upload">
      </form>
    </div>

    <div class="footer">
      <?php //echo date("Y",time()); ?>
    </div>
  </body>
</html>
