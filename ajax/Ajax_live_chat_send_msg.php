<?php
    
  include_once("../include/common_function.php");
  session_start();
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset-utf-8"); 
  $userid = $_SESSION["userid"];
  $username = $_SESSION["username"];
  $context = $_POST["context"];

  $sql = "INSERT INTO live_chat (userid, user_name, context) VALUES ('$userid','$username','$context')";
  $inserted = insert($sql);
  if($updated_row > 0){
    echo "true";  
  }else{
    echo "$userid";  
  }
  
?>