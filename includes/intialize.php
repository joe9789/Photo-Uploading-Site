<?php
   defined('DS') ? null :define('DS', DIRECTORY_SEPARATOR);
   defined('SITE_ROOT') ? null: define('SITE_ROOT', 'C:'.DS.'Program Files (x86)'.DS.'Ampps'.DS.'www'.DS.'Photo Gallery');
   defined('LIB_PATH') ? null : define('LIB_PATH',SITE_ROOT.DS.'includes');
//C:\Program Files (x86)\Ampps\www\Photo Gallery
//echo SITE_ROOT;
    require_once(LIB_PATH.DS."config.php");
    require_once(LIB_PATH.DS."functions.php");
    require_once(LIB_PATH.DS."database.php");
    require_once(LIB_PATH.DS."database_object.php");
    require_once(LIB_PATH.DS."session.php");
    require_once(LIB_PATH.DS."user.php");
    require_once(LIB_PATH.DS."photograph.php");
    require_once(LIB_PATH.DS."comments.php");
    require_once(LIB_PATH.DS."pagination.php");
 ?>
