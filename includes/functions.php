<?php
//function to redirection
  function redirect_to($new_loc){
		header("Location: ".$new_loc);
		exit;
	}

  function __autoload($class_name){
    $class_name=strtolower($class_name);
    $path="../includes/{$class_name}.php";

    if(file_exists($path)){
      require_once($path);
    }else{
      die("File Does Not Exits");
    }
  }

  function include_layout_template($template=""){
    include(SITE_ROOT.DS.'public'.DS.'layout'.DS.$template);
  }

  function log_user($action,$message=""){
    //locates the file
    $log_file=SITE_ROOT.DS."logs".DS."log.txt";
    //checks whether the file exist for chmod purpose
    $new=file_exists($log_file)? true:false;
    if($handler=fopen($log_file,'a')){
      //ceating time
      $log_time=strftime("%m:%d:%y %H:%M",time());
      $content="{$log_time} | {$action} , {$message}\n";
      fwrite($handler,$content);
      fclose($handler);
      if($new){
        chmod($log_file,0777);
      }
    }else{
      echo "Could Not Open File";
    }
  }

  function datetime_to_text($datetime){
    $unixdt=strtotime($datetime);
    return strftime("%B %d,%Y at %I:%M %p",$unixdt);
  }

?>
