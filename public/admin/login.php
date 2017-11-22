<?php
    require_once("../../includes/intialize.php");

    // if($session->is_logged_in()){
    //   redirect_to("index_admin.php");
    // }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>User Login</title>
  </head>
  <body>
    <div class="header">

    </div>

    <div class="login">
      <form class="login_form" action="login.php" method="POST">
        <input type="text" name="username" value="" placeholder="Enter Your Username">
        <input type="password" name="password" value="" placeholder="Enter Your Password">
        <input type="submit" name="submitAdmin" value="Submit">
        <?php
        if(isset($_POST['submitAdmin'])){
          $username=trim($_POST['username']);
          $password=trim($_POST['password']);
          $found_user=User::aunthenticate($username,$password);

          if($found_user){
            //user aunthenticated
            $session->login($found_user);
            log_user("LOG IN","{$found_user->username} log in");
            redirect_to("index_admin.php");
          }else{
            $message="Username/Password is not matching";
            echo $message;
          }
        }
        ?>
      </form>
    </div>
  </body>
</html>
