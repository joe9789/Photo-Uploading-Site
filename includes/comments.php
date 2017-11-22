<?php
require_once("intialize.php");

class Comment{
  protected static $table_name="comments";
  protected static $db_fields=array("id","photograph_id","created","author","body");

  public $id;
  public $photograph_id;
  public $created;
  public $author;
  public $body;
//return a comment object
  public static function make_comment($photo_id,$author="Anonymous",$body){
    if(!empty($photo_id) && !empty($author) && !empty($body)){
      $comment = new Comment();
      $comment->photograph_id=(int)$photo_id;
      $comment->created=strftime("%y-%m-%d %H:%M:%S",time());
      $comment->author=$author;
      $comment->body=$body;
      return $comment;
    }else{
      return false;
    }
  }
  public static function find_comments_on($photo_id=0){
    global $database;
    $sql="SELECT * FROM ".self::$table_name;
    $sql.=" WHERE photograph_id=".$database->escape_string($photo_id);
    $sql.=" ORDER BY created ASC";
    return self::find_by_sql($sql);
  }

  public static function find_all(){

    return self::find_by_sql(" SELECT * FROM  ".self::$table_name);

  }

  public static function find_by_id($id=0){
    global $database;
    $result_array=self::find_by_sql(" SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1 ");
    //print_r($result_array);
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function find_by_sql($sql=" "){
    global $database;
    $result_set=$database->query($sql);
    $object_array=array();
    while($result=$database->fetch_array($result_set)){
      $object_array[]=self::instantiate($result);
    }
    //print_r($object_array);
    return $object_array;
  }
   public function comment_destroy(){
     
   }
  public static function aunthenticate($username="",$password=""){
    global $database;
    $username=$database->escape_string($username);
    $password=$database->escape_string($password);
    $sql=" SELECT * FROM ".self::$table_name." WHERE username='{$username}' AND password= '{$password}' LIMIT 1 ";

    $result_array=self::find_by_sql($sql);
    return !empty($result_array) ? array_shift($result_array) : false;


  }
//this function assign value to the object instantiated
  private static function instantiate($record){
    $object=new self;
    foreach ($record as $attribute => $value) {
      if($object->has_attribute($attribute)){
        $object->$attribute=$value;
      }
    }

    return $object;
  }

  private function has_attribute($attribute){
    //checks if the object has particular attribute
    $object_vars=$this->attributes();
    return array_key_exists($attribute,$object_vars);
  }

  protected  function attributes(){
    return get_object_vars($this);
  }
  //create new user
  public function create(){
    global $database;
    //$attribute=$this->attributes();
    $sql="INSERT INTO ".self::$table_name;
    $sql.=" (photograph_id,created,author,body) ";
    $sql.="VALUES ({$this->photograph_id},'{$this->created}','{$this->author}','{$this->body}') ";

    if($database->query($sql)){
       $this->id=$database->insert_id();
       return "Comment Submitted";
     }else{
       return "Error";
     }


  }

  public function save(){
    return isset($this->id) ? $this->update():$this->create();
  }

  public function update(){
    global $database;
    $sql="UPDATE ".self::$table_name;
    $sql.=" SET username='{$this->username}' ,";
    $sql.=" password='{$this->password}' ,";
    $sql.=" first_name='{$this->first_name}' ,";
    $sql.=" last_name='{$this->last_name}' ";
    $sql.=" WHERE id={$this->id} ";
    $database->query($sql);
    return ($database->affected_rows()==1) ? true:false;
}

  public function delete(){
    global $database;
    $sql="DELETE FROM ".self::$table_name;
    $sql.=" WHERE id={$this->id} LIMIT 1 ";
    $database->query($sql);
    return ($database->affected_rows()==1) ? true:false;

}

}


 ?>
