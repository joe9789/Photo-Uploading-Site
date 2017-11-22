<?php
require_once("../includes/database.php");
require_once("../includes/functions.php");
//require_once("../includes/user.php");

$user=User::find_by_id(1);

$users=User::find_all();

//$find_all=User::find_all();

// while($all_res_set=$database->fetch_array($find_all)){
//   echo $all_res_set['username']."<br>";
//   echo $all_res_set['first_name']."<br>";
//   echo $all_res_set['last_name']."<br>";
// }
//echo $user->fname_lname();

foreach ($users as $user) {
  echo "UserName:  ". $user->username."<br>";
  echo "FullName:  ". $user->fname_lname()."<br>";
}
?>
