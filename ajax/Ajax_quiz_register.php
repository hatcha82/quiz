<?php
    
  include_once("../include/common_function.php");
  session_start();
  header("Access-Control-Allow-Origin: *");
  header("Content-Type:text/html; charset-utf-8"); 
  
  
  $userid = $_SESSION["userid"];
  $username = $_SESSION["username"];
  $sql = "";
  $registed_quiz_id =$_POST["registed_quiz_id"];
  $quiz_type = $_POST["quiz_type"];
  $numer_of_user_quiz = checkQuizMaxAllow();
  
  
  if($numer_of_user_quiz->MAX_ALLOW == 'DENY'){
      echo "MAX_ALLOW:" . $numer_of_user_quiz->MAXQUIZLIMIT . ":CURRENT:". $numer_of_user_quiz->USER_QUIZ_COUNT;
      exit(1);
  }
  
  
  
  if($quiz_type == "BINARY"){      
    $sql = insertUpdateBinary();
  }else if($quiz_type == "SHORT"){
    $sql = insertUpdateShort();
  }else if($quiz_type == "SELECT"){
    insertUpdateSelect();
  }else if($quiz_type == "MORETHANHALF"){
    $sql =insertUpdateMoreThanHalf();
  }
  
  if($registed_quiz_id =$_POST["registed_quiz_id"] == ""){
      $result = insert($sql); 
      if($result > 0){
        echo $result;  
      }else{
        echo "fail";  
      }
  }else{
      $result = update($sql);  
      if($result > 0){
        echo "edit_success";  
      }else{
        echo "fail";  
      }
  }
  
  function checkQuizMaxAllow(){
      $registed_quiz_id =$_POST["registed_quiz_id"];
      if($registed_quiz_id != ""){
          return "QUIZ_UPDATE";
      }else{
        $userid = $_SESSION["userid"];
        $quiz_type = $_POST["quiz_type"];

        $sql = "select if(count(id) < (select qc.value from quiz_control qc where qc.`key` = 'MAX_REGISTER_QUIZ') , 'ACCEPT', 'DENY') as MAX_ALLOW,
                count(id) as USER_QUIZ_COUNT,
                (select qc.value from quiz_control qc where qc.`key` = 'MAX_REGISTER_QUIZ') as MAXQUIZLIMIT
                from quiz q where q.owned_userid = '$userid'  and q.type='$quiz_type'";
        
        $list = getList($sql);
        return $list[0];
      }
  }
  
  function insertUpdateBinary(){
    $registed_quiz_id =$_POST["registed_quiz_id"];
    $quiz_type = $_POST["quiz_type"];
    $quiz_context = $_POST["quiz_context"];
    $quiz_answer = $_POST["oxRadio"];
    $userid = $_SESSION["userid"];
    
    $sql = "";
    if($registed_quiz_id == ""){
        $sql = "insert into `t2lgame`.`quiz` ( `type`, `quiz`, `anwser`, `owned_userid`) values ( '$quiz_type', '$quiz_context', '$quiz_answer', '$userid')";
    }else{
        $sql = "update `t2lgame`.`quiz` set `type`='$quiz_type', `quiz`='$quiz_context' , `anwser`='$quiz_answer'where `id`='$registed_quiz_id' and owned_userid = '$userid'";
    }
    
    return $sql;
  }
  function insertUpdateShort(){
    $registed_quiz_id =$_POST["registed_quiz_id"];
    $quiz_type = $_POST["quiz_type"];
    $quiz_context = $_POST["quiz_context"];
    $quiz_answer = $_POST["register_quiz_anser_short"];
    $userid = $_SESSION["userid"];
    $sql = "";
    if($registed_quiz_id == ""){
        $sql = "insert into `t2lgame`.`quiz` ( `type`, `quiz`, `anwser`, `owned_userid`) values ( '$quiz_type', '$quiz_context', '$quiz_answer', '$userid')";
    }else{
        $sql = "update `t2lgame`.`quiz` set `type`='$quiz_type', `quiz`='$quiz_context' , `anwser`='$quiz_answer' where `id`='$registed_quiz_id' and owned_userid = '$userid'";
    }
    return $sql;
  }
  function insertUpdateMoreThanHalf(){
    $registed_quiz_id =$_POST["registed_quiz_id"];
    $quiz_type = $_POST["quiz_type"];
    $quiz_context = $_POST["quiz_context"];
    $userid = $_SESSION["userid"];
    $sql = "";
    if($registed_quiz_id == ""){
        $sql = "insert into `t2lgame`.`quiz` ( `type`, `quiz`, `owned_userid`) values ( '$quiz_type', '$quiz_context','$userid')";
    }else{
        $sql = "update `t2lgame`.`quiz` set `type`='$quiz_type', `quiz`='$quiz_context'  where `id`='$registed_quiz_id' and owned_userid = '$userid'";
    }
    
    return $sql;
  }
  function insertUpdateSelect(){
    $registed_quiz_id =$_POST["registed_quiz_id"];
    $quiz_answer = $_POST["register_quiz_anser_select"];
    $example1 = $_POST["register_quiz_anser_select1"];
    $example2 = $_POST["register_quiz_anser_select2"];
    $example3 = $_POST["register_quiz_anser_select3"];
    $example4 = $_POST["register_quiz_anser_select4"];
    
    echo $example1;
    echo $example2;
    echo $example3;
    echo $example4;
    
    echo $quiz_answer;
  }
?>