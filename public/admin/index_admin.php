<?php
require_once("../../includes/intialize.php");

// if(!$session->is_logged_in()){
//   redirect_to("login.php");
// }
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

    <div class="menu">
      <a href="log_file.php">View Log File</a>
    </div>

    <div class="footer">
      <?php //echo date("Y",time()); ?>
    </div>
  </body>
</html>
