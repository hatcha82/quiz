<?php
  include_once("./include/common_function.php");
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
 <link href="./css/dashboard.css" rel="stylesheet">
  <!-- Latest compiled and minified JavaScript -->
  <script src="./js/jquery-1.11.1.min.js"></script>
  <script src="./js/common.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>

<body>
    

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">2014 티투엘(주) 송년회</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        
          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php">Login</a></li>
          </ul>
          <!--
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
            -->
        </div>
          
              
          
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row" id="display_quiz_result" style="padding:10px;display:none">
          <H1>퀴즈 결과</H1>
              <div class="table-responsive">
                <table class="table table-bordered">
                    <audio controls autoplay id="quiz_basic_speech" style="display:none">
                        <source src="audio/quiz_desc_fixed.mp3" type="audio/mp4" />
                    </audio>
                  <thead>
                    <tr>
                       <th style="text-align:center" >순위</th>
                      <th style="text-align:center" >이름</th>
                      <th style="text-align:center">
                          <span onclick="show_quiz_result_orderby('final desc')" class="glyphicon glyphicon-circle-arrow-up"></span>
                          최종점수
                          <span onclick="show_quiz_result_orderby('final asc')" class="glyphicon glyphicon-circle-arrow-down"></span></th>
                      <th style="text-align:center">
                          <span onclick="show_quiz_result_orderby('total_quiz_point desc')" class="glyphicon glyphicon-circle-arrow-up"></span>
                          퀴즈점수
                          <span onclick="show_quiz_result_orderby('total_quiz_point asc')" class="glyphicon glyphicon-circle-arrow-down"></span>
                      </th>
                      <th style="text-align:center">
                          <span  onclick="show_quiz_result_orderby('total_like_point desc')" class="glyphicon glyphicon-circle-arrow-up"></span>
                          선호점수
                          <span  onclick="show_quiz_result_orderby('total_like_point asc')" class="glyphicon glyphicon-circle-arrow-down"></span>
                      </th>
                      <th style="text-align:center">
                          <span  onclick="show_quiz_result_orderby('total_like_bonus desc')" class="glyphicon glyphicon-circle-arrow-up"></span>
                          문제점수
                          <span  onclick="show_quiz_result_orderby('total_like_bonus asc')" class="glyphicon glyphicon-circle-arrow-down"></span>
                      </th>
                      <th style="text-align:center">
                          <span  onclick="show_quiz_result_orderby('quiz_success_rate desc')" class="glyphicon glyphicon-circle-arrow-up"></span>
                          정답률
                          <span  onclick="show_quiz_result_orderby('quiz_success_rate asc')" class="glyphicon glyphicon-circle-arrow-down"></span>
                      </th>
                      <th style="text-align:center">
                          <span  onclick="show_quiz_result_orderby('total_correct_answer_count desc')" class="glyphicon glyphicon-circle-arrow-up"></span>
                          정답갯수
                          <span  onclick="show_quiz_result_orderby('total_correct_answer_count asc')" class="glyphicon glyphicon-circle-arrow-down"></span>
                      </th>
                      <th style="text-align:center">
                          <span  onclick="show_quiz_result_orderby('total_like_count desc')" class="glyphicon glyphicon-circle-arrow-up"></span>
                          선호도
                          <span  onclick="show_quiz_result_orderby('total_like_count asc')" class="glyphicon glyphicon-circle-arrow-down"></span>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="quiz_result_list">

                  </tbody>
                </table>
              </div>
          </div>  
      <div class="row" id="quiz_display">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#" style="background: #555;">로그인 : <span id="number_of_logon_users">0</span> <span class="sr-only">(current)</span></a></li>
          </ul>
          <ul class="nav nav-sidebar" id="logon_user_list">
            
          </ul>
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#" style="background: #aaa;">로그아웃 : <span id="number_of_logoff_users">0</span> <span class="sr-only">(current)</span></a></li>
          </ul>
          <ul class="nav nav-sidebar" id="logoff_user_list">
            
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Quiz <span id="quiz_no"></span></h1>
          <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" style="font-size:2em">문제<small><span style="float:right;margin-right:20px;" class="glyphicon glyphicon-user" > 출제자:<span id="quiz_owner" > </span></span></small></h3>
            </div>
            <div class="panel-body"  style="font-size:3em">
                <!--<p id="quiz_context" style="min-height: 200px;width:100%;word-wrap: break-word;margin-left:20px;"></p>-->
                <pre id="quiz_context" style="min-height: 200px;width:100%;word-wrap: break-word;"></pre>
            </div>
            <div class="panel-body answer_display" style="font-size:3em">
               <p style="float:left;margin-left:20px;"> 
                   <button type="button" class="btn btn-default btn-lg" aria-label="Left Align">
                    <span class="glyphicon glyphicon-thumbs-up" style="color:blue" aria-hidden="true"></span> <span id="quiz_like" >0</span>
                   </button>
                   <button type="button" class="btn btn-default btn-lg" aria-label="Left Align">
                    <span class="glyphicon glyphicon-thumbs-down" style="color:red" aria-hidden="true"></span> <span id="quiz_dislike" >0</span>
                   </button> 
               </p>
               <p style="float:right;margin-right:20px;"> 
               정답: </span><span id="quiz_answer" ></span>
               </p>
            </div>
            <div class="panel-body user_ready_display" style="font-size:3em">
                <div class="panel panel-success" style="width:49%;margin-left:1%;float:left;font-size:12px">
                    <div class="panel-heading" style="font-size:20px"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 준비 완료</h4></div>
                    <div class="panel-body">
                    <p id="quiz_ready_list" style="word-wrap: break-word;" class="readyListGroup"></p>
                    </div>
                </div>
                <div class="panel panel-warning" style="width:49%;margin-left:1%;float:left;font-size:12px">
                    <div class="panel-heading" style="font-size:20px"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> 준비중</h4></div>
                    <div class="panel-body">
                    <p id="quiz_not_ready_list" style="word-wrap: break-word;"  class="readyListGroup"></p>
                    </div>
                </div>
            </div>  
            <div class="panel-body answer_display" style="font-size:3em">
                <div class="panel panel-success" style="width:32%;margin-left:1%;float:left;font-size:12px">
                    <div class="panel-heading" style="font-size:20px"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 정답</h4></div>
                    <div class="panel-body">
                    <p id="quiz_correct_list" style="word-wrap: break-word;"  class="answerListGroup"></p>
                    </div>
                </div>
                <div class="panel panel-danger" style="width:32%;margin-left:1%;float:left;font-size:12px">
                    <div class="panel-heading" style="font-size:20px"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> 오답</h4></div>
                    <div class="panel-body">
                    <p id="quiz_incorrect_list"  style="word-wrap: break-word;" class="answerListGroup"></p>
                    </div>
                </div>
                <div class="panel panel-warning" style="width:32%;margin-left:1%;float:left;font-size:12px">
                    <div class="panel-heading" style="font-size:20px"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span> 포기</h4></div>
                    <div class="panel-body">
                    <p id="quiz_giveup_list"  style="word-wrap: break-word;"  class="answerListGroup"></p>
                    </div>
                </div>
            </div>
             
                
          </div><!-- display quiz panel end -->
          
          

          <h2 class="sub-header">실시간 댓글</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th "text-center">#</th>
                  
                  <th "text-center">내용</th>
                  
                  
                </tr>
              </thead>
              <tbody id="live_chat_list">
                
              </tbody>
            </table>
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
  function current_quiz_info(list){

    var quiz_no ='';
    var quiz_context = '';
    var quiz_answer = '';
    var quiz_register_user='';
    var quiz_answer_display = ''
    var quiz_like = '';
    var quiz_dislike = '';
    var quiz_type ='';
    var quiz_giveup_list = '';
    var quiz_correct_list = '';
    var quiz_incorrect_list = '';
    var quiz_ready_list ='';
    var quiz_not_ready_list ='';
    var display_quiz_result = ''
    
    for (var index in list){
      quiz_no = list[index].id;
      quiz_context = list[index].quiz + "<br><br> ";
      quiz_answer = list[index].anwser + " "; 
      quiz_register_user = list[index].quiz_register_user;
      quiz_answer_display = list[index].display;
      quiz_like =list[index].quiz_like;
      quiz_dislike = list[index].quiz_dislike;
      quiz_type = list[index].type; 
      quiz_giveup_list = list[index].quiz_giveup_list; 
      quiz_correct_list = list[index].quiz_correct_list; 
      quiz_incorrect_list =  list[index].quiz_incorrect_list; 
      quiz_ready_list = list[index].quiz_ready_list;
      quiz_not_ready_list  = list[index].quiz_not_ready_list;
      display_quiz_result =list[index].display_quiz_result;
    }
    
    $("#quiz_no").html(quiz_no + " " +quiz_type);
    $("#quiz_owner").html(quiz_register_user);
    $("#quiz_context").html(quiz_context);
    $("#quiz_like").html(quiz_like);
    $("#quiz_dislike").html(quiz_dislike);
    $("#quiz_ready_list").html(quiz_ready_list);  
    $("#quiz_not_ready_list").html(quiz_not_ready_list);  
    $("p.readyListGroup").css("height","");
    $("p.answerListGroup").css("height","");
    var readyHeightArray = [];
    var readyParsePHeight1 = parseInt($("#quiz_ready_list").css("height").replace("px",""))
    var readyParsePHeight2 = parseInt($("#quiz_not_ready_list").css("height").replace("px",""))

    var readyApplyPHeight;
    readyHeightArray.push(readyParsePHeight1);
    readyHeightArray.push(readyParsePHeight2);

    readyApplyPHeight = Math.max.apply(Math, readyHeightArray);
    $("p.readyListGroup").css("height",readyApplyPHeight);

    if(quiz_answer_display == 'YES'){ 
      $(".answer_display").fadeIn();
      $(".user_ready_display").hide();
      $("#quiz_answer").html(quiz_answer);  
      $("#quiz_giveup_list").html(quiz_giveup_list);  
      $("#quiz_correct_list").html(quiz_correct_list);
      $("#quiz_incorrect_list").html(quiz_incorrect_list);
      
     
      var resultHeightArray = [];
      var parsePHeight1 = parseInt($("#quiz_giveup_list").css("height").replace("px",""))
      var parsePHeight2 = parseInt($("#quiz_correct_list").css("height").replace("px",""))
      var parsePHeight3 =  parseInt($("#quiz_incorrect_list").css("height").replace("px",""))
      var applyPHeight;
      resultHeightArray.push(parsePHeight1);
      resultHeightArray.push(parsePHeight2);
      resultHeightArray.push(parsePHeight3);
      applyPHeight = Math.max.apply(Math, resultHeightArray);
      $("p.answerListGroup").css("height",applyPHeight);
      
      
      
    }else{
      $(".answer_display").hide()
      $(".user_ready_display").fadeIn(); 
      $("#quiz_answer").html('');  
      $("#quiz_giveup_list").html('');  
      $("#quiz_correct_list").html('');
      $("#quiz_incorrect_list").html('');
    }
    
    
    
    if(display_quiz_result =="YES"){
        requestAjax("Ajax_quiz_result.php",show_quiz_result_callback, {});
        $("#quiz_display").hide();
        $("#display_quiz_result").fadeIn();
    }else{
        $("#quiz_display").show();
        $("#display_quiz_result").hide();
    }
  }
  function current_user_list(list){

    var logon_html = '';
    var logoff_html = '';
    var logon_count = 0;  
    var logoff_count = 0;  
    var total_user_count =0;        
    var quiz_register_status ='';
    for (var index in list){
      if(list[index].registed_quiz_count == list[index].max_quiz_count){
          quiz_register_status = " <small style='color:blue'>(퀴즈 등록 완료)</small>"
      }else{
          quiz_register_status = " <small style='color:red'>(등록: "+ list[index].registed_quiz_count+" / 최대퀴즈: "+ list[index].max_quiz_count+")</small>";
      }  
        
      if(list[index].login_info == "LOGON"){
          
        logon_html += "<li><a href='' style='color:#555'>"+list[index].name+quiz_register_status+" </a></li>";
        logon_count++;
      }else{
         logoff_html += "<li><a href='' style='color:#aaa'>"+list[index].name+quiz_register_status+" </a></li>";
         logoff_count++;
      }
      total_user_count++;
      
    }
    
    $("#number_of_logon_users").html(logon_count + " / " + total_user_count);
    $("#number_of_logoff_users").html(logoff_count  + " / " + total_user_count);
    $("#logon_user_list").html(logon_html);
    $("#logoff_user_list").html(logoff_html);
    
    
  }
  function show_quiz_result_callback(list){
    
    var html = "";
    var count = 0;
    for (var index in list){
      
    html+='        <tr>';
    html+='          <td style="text-align:center">'+list[index].ranking+'</td>';
    html+='          <td style="text-align:center">'+list[index].name+'</td>';
    html+='          <td style="text-align:right">'+list[index].final+'</td>';
    html+='          <td style="text-align:right">'+list[index].total_quiz_point+'</td>';
    html+='          <td style="text-align:right">'+list[index].total_like_point+'</td>';
    html+='          <td style="text-align:right">'+list[index].total_like_bonus+'</td>';
    html+='          <td style="text-align:right">'+list[index].quiz_success_rate+'%</td>';
    html+='          <td style="text-align:center"><span style="color:blue">'+list[index].total_correct_answer_count+'</span> / <span style="color:orange">'+list[index].total_giveup_answer_count+'</span> / <span style="color:red">'+ list[index].total_incorrect_answer_count+'</span></td>';
    html+='          <td style="text-align:center"><span style="color:blue">'+list[index].total_like_count+'</span> / <span style="color:red">'+ list[index].total_dislike_count+'</span></td>';
    html+='        </tr>';
      count++;
    }
    
    $("#quiz_result_list").html(html);
  }
  function show_quiz_result_orderby(order){
    requestAjax("Ajax_quiz_result.php",show_quiz_result_callback, {orderby:order});
  }
  function show_quiz_result(){
      requestAjax("Ajax_quiz_result.php",show_quiz_result_callback, {});
  }
  function live_chat_list(list){
    var html = "";
    
    //<tr class="active">...</tr>
    //<tr class="success">...</tr>
    //<tr class="warning">...</tr>
    //<tr class="danger">...</tr>
    //<tr class="info">...</tr>
    var count = 0;
    for (var index in list){
      
        html+="<tr class=''>";
      
      html+=  "<td style='vertical-align:middle'>"+list[index].id;+"</td>";
     // html+=  "<td style='width:80px;vertical-align:middle'>"+list[index].user_name;+"</td>";
     
      var context = list[index].context;
      html+=  "<td style='vertical-align:middle;'>";
     
      html+=         "<pre style='margin-top:10px;float:left;width:83%'>"+context+"</pre>";
      html+='<div style="width:15%;float:right;padding-top:10px" class="glyphicon glyphicon-user" aria-hidden="true">'+list[index].user_name+'<br>'+list[index].inserted_date +' </div>';
      html+=  "<div class='clear:both'></div>"; 
      html+=  "</td>";
      // html+=  "<td style='width:150px;vertical-align:middle'>"+list[index].inserted_date;+"</td>";
      html+="</tr>";
      count++;
    }
    
    $("#live_chat_list").html(html);
  }
  function debug_user_session_live(data){
    console.log(data);
  }
  $("document").ready(function(){
    setInterval(function(){ 
      //requestAjax("Ajax_test.php",testCallback, {});
      requestAjax("Ajax_current_quiz_info.php",current_quiz_info, {});
      requestAjax("Ajax_current_user_list.php",current_user_list, {});
      requestAjax("Ajax_live_chat_list.php",live_chat_list, {});
    }, 1000);
    
  });
</script>