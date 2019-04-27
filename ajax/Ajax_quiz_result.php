<?php
    include_once("../include/common_function.php");
    $order_by =  $_POST[orderby];
    
    if(isset($order_by) == false){
        $order_by = 'final desc';
    }
    $sql = "select 	
                    @RNUM := @RNUM + 1 AS ranking,
                    subtotal.userid,
                    subtotal.name,
                    subtotal.total_quiz_count,
                    subtotal.total_correct_answer_count,
                    subtotal.total_incorrect_answer_count,
                    subtotal.total_giveup_answer_count,
                    ROUND((subtotal.total_correct_answer_count/subtotal.total_quiz_count * 100),2) as quiz_success_rate,
                    subtotal.total_quiz_point,
                    subtotal.total_like_point,
                    subtotal.total_like_count,
                    subtotal.total_dislike_count,
                    subtotal.total_like_bonus,
                    (subtotal.total_like_point +  subtotal.total_quiz_point + subtotal.total_like_bonus) as final 
            from 
                    (
                            select 
                                     data_list.name,
                                     data_list.userid,
                                     quiz_point ,
                                     like_point,
                                     count(distinct(id)) as total_quiz_count,
                                     sum(correct_answer) as total_correct_answer_count,
                                     sum(incorrect_answer) as total_incorrect_answer_count,
                                     sum(giveup_answer) as total_giveup_answer_count,
                                     sum(quiz_point) as total_quiz_point,
                                     sum(quiz_like) as total_like_count,
                                     sum(quiz_dislike) as total_dislike_count,
                                     sum(like_point) as total_like_point,	
                                     sum(like_bonus) as total_like_bonus
                            from (
                                            select q.id, q.quiz, q.anwser, a.answer as useranswer, u.name, u.userid,
                                                            (CASE WHEN q.type = 'MORETHANHALF' and  (select count(in_a.answer) from answer in_a where in_a.quiz_id = q.id and in_a.answer = 'Y' and q.owned_userid = u.userid) > (select round(count(*)/2) FROM user ui) 
                                                                            THEN 1
                                                                      WHEN q.anwser = a.answer 
                                                                            THEN 1
                                                                      ELSE 0 
                                                            END) AS correct_answer,
                                                            (CASE WHEN q.type = 'MORETHANHALF' and  (select count(in_a.answer) from answer in_a where in_a.quiz_id = q.id and in_a.answer = 'Y' and q.owned_userid = u.userid) < (select round(count(*)/2) FROM user ui) 
                                                                            THEN 1
                                                                      WHEN q.anwser <> a.answer 
                                                                            THEN 1
                                                                      ELSE 0 
                                                            END) AS incorrect_answer,
                                                            if(a.answer ='GIVEUP',1,0) AS giveup_answer,
                                                            (CASE WHEN q.type = 'MORETHANHALF' and  (select count(in_a.answer) from answer in_a where in_a.quiz_id = q.id and in_a.answer = 'Y' and q.owned_userid = u.userid) > (select round(count(*)/2) FROM user ui) 
                                                                            THEN (select qc.value from quiz_control qc where qc.key = 'CORRECT_ANSWER')
                                                                      WHEN q.type = 'MORETHANHALF' and  (select count(in_a.answer) from answer in_a where in_a.quiz_id = q.id and in_a.answer = 'Y' and q.owned_userid = u.userid) < (select round(count(*)/2) FROM user ui) 
                                                                            THEN (select qc.value from quiz_control qc where qc.key = 'INCORRECT_ANSWER')	
                                                                      WHEN q.anwser = a.answer 
                                                                            THEN (select qc.value from quiz_control qc where qc.key = 'CORRECT_ANSWER')
                                                                      WHEN q.anwser <> a.answer
                                                                            THEN (select qc.value from quiz_control qc where qc.key = 'INCORRECT_ANSWER')
                                                                      ELSE 0 
                                                            END) AS quiz_point,
                                                            if(a.like = 'Y',1,0) as quiz_like,
                                                            if(a.like <> 'N',1,0) as quiz_dislike,
                                                            (CASE WHEN a.like = 'Y' THEN (select qc.value from quiz_control qc where qc.key = 'LIKE_BONUS')
                                                                      WHEN a.like = 'N' THEN (select qc.value from quiz_control qc where qc.key = 'LIKE_PANELTY')
                                                                      ELSE 0 
                                                            END) AS like_point,
                                                            (CASE 
                                                                      WHEN 
                                                                             (select count(in_a.like) from answer in_a where in_a.quiz_id = q.id and in_a.like = 'Y' and q.owned_userid = u.userid) 
                                                                                    >
                                                                             (select count(in_a.like) from answer in_a where in_a.quiz_id = q.id and in_a.like = 'N' and q.owned_userid = u.userid) 
                                                                      THEN (select qc.value from quiz_control qc where qc.key = 'LIKE_POINT')
                                                                      WHEN
                                                                             (select count(in_a.like) from answer in_a where in_a.quiz_id = q.id and in_a.like = 'Y' and q.owned_userid = u.userid) 
                                                                                    <
                                                                             (select count(in_a.like) from answer in_a where in_a.quiz_id = q.id and in_a.like = 'N' and q.owned_userid = u.userid) 
                                                                      THEN (select qc.value from quiz_control qc where qc.key = 'DISLIKE_POINT')
                                                                      ELSE 0
                                                              END) AS like_bonus
                                            from user u left outer join quiz q on (1=1) left outer join answer a on (a.user_id=u.userid and q.id = a.quiz_id)
                                     ) data_list
                            group by name
                    ) subtotal,( SELECT @RNUM := 0 ) R

                    order by $order_by";
        
    $list = getListWithJSON($sql);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type:text/html; charset-utf-8"); 
    header("Content-Type: application/json"); 
    echo $list;
?>