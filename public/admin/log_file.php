<?php require_once("../../includes/intialize.php"); ?>
<?php if(!$session->is_logged_in()){
  redirect_to("login.php");
} ?>

<?php
  $log_file=SITE_ROOT.DS."logs".DS."log.txt";
  //script to clear the log file
  if($_GET['clear']==true){
      file_put_contents($log_file,'');
      redirect_to("log_file.php");
  }
 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Log File</title>
   </head>
   <body>
     <a href="index_admin.php">&laquo; Back</a><br>
     <h2>Log Files</h2>
     <a href="log_file.php?clear=true">Clear Log Files</a><br>
     <?php
     if(file_exists($log_file) && is_readable($log_file) && $handler=fopen($log_file,'r')){
       echo "<ul class=\"log-file\">";
       while (!feof($handler)) {
         $entry=fgets($handler);
         if(trim($entry) !=""){
           echo "<li>{$entry}</li>";
         }
       }

       echo "</ul>";
       fclose($handler);
     }else{
       echo "Could Not Open Log File";
     }
      ?>
   </body>
 </html>
