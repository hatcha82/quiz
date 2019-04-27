<?php
    
  include_once("../include/common_function.php");
  session_start();
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset-utf-8"); 

  $direction = $_POST["direction"];
  $nextsql = "select id from quiz where id > (select quiz_control.`value` from quiz_control where quiz_control.`key` = 'CURRENT_QUIZ') limit 1;";
  $prevsql = "select id from quiz where id < (select quiz_control.`value` from quiz_control where quiz_control.`key` = 'CURRENT_QUIZ') order by id desc limit 1;";
  $controlsql = "SELECT qc.value as current_quiz_id
        ,       q.id
        ,       q.quiz
        ,       q.anwser
        ,       c.code_name as type
        ,       (SELECT value from quiz_control iqc where iqc.key = 'DISPLAY_ANSWER') as display
        FROM quiz_control qc, quiz q, code c 
        WHERE qc.KEY = 'CURRENT_QUIZ' AND qc.VALUE = q.id AND c.code = q.type";
  
  $list = getList($nextsql);
  $next_id = (int)$list[0]->id;

  $list = getList($prevsql);
  $pre_id = (int)$list[0]->id;

  $list = getList($controlsql);
  $current_quiz_id = (int)$list[0]->current_quiz_id;
  
  $request_quiz_id = $current_quiz_id;
  if($direction == "NEXT"){
    $request_quiz_id = $next_id;
  }else if($direction == "PREV"){
    $request_quiz_id = $pre_id;
  }else{
    exit(1);
  }

  
  $sql = "UPDATE quiz_control qc SET qc.value = '$request_quiz_id' WHERE qc.key='CURRENT_QUIZ'";
  
  $updated_row = update($sql);
  if($updated_row > 0){
    echo "true";  
  }else{
    echo "$userid";  
  }
  $sql = "UPDATE quiz_control qc SET qc.value = 'NO' WHERE qc.key='DISPLAY_ANSWER'";

  $updated_row = update($sql);
  if($updated_row > 0){
    echo "true";  
  }else{
    echo "$userid";  
  }
?>