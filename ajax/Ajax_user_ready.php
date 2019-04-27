<?php

    include_once("../include/common_function.php");
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type:text/html; charset-utf-8");

    $userid = $_SESSION["userid"];
    $quiz_id = $_POST["user_quiz_id"];

    $sql = "update `t2lgame`.`answer` set `ready`='Y' where user_id ='$userid' and quiz_id = '$quiz_id'";

    $result = update($sql);
    if ($result > 0) {
        echo "success";
    } else {
        echo "fail";
        
    }
?>