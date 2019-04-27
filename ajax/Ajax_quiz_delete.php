<?php

    include_once("../include/common_function.php");
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type:text/html; charset-utf-8");
    $userid = $_SESSION["userid"];
    $quiz_id = $_POST["quiz_id"];
    $sql1 = "delete from `t2lgame`.`quiz` where `id`='$quiz_id' and quiz.owned_userid = '$userid'";
    $sql2 = "delete from `t2lgame`.`answer` where `quiz_id`='$quiz_id' and `user_id`='$userid'";
    $sqlArray = array();
    array_push($sqlArray, $sql1);
    array_push($sqlArray, $sql2);
    
    $result = transaction($sqlArray);
    
    
    if ($result == "true") {
        echo "delete_success";
    } else {
        echo "delete_fail";
    }
    
?>