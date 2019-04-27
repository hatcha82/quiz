<?php
    
  include_once("../include/common_function.php");
  session_start();
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset-utf-8"); 
  
  $userid = $_SESSION["userid"];
  $quiz_id = $_POST["user_quiz_id"];
  $quiz_answer = $_POST["user_quiz_answer"];
  
  $sql = "select * from `t2lgame`.`answer` where user_id = '$userid' and quiz_id = '$quiz_id'";
  $list = getList($sql);
  $quiz_answer_in_db = $list[0]->answer;
  $isInsertedAnswer = (count($list) ? "true" : "false");
  
  if($isInsertedAnswer == "true"){
      $sql = "update `t2lgame`.`answer` set `answer`='$quiz_answer' where user_id ='$userid' and quiz_id = '$quiz_id'" ;
  }else{
      $sql = "insert into `t2lgame`.`answer` ( `quiz_id`, `user_id`, `answer`) values ( '$quiz_id', '$userid', '$quiz_answer')";
  }
  
  
  if($isInsertedAnswer == "true"){
      $result = update($sql);  
      if($result > 0){
        echo "success";  
      }else{
          if($quiz_answer_in_db == $quiz_answer){
              echo "success";  
          }else{
              echo "fail";  
          }
      }
  }else{
      $result = insert($sql); 
      if($result > 0){
        echo "success";  
      }else{
        echo "fail";  
      }
  }
 
  
?>