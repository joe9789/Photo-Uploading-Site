<?php
require_once("../../includes/intialize.php");
// if(!isset($_SESSION['user_id'])){
//   redirect_to("login.php");
// }

$photos=Photograph::find_all();
// echo "<pre>";
// print_r($photos);
// echo "</pre>";
 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>List Photos</title>
   </head>
   <body>
     <?php if (isset($_SESSION['message'])){
        echo $_SESSION['message'];
     } else {
        echo "";
     }
     ?>
     <table border="1px">
       <tr>
         <th>Photo</th>
         <th>Name</th>
         <th>Size</th>
         <th>Caption</th>
         <th>&nbsp;</th>
       </tr>
       <?php foreach ($photos as $photo):?>
       <tr>
         <td><img src="../<?php echo $photo->retrive_image();?>" alt="" width="25%" border="1px"></td>
         <td><?php echo $photo->filename;?></td>
         <td><?php echo $photo->size;?></td>
         <td><?php echo $photo->caption;?></td>
         <td><a href="delete_photo.php?id=<?php echo $photo->id;?>">Delete</a></td>
       </tr>
     <?php endforeach; ?>
     </table>
     <a href="photo_upload.php">Upload New Photo</a>
   </body>
 </html>
