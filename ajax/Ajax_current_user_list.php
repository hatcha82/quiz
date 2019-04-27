<?php
    include_once("../include/common_function.php");
    $sql = "SELECT * FROM
            (
                            SELECT *, 'LOGON' as login_info,now(),
                                  (select count(q.id) from quiz q where q.owned_userid = u.userid) as registed_quiz_count, 
                                  ((select qcm.value from quiz_control qcm where qcm.`key` = 'MAX_REGISTER_QUIZ' ) * (select qct.value from quiz_control qct where qct.`key` = 'NUMBER_OF_QUIZ_TYPE')) as max_quiz_count
                            FROM user u 
                            WHERE u.last_login_time > now() - INTERVAL (SELECT VALUE FROM quiz_control qi WHERE qi.key = 'QUIZ_LOGIN_INTERVAL') SECOND
                            UNION
                            SELECT *, 'LOGOFF' as login_info,  now(),
                                  (select count(q.id) from quiz q where q.owned_userid = u.userid) as registed_quiz_count,
                                  ((select qcm.value from quiz_control qcm where qcm.`key` = 'MAX_REGISTER_QUIZ' ) * (select qct.value from quiz_control qct where qct.`key` = 'NUMBER_OF_QUIZ_TYPE')) as max_quiz_count  
                            FROM user u 
                            WHERE u.last_login_time <= now() - INTERVAL (SELECT VALUE FROM quiz_control qi WHERE qi.key = 'QUIZ_LOGIN_INTERVAL') SECOND or u.last_login_time is null
            ) as total_user
            ORDER BY total_user.name";
        
    $list = getListWithJSON($sql);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type:text/html; charset-utf-8"); 
    header("Content-Type: application/json"); 
    echo $list;
?>