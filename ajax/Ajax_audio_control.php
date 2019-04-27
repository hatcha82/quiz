<?php
    
  include_once("../include/common_function.php");
  
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset-utf-8"); 
  $control = $_POST['control'];
  $sql = "UPDATE quiz_control qc SET qc.value = '$control' WHERE qc.key='PLAY_AUDIO'";
  
  $updated_row = update($sql);
  if($updated_row > 0){
    echo "true";  
  }else{
    echo "fail";  
  }
  
?>