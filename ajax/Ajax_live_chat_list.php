<?php
    include_once("../include/common_function.php");
    $sql = "SELECT * FROM live_chat ORDER BY inserted_date DESC LIMIT 15;";

    $list = getListWithJSON($sql);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type:text/html; charset-utf-8"); 
    header("Content-Type: application/json"); 
    echo $list;
?>