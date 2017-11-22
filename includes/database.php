<?php
require_once("config.php");
require_once("functions.php");

/**Opens Connection
 *Using mysqli functions
 */
class MySQLDataBase
{
    private $connection;

  function __construct()
  {
    $this->open_connection();
  }

  public function open_connection(){
    $this->connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    if (!$this->connection) {
      die("Connection Failed");
    }else {
      //echo"Connection Succeed<br>";
    }
  }



  public function query($sql){
    $result=mysqli_query($this->connection,$sql);
    if(!$result){
      echo "Query failed";
    }else{
      //echo "Query Performed Successfully<br>";
      return $result;
    }
  }
      //database nuetral functions
  public function fetch_array($result_set){
    return mysqli_fetch_array($result_set);
  }

  public function num_rows($result_set){
    return mysql_num_rows($result_set);
  }

  public function insert_id(){
    return mysql_insert_id();
  }

  public function affected_rows(){
    return mysql_affected_rows();
  }

  public function close_connection(){
    if(mysqli_close($this->connection)){
        //echo "Connections closed<br>";
    }
  }

  public function escape_string($string){
    return mysqli_real_escape_string($this->connection,$string);
  }

}

?>

<?php
$database=new MySQLDataBase();
 ?>
