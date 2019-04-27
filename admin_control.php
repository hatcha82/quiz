<?php
  include_once("./include/common_function.php");
  session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>관리자</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="./css/style.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="./js/jquery-1.11.1.min.js"></script>
  <script src="./js/common.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-md-8">
        <div class="jumbotron">
          <div class="container">
            
            <p class="text-center">
               <a class="btn btn-primary btn-lg" style="width:48%" id="PREV_BTN"  role="button" onclick="admin_change_quiz('PREV')">이전</a>
               <a class="btn btn-danger btn-lg" style="width:48%" id="NEXT_BTN"  role="button" onclick="admin_change_quiz('NEXT')">다음</a>
            </p>
            <p class="text-center">
                <a class="btn btn btn-primary btn-lg " style="width:48%" id="SHOW_RESULT_BTN"  role="button" onclick="admin_show_quiz_answer('YES')">결과보기</a>
                <a class="btn btn btn-danger btn-lg " style="width:48%" id="SHOW_RESULT_BTN"  role="button" onclick="admin_show_quiz_answer('NO')">결과숨기기</a>
            </p>
            <p class="text-center">
                <a class="btn btn btn-primary btn-lg " style="width:48%" id="SHOW_RESULT_BTN"  role="button" onclick="admin_show_quiz_result('YES')">최종결과보기</a>
                <a class="btn btn btn-danger btn-lg " style="width:48%" id="SHOW_RESULT_BTN"  role="button" onclick="admin_show_quiz_result('NO')">최종결과숨기기</a></p>
            <p>
            <p class="text-center">
                <a class="btn btn btn-warning btn-lg btn-block" sid="SHOW_RESULT_BTN"  role="button" onclick="admin_reset()">퀴즈 리셋</a>
               
            <p>    
              <small>
              Quiz:<span id="quiz_no"></span> 결과보임:<span id="quiz_answer_display_set"></span><br>
              <span id="quiz_context" style="word-break:break-word "></span></small>
            </p>
            <p>
              <small>
              답:<span id="quiz_answer"></span> 
            </p>

           </div>         
        </div>
      </div>
    </div>
  </div>

</body>

</html>

<script>
  function testCallback(list){
    var result = '';
    for (var index in list){
      result += list[index].name + " ";
    }
    $("#test").html(result);
  }
  function admin_change_quiz(value){
    var msg = $("#live_chat_msg").val();
    requestAjax("Ajax_admin_change_quiz.php",debug_server_info, {direction: value});
  }
  function admin_show_quiz_answer(value){
    if(value =="YES"){
        var result = confirm("최종 결과를 보시겠습니까?");
        if (result == true) {
            requestAjax("Ajax_admin_show_quiz_answer.php",debug_server_info, {show:value});
        } 
    }else{
        requestAjax("Ajax_admin_show_quiz_answer.php",debug_server_info, {show:value});
    }  
    
  }
  function admin_show_quiz_result(value){
    if(value =="YES"){
        var result = confirm("최종 결과를 보시겠습니까?");
        if (result == true) {
            requestAjax("Ajax_admin_show_quiz_result.php",debug_server_info, {show:value});
        } 
    }else{
        requestAjax("Ajax_admin_show_quiz_result.php",debug_server_info, {show:value});
    }
  }
  function admin_reset(){
     var result = confirm("경고! 지금까지 퀴즈 답변들이 모두 삭제 됩니다.");
        if (result == true) {
            requestAjax("Ajax_admin_reset.php",debug_server_info, {});
        }  
  }
  function current_quiz_info(list){

    var quiz_no ='';
    var quiz_context = '';
    var quiz_answer = '';
    var quiz_answer_display = ''
    var quiz_type ='';
    var quiz_answer_display_set ='';
    for (var index in list){
      quiz_no = list[index].id;
      quiz_context = list[index].quiz + "<br><br> ";
      quiz_answer = list[index].anwser + " "; 
      quiz_answer_display = list[index].display;
      quiz_answer_display_set = list[index].display;
      quiz_type = list[index].type;  
    }
    
    $("#quiz_no").html(quiz_no + " " +quiz_type);
    $("#quiz_context").html(quiz_context);
    $("#quiz_answer_display_set").html(quiz_answer_display_set);
    if(quiz_answer_display == 'YES'){
      $("#quiz_answer").html(quiz_answer);  
    }else{
      $("#quiz_answer").html('');  
    }
  }

  function debug_user_session_live(data){
    console.log(data);
  }
  $("document").ready(function(){
    setInterval(function(){ 
            //requestAjax("Ajax_test.php",testCallback, {});
            requestAjax("Ajax_current_quiz_info.php",current_quiz_info, {});
          }, 1000);
  });
</script>