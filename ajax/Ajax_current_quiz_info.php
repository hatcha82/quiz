<?php
    include_once("../include/common_function.php");
    session_start();
    $userid = $_SESSION["userid"];
    $sql = "SELECT  qc.value as current_quiz
            ,       q.id
            ,       q.quiz
            ,       (case
                         when q.type = 'MORETHANHALF' then if( (select count(in_a.answer) from answer in_a where in_a.quiz_id = q.id and in_a.answer = 'Y') > (select round(count(*)/2) FROM user ui) , 'O' ,'X')
                         else q.anwser
                    end) as anwser
            ,       c.code_name as type
            ,       (select GROUP_CONCAT(u.`name` order by name SEPARATOR ', ')
						from user u left outer join quiz q on (1=1) left outer join answer a on (a.user_id=u.userid and q.id = a.quiz_id)
						where q.id = qc.value and (a.ready is  not null and a.ready ='Y') and u.last_login_time > now() - INTERVAL (SELECT VALUE FROM quiz_control qi WHERE qi.key = 'QUIZ_LOGIN_INTERVAL') SECOND) as quiz_ready_list		
            ,       (select GROUP_CONCAT(u.`name` order by name SEPARATOR ', ')
                                            from user u left outer join quiz q on (1=1) left outer join answer a on (a.user_id=u.userid and q.id = a.quiz_id)
                                            where q.id = qc.value and (a.ready is null or a.ready ='N') and u.last_login_time > now() - INTERVAL (SELECT VALUE FROM quiz_control qi WHERE qi.key = 'QUIZ_LOGIN_INTERVAL') SECOND) as quiz_not_ready_list
            ,       (SELECT value from quiz_control iqc where iqc.key = 'DISPLAY_ANSWER') as display
            ,       (SELECT value from quiz_control iqc where iqc.key = 'DISPLAY_QUIZ_RESULT') as display_quiz_result
            ,       (SELECT answer from answer where user_id = '$userid' and quiz_id = q.id) as user_answer
            ,       (SELECT ready from answer where user_id = '$userid' and quiz_id = q.id) as user_ready    
            ,		(CASE 
                                    WHEN q.anwser =  (SELECT answer from answer where user_id = '$userid' and quiz_id = q.id) then '정답'
                                    WHEN q.anwser <>  (SELECT answer from answer where user_id = '$userid' and quiz_id = q.id) and (SELECT answer from answer where user_id = '$userid' and quiz_id = q.id )  <> 'GIVEUP' then '오답'
                                    WHEN 1 = IFNULL( (SELECT answer from answer where user_id = '$userid' and quiz_id = q.id), 1) then '포기'
                            END) as quiz_result 		
            ,		(select GROUP_CONCAT(u.`name` order by u.`name` SEPARATOR ', ')
                            from user u left outer join quiz q on (1=1) left outer join answer a on (a.user_id=u.userid and q.id = a.quiz_id)
                            where  q.id = qc.value and( a.answer is null or a.answer = 'GIVEUP') and u.last_login_time > now() - INTERVAL (SELECT VALUE FROM quiz_control qi WHERE qi.key = 'QUIZ_LOGIN_INTERVAL') SECOND) as quiz_giveup_list
            ,		(select GROUP_CONCAT(u.`name` order by u.`name` SEPARATOR ', ')
                            from user u left outer join quiz q on (1=1) left outer join answer a on (a.user_id=u.userid and q.id = a.quiz_id)
                            where q.id = qc.value and a.answer =  q.anwser and a.answer is not null and u.last_login_time > now() - INTERVAL (SELECT VALUE FROM quiz_control qi WHERE qi.key = 'QUIZ_LOGIN_INTERVAL') SECOND) as quiz_correct_list
            ,		(select GROUP_CONCAT(u.`name` order by u.`name` SEPARATOR ', ')
                            from user u left outer join quiz q on (1=1) left outer join answer a on (a.user_id=u.userid and q.id = a.quiz_id)
                            where q.id = qc.value and a.answer <>  q.anwser and a.answer is not null and a.answer <> 'GIVEUP' and u.last_login_time > now() - INTERVAL (SELECT VALUE FROM quiz_control qi WHERE qi.key = 'QUIZ_LOGIN_INTERVAL') SECOND) as quiz_incorrect_list
            ,       (SELECT user.name from quiz, user where quiz.owned_userid = user.userid and quiz.id = q.id) as quiz_register_user
            ,       (SELECT count(answer.like) from answer where answer.like = 'Y' and answer.quiz_id = q.id  and answer.user_id = '$userid') as quiz_like_user
            ,       (SELECT count(answer.like) from answer where answer.like = 'N' and answer.quiz_id = q.id  and answer.user_id = '$userid') as quiz_dislike_user
            ,       (SELECT count(answer.like) from answer where answer.like = 'Y' and answer.quiz_id = q.id) as quiz_like
            ,       (SELECT count(answer.like) from answer where answer.like = 'N' and answer.quiz_id = q.id) as quiz_dislike
            , 	    (SELECT qc_i.value from quiz_control qc_i where qc_i.key = 'MAX_GIVEUP') - (SELECT count(*) from answer a_i where a_i.answer = 'GIVEUP' and a_i.user_id = '$userid') as quiz_give_count_left
            ,       (SELECT qc_i.value from quiz_control qc_i where qc_i.key = 'PLAY_AUDIO') as play_audio
            ,       (SELECT qc_i.value from quiz_control qc_i where qc_i.key = 'PLAY_AUDIO_FILE') as play_audio_file
            ,       (SELECT qc_i.value from quiz_control qc_i where qc_i.key = 'PLAY_VIDEO') as play_video
            ,       (SELECT qc_i.value from quiz_control qc_i where qc_i.key = 'PLAY_VIDEO_FILE') as play_video_file
            FROM quiz_control qc, quiz q, code c 
            WHERE qc.KEY = 'CURRENT_QUIZ' AND qc.VALUE = q.id AND c.code = q.type";

    
    
    
    /*
    
    $sql = "SELECT qc.value as current_quiz
        ,       q.id
        ,       q.quiz
        ,       q.anwser
        ,       c.code_name as type
        ,       (SELECT value from quiz_control iqc where iqc.key = 'DISPLAY_ANSWER') as display
        ,       (SELECT answer from answer where user_id = '$userid' and quiz_id = q.id) as user_answer
        ,       (SELECT user.name from quiz, user where quiz.owned_userid = user.userid and quiz.id = q.id) as quiz_register_user
        ,       (SELECT count(answer.like) from answer where answer.like = 'Y' and answer.quiz_id = q.id  and answer.user_id = '$userid') as quiz_like_user
        ,       (SELECT count(answer.like) from answer where answer.like = 'N' and answer.quiz_id = q.id  and answer.user_id = '$userid') as quiz_dislike_user
        ,       (SELECT count(answer.like) from answer where answer.like = 'Y' and answer.quiz_id = q.id) as quiz_like
        ,       (SELECT count(answer.like) from answer where answer.like = 'N' and answer.quiz_id = q.id) as quiz_dislike
        FROM quiz_control qc, quiz q, code c 
        WHERE qc.KEY = 'CURRENT_QUIZ' AND qc.VALUE = q.id AND c.code = q.type";
   /*
     * 
     */
    $list = getListWithJSON($sql);
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: X-Requested-With');
    header('Access-Control-Max-Age: 86400');
   
    header("Content-Type:text/html; charset-utf-8"); 
    header("Content-Type: application/json"); 
    echo $list;
?>