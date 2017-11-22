<?php

//A class used to manage sessions
//It does not contain database objects as it will not update user information as it update itself

class Session{
  //only session can figure out whether the user logged in or not
  private $logged_in=false;
  //ask session for particular user id for log infromations
  public $user_id;
  public $message;
  function __construct(){
    session_start();
    $this->check_login();
    $this->check_message();
    if($this->logged_in){
      //actions to take right away if the user is logged in
    }else{
      //actions to take right away if the user is not logged in
    }
  }

  public function is_logged_in(){
    return $this->logged_in;
  }

  private function check_login(){
    if(isset($_SESSION['user_id'])){
      $this->user_id=$_SESSION['user_id'];
      $this->logged_in=true;
    }else{
      unset($this->user_id);
      $this->logged_in=false;
    }
  }

  public function login($user){
    $this->user_id=$_SESSION['user_id']=$user;
    $this->logged_in=true;
  }

  public function logout(){
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->logged_in=false;
  }

  public function check_message(){
    if(isset($_SESSION['message'])){
      $this->message=$_SESSION['message'];
    }else {
      $this->message="";
    }
  }
}

$session=new Session();
?>
