<?php
require_once('../../includes/intialize.php');

//pagination needs to track three variables
//1.the current page number ($current_page)
$page=!empty($_GET['page']) ? (int)$_GET['page'] : 1;
//2.records per page ($per_page)
$per_page=3;
//3.total records count ($total_count)
$total_count=Photograph::count_all();

//find all photos
//using pagination instead
//$photos=Photograph::find_all();

$pagination= new Pagination($page,$per_page,$total_count);
echo $pagination->total_page();
echo $pagination->total_count;
echo $pagination->per_page;
//instead of finding all the records find records for only this page
$sql="SELECT * FROM photographs ";
$sql.="LIMIT {$per_page} ";
$sql.="OFFSET {$pagination->offset()} ";

$photos=Photograph::find_by_sql($sql);

 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Display Photo</title>
   </head>
   <body>

     <table border=1 padding=1 style="margin:auto;">
       <tr>
         <th>Caption</th>
         <th>Image(s)</th>
         <th>&nbsp;</th>
         <th>Comments</th>
       </tr>
       <?php foreach($photos as $photo):?>

      <tr>
        <td><?php echo $photo->caption;?></td>
        <td><a href="show_image.php?id=<?php echo $photo->id?>"><img src="../<?php echo $photo->retrive_image();?>" alt="" width="25%"></a></td>
        <td><a href="delete_photo.php">Delete</a></td>
        <td><a href="show_comments.php?id=<?php echo $photo->id; ?>"><?php echo count($photo->comments()) ?></a></td>
        </tr>
      <?php endforeach;?>
     </table>

     <div class="pagination" style="clear:both;">
       <?php

          if($pagination->total_page() >1){
            if($pagination->has_next_page()){
              echo "<a href=\"index_photos.php?page={$pagination->next_page()}\"";
              echo">Next &raquo;</a>";
            }
            for ($i=1; $i <= $pagination->total_page(); $i++) {
              echo " <a href=\"index_photos.php?page={$i}\">{$i}</a> ";
            }

            if($pagination->has_prev_page()){
              $page="<a href=\"index_photos.php?page={$pagination->prev_page()}\"";
              $page.=">Prev &laquo;</a>";
              echo $page;
            }
          }
        ?>
     </div>

   </body>
 </html>
