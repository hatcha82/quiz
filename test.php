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
  <title>티투엘 퀴즈</title>

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
  <div id="test">1</div>
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
  function send_live_chat_msg(){
    var msg = $("#live_chat_msg").val();
    requestAjax("Ajax_live_chat_send_msg.php",debug_server_info, {context: msg});
  }
  function current_quiz_info(list){

    var quiz_no ='';
    var quiz_context = '';
    var quiz_answer = '';
    var quiz_answer_display = ''
    var quiz_type ='';

    for (var index in list){
      quiz_no = list[index].id;
      quiz_context = list[index].quiz + "<br><br> ";
      quiz_answer = list[index].anwser + " "; 
      quiz_answer_display = list[index].display;
      quiz_type = list[index].type;  
    }
    
    $("#test").html(quiz_no + " " +quiz_type);
    
  }

  function debug_user_session_live(data){
    console.log(data);
  }
  $("document").ready(function(){
	  $(function () {
		setInterval(function () {
			 requestAjax("Ajax_current_quiz_info.php",current_quiz_info, {});
		}, 1000)  
	});
   
  });
</script>