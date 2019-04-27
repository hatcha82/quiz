<?php
    include_once("../include/common_function.php");
    session_start();
    $userid = $_SESSION["userid"];
    $sql = "SELECT q.id as id, q.quiz, q.anwser as answer ,c.code_name as type, c.code  as type_code
            FROM quiz q, code c 
            where q.type = c.`code` and
            q.owned_userid ='$userid' order by q.id desc";
    
    $list = getListWithJSON($sql);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type:text/html; charset-utf-8"); 
    header("Content-Type: application/json"); 
    echo $list;
?>