<?php

    include_once("../include/common_function.php");
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type:text/html; charset-utf-8");
    
    $sql1 = "delete from `answer` where 1=1";
    
    $sqlArray = array();
    
    array_push($sqlArray, $sql1);
    
    $result = transaction($sqlArray);
    
    
    if ($result == "true") {
        echo "delete_success";
    } else {
        echo "delete_fail";
    }
    
?>