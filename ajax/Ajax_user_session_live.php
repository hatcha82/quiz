<?php
    
  include_once("../include/common_function.php");
  session_start();
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset-utf-8"); 
  $userid = $_SESSION["userid"];
  $sql = "update user set last_login_time = NOW()  where userid='$userid'";
  $updated_row = update($sql);
  if($updated_row > 0){
    echo "true";  
  }else{
    echo "$userid";  
  }
?>