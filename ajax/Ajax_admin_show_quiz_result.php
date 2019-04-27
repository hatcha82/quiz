<?php
    
  include_once("../include/common_function.php");
  
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset-utf-8"); 
  $show = $_POST['show'];
  $sql = "UPDATE quiz_control qc SET qc.value = '$show' WHERE qc.key='DISPLAY_QUIZ_RESULT'";
  
  $updated_row = update($sql);
  if($updated_row > 0){
    echo "true";  
  }else{
    echo "$sql";  
  }
  
?>