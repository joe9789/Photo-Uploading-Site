<?php
require_once("intialize.php");


class Photograph {
  //declaring members of the class
  protected static $table_name="photographs";


  public $id;
  public $filename;
  public $type;
  public $size;
  public $caption;

  //handling uploaded files
  private $temp_path;
  protected $upload_dir="images";
  //to display the error to the user values assigned by the $upload_errors array
  public $errors=array();
  //array containing upload errors
  protected $upload_errors = array(
  UPLOAD_ERR_OK =>"No Errors" ,
  UPLOAD_ERR_INI_SIZE=>"Larger Than Upload Max File Size",
  UPLOAD_ERR_FORM_SIZE=>"Larger Than Form Max File Size",
  UPLOAD_ERR_PARTIAL=>"Partial Upload",
  UPLOAD_ERR_NO_FILE=>"No File",
  UPLOAD_ERR_NO_TEMP_DIR=>"No Temporary Directory",
  UPLOAD_ERR_CANT_WRTIE=>"Can't Write To Disk",
  UPLOAD_ERR_EXTENSION=>"File Upload Stop By extension"
 );

 //accepts $_FILE['uploaded_file'] as argument
  public function attach_file($file){
   //checks for the errors
   if(!$file || empty($file) || !is_array($file)){
     $this->errors[]="No File  Was Uploaded";
     return false;
   }elseif($file['error'] !=0){
     $this->error[]=$this->upload_errors[$file['error']];
     return false;
   }else{
     //set the object attribute to form parameters
     $this->filename=basename($file['name']);
     $this->temp_path=$file['tmp_name'];
     $this->type=$file['type'];
     $this->size=$file['size'];
     return true;
   }
      //saving to database is not done yet
}
  public function save_file(){
    if(isset($this->id)){
      $this->update();
    }else{
      if(!empty($this->errors)){return false;}
      if(strlen($this->caption) >= 255){
        $this->errors[]="The Caption Should Contain Only 255 Characters";
        return false;
      }
      if(empty($this->filename) || empty($this->temp_path)){
        $this->errors[]="File Location is not available";
        return false;
      }
      $target_path=SITE_ROOT.DS."public".DS.$this->upload_dir.DS.$this->filename;
      if(file_exists($target_path)){
        $this->errors[]="File Already Exist!";
        return false;
      }
      if(move_uploaded_file($this->temp_path,$target_path)){
        //creating an entry to the database
        if($this->create()){
          unset($this->temp_path);
          return true;
        }
      }else{
        //is it not meeting all of its condition then it may be an site attack
        $this->errors[]="File Upload Failed,Possibily Incorrect Permissions on Upload Folder";
        return false;
      }

    }
  }

  public function retrive_image(){
    return $this->upload_dir.DS.$this->filename;
  }

  public function comments(){
    return Comment::find_comments_on($this->id);
  }

  public static function find_all(){

    return self::find_by_sql(" SELECT * FROM  ".self::$table_name);

  }

  public static function count_all(){
    global $database;
    $sql="SELECT COUNT(*) FROM ".self::$table_name;
    $result_set= $database->query($sql);
    $row=$database->fetch_array($result_set);
    return array_shift($row);
  }

  public static function find_by_id($id=0){
    global $database;
    $result_array=self::find_by_sql(" SELECT * FROM  ".self::$table_name." WHERE id=".$database->escape_string($id)." LIMIT 1 ");
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

  public function create(){
    global $database;
    $attribute=$this->attributes();
    $sql="INSERT INTO ".self::$table_name;
    $sql.="  (filename,type,size,caption) ";
    $sql.="VALUES ('$this->filename','$this->type',$this->size,'$this->caption') ";

    //echo $sql;
    if($database->query($sql)){
      $this->id=$database->insert_id();
      return "Phograph Created";
    }else{
      return "Error Creating";
    }
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

  public function destroy(){
    //First Remove The Database Entry
     if($this->delete()){
      //then remove the file
      $target_path=SITE_ROOT.DS."public".DS.$this->retrive_image();
      //echo $target_path;
       return unlink($target_path)?true:false;
     }else{

    }
     //Databse delete failed
    return false;
}

}
