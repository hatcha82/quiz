<?php
    include_once("../include/common_function.php");
    $sql = "select if(count(id) = (select qc.value from quiz_control qc where qc.`key` = 'MAX_REGISTER_QUIZ') , 'ACCEPT', 'DENY') as MAX_ALLOW
              from quiz q where q.owned_userid = 'mkkim'  and q.type='BINARY';";
    $list = getList($sql);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type:text/html; charset-utf-8"); 
    header("Content-Type: application/json"); 

    var_dump($list[0]->MAX_ALLOW);
?>