<?php
    include_once("./include/common_function.php");
    session_start();
    if(isset($_SESSION["userid"]) == false){
        $_SESSION["login_error_msg"] = "로그인이 필요합니다.";
        header( "Location:../login.php" );
    }    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
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
        
        <div class="container-fluid">
            <div class="page-header">
                <h1><small> Trade to logistics<a style="float:right;font-size:15px;margin-top:15px;" href="./action/Action_logout.php">로그아웃</a></small></h1>
                
            </div>
            <ul class="nav nav-pills">
                <li role="presentation" class="active" onclick="quiz_menu('home')"><a href="#">현재퀴즈</a></li>
                <li role="presentation" onclick="quiz_menu('register_quiz')"><a href="#">퀴즈등록</a></li>
                <li role="presentation" onclick="quiz_menu('registed_quizs')"><a href="#">내 퀴즈보기</a></li>
            </ul>
            
            <form id="user_answer_form">
            <div class="row current_quiz">
                
                <div class="col-md-1">
                    
                    <div class="thumbnail"> 
                        
                        
                        <div class="caption">
                            <h3 style="margin-bottom:10px">
                                <span style="float:left">Quiz</span>
                                <span style="float:left;margin-left:10px;" id="quiz_no"></span>
                                <span style="float:left;margin-left:10px;" id="quiz_type"></span>
                               
                                
                                <span style="float:right"><small>참가자: <?= $_SESSION["username"]; ?></small></span>
                                
                            </h3>
                            <div class="clearfix visible-xs-block" ></div>
                        </div>
                        <div class="caption">
                            <div style="border-bottom:1px solid #eee;margin-bottom:10px;padding-bottom:10px;">
                                <p class="text-info" >문제: <pre id="quiz_context" style="word-wrap: break-word;"></pre></p>                            
                                <p><span style="float:right;margin-left:10px;" id="quiz_register_user_display"></span></p>
                                <div style="clear:both;"></div>
                                <p style="float:right;margin-top:10px">
                                <input type="hidden" name="user_vote_answer" id="user_vote_answer" value=""/>    
                                <button type="button" class="btn btn-default" aria-label="Left Align" onclick="send_quiz_vote('Y')">
                                    <span class="glyphicon glyphicon-thumbs-up" style="color:blue" aria-hidden="true"></span> <span id="quiz_like" >0</span>
                                </button>
                                <button type="button" class="btn btn-default" aria-label="Left Align" onclick="send_quiz_vote('N')">
                                    <span class="glyphicon glyphicon-thumbs-down" style="color:red;" aria-hidden="true"></span> <span id="quiz_dislike" >0</span>
                                </button>
                                </p>
                                <div style="clear:both;"></div>   
                            </div>
                            <p style="float:left;width:50%">당신의 선택: <span id="user_quiz_answer_display"></span></p>    
                            <p style="float:right;width:50%"><span style="float:right">정답: <span id="quiz_answer"></span></span></p>
                            <span style="float:left;">준비 완료: <span id="quiz_ready"></span></span>
                            <span style="float:right" onclick="quiz_menu('live_chat')"><a href="#">실시간 댓글</a></span>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-success" role="alert" id="user_ready_success_msg" style="display:none"></div>
            <div class="alert alert-danger" role="alert" id="user_ready_fail_msg" style="display:none"></div>    
            <div class="row current_quiz">
                <div class="col-xs-12 col-md-8">
                    <div class="jumbotron">
                        <div class="container">
                            <input type="hidden" name="user_quiz_id" id="user_quiz_id" val=""/>
                            <input type="hidden" name="user_quiz_answer" id="user_quiz_answer" val=""/>
                            <p><a class="btn btn-primary btn-lg btn-block" id="YES_BTN"  role="button" onclick="send_user_answer('O')">예</a></p>
                            <p><a class="btn btn-danger btn-lg btn-block" id="NO_BTN"  role="button" onclick="send_user_answer('X')">아니오</a></p>
                            <p><a class="btn btn-warning btn-lg btn-block" id="GIVEUP_BTN"  role="button" onclick="send_user_answer('GIVEUP')">포기</a></p>
                            <p><a class="btn btn btn-success btn-lg btn-block" id="READY_BTN"  onclick="send_user_ready()" role="button">완료</a></p>
                        </div>         
                    </div>
                </div>
            </div>
            </form>
            <form id="quiz_register_form">
            <div class="row register_quiz">
                
                <div class="col-md-1">
                    
                    <div class="thumbnail"> 
                        
                        <div class="caption"> 
                            <div class="clearfix visible-xs-block" >
                                <label class="radio-inline inlineRadio1">
                                    <input type="radio" name="quiz_type" id="inlineRadio1" value="BINARY" checked onclick="quiz_type_select('ox')"> O/X 퀴즈
                                </label>
                                <label class="radio-inline inlineRadio2">
                                    <input type="radio" name="quiz_type" id="inlineRadio2" value="SHORT" onclick="quiz_type_select('short')"> 단답형
                                </label>
                                <label class="radio-inline inlineRadio3">
                                    <input type="radio" name="quiz_type" id="inlineRadio3" value="MORETHANHALF" onclick="quiz_type_select('morethanhalf')"> 과반수
                                </label>
                                <!--
                                <label class="radio-inline">
                                    <input type="radio" name="quiz_type" id="inlineRadio3" value="SELECT" onclick="quiz_type_select('select')"> 선택형
                                </label>
                                -->
                            </div>
                        </div>
                        <div class="caption">
                            <div>
                                
                                <input type="hidden" name="userid" id="userid" value="<?= $_SESSION["userid"]; ?>"/>
                                
                                <input type="hidden" name="registed_quiz_id" id="registed_quiz_id" value=""/>
                                <textarea id="register_quiz_question" name="quiz_context" class="form-control" rows="5" placeholder="퀴즈 문제는 10자이상 입력해야합니다." onkeyup="diplay_quiz_length()"></textarea>
                                <small><span style="float:right;margin-top:3px;margin-right: 10px;">글자수:<span id="diplay_quiz_length">0</span></span></small><small>
                                
                                <h4 class="register_quiz_answer">퀴즈 정답:</h4>
                                <div class="register_quiz_anser_ox">
                                    <label class="radio-inline">
                                        <input type="radio" name="oxRadio" id="oxRadioO" checked value="O" >O (예)
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="oxRadio" id="oxRadioX" value="X">X (아니오)
                                    </label>
                                </div>
                                
                                
                                <div class="register_quiz_anser_select">
                                    <label class="radio-inline">
                                        <input type="radio" name="selectRadio" id="selectRadio1" checked value="O" >1
                                    </label>
                                    <input type="text" name="register_quiz_anser_select1" class="form-control register_quiz_anser_select" placeholder="선택1" required="" autofocus="" value="">
                                    <br>
                                    <label class="radio-inline">
                                        <input type="radio" name="selectRadio" id="selectRadio2" value="X">2
                                    </label>
                                    <input type="text" name="register_quiz_anser_select2" class="form-control register_quiz_anser_select" placeholder="선택2" required="" autofocus="" value="">
                                    <br>
                                    <label class="radio-inline">
                                        <input type="radio" name="selectRadio" id="selectRadio3" checked value="O" >3
                                    </label>
                                    <input type="text" name="register_quiz_anser_select3" class="form-control register_quiz_anser_select" placeholder="선택3" required="" autofocus="" value="">
                                    <br>
                                    <label class="radio-inline">
                                        <input type="radio" name="selectRadio" id="selectRadio4" value="X">4
                                    </label>
                                    <input type="text" name="register_quiz_anser_select4" class="form-control register_quiz_anser_select" placeholder="선택4" required="" autofocus="" value="">
                                    <br>
                                </div>
                                <input type="text" name="register_quiz_anser_short" class="form-control register_quiz_anser_short" id="register_quiz_anser_short" placeholder="퀴즈 정답" required="" autofocus="" value="">
                                <div style="margin-top:5px">
                                <div class="alert alert-success" role="alert" id="user_answer_success_msg" style="display:none"></div>
                                <div class="alert alert-danger" role="alert" id="user_answer_register_quiz_fail_msg" style="display:none"></div>
                                <div class="alert alert-success" role="alert" id="success_msg" style="display:none"></div>
                                <div class="alert alert-danger" role="alert" id="register_quiz_fail_msg" style="display:none"></div>
                                    
                                </div>
                                <p style="padding:20px 0;">
                                    <a class="btn btn btn-info btn-lg btn-block" id="registed_quiz_btn" role="button" onclick="register_quiz()">퀴즈 등록</a>
                                    <a class="btn btn btn-warning btn-lg btn-block" id="NO_BTN" role="button" onclick="reset_form()">리셋</a></p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="row registed_quizs">
                <div class="col-md-1">
                    <div class="thumbnail"> 
                        <div class="caption">
                            <h3 style="margin-bottom:10px">
                                내가 등록한 퀴즈
                            </h3>
                            <div class="clearfix visible-xs-block" ></div>
                        </div>
                        
                            <div class="table-responsive">                                
                                <table class="table table-condensed">
                                  <thead>
                                    <tr>
                                      
                                      <th "text-center">퀴즈</th>
                                    </tr>
                                  </thead>
                                  <tbody id="user_registed_quiz_table_body">
                                   
                                  </tbody>
                                </table>
                            </div>
                        
                    </div>
                </div>
            </div>
            <div class="row live_chat">
                <div class="col-md-1">
                    <div class="thumbnail"> 
                        <div class="caption">
                            <h3 style="margin-bottom:10px">
                                <span style="float:left">실시간 댓글</span><span style="float:left;margin-left:10px;" id="quiz_no"></span>
                                <span style="float:right"><small>참가자: <?= $_SESSION["username"]; ?></small></span>
                            </h3>
                            <div class="clearfix visible-xs-block" ></div>
                        </div>
                        <div class="caption">
                            <p>
                                <textarea id="live_chat_msg" class="form-control" rows="5"></textarea>
                            </p>
                            <p><a class="btn btn btn-warning btn-lg btn-block" id="NO_BTN" role="button" onclick="send_live_chat_msg()">전송</a>
                            
                        </div>
                    </div>
                </div>
            </div>




        </div>

    </body>

</html>

<script>
    function testCallback(list) {
        var result = '';
        for (var index in list) {
            result += list[index].name + " ";
        }
        $("#test").html(result);
    }
    function diplay_quiz_length(){
        var quiz_length = $("#register_quiz_question").val().length;
        $("#diplay_quiz_length").html( quiz_length);
    }
    function reset_answer_form(){
        $("#user_quiz_answer_display").html('');
        $('#user_answer_form')[0].reset();
    }
    function reset_form(){
        $("#diplay_quiz_length").html("0");
        $("#registed_quiz_id").val("");
        $("#register_quiz_question").html("")
        
        $('#quiz_register_form')[0].reset();
        $("#registed_quiz_btn").html("퀴즈 등록");  
    }
    function send_quiz_vote(vote_answer){
        $("#user_vote_answer").val(vote_answer);
        var form_data = $("#user_answer_form").serialize();
        requestAjax("Ajax_user_vote.php", debug_server_info, form_data);
    }
    function send_user_answer_callback(data){
        if(data == "success"){
            var user_answer = $("#user_quiz_answer").val();
            $("#user_answer_success_msg").show();
            $("#user_answer_success_msg").html("정답 등록에 성공하였습니다.");
            $("#user_answer_success_msg").fadeOut(2000);
            
            $("#user_quiz_answer_display").html(user_answer);
        }else{
            $("#user_answer_fail_msg").show();
            $("#user_answer_fail_msg").html("정답 등록에 실패하였습니다.");
            $("#user_answer_fail_msg").fadeOut(2000);
        }
        
    }
    function ready_quiz_by_id_callback(data){
        if(data == "success"){
            $('#user_ready_success_msg').show();
            $('#user_ready_success_msg').html("퀴즈 준비 완료.");
            $('#user_ready_success_msg').fadeOut(2000); 
        }else{
            $('#user_ready_fail_msg').show();
            $('#user_ready_fail_msg').html("퀴즈 준비 실패 다시 시도해주세요.");
            $('#user_ready_fail_msg').fadeOut(2000); 
        }
    }
    function send_user_ready(){
        var readyStatus = $("#quiz_ready").html().trim();
        
        var user_quiz_answer_display = $("#user_quiz_answer_display").html().trim();
        var quiz_like = $("#quiz_like").html().trim();
        var quiz_dislike = $("#quiz_dislike").html().trim();
        var vote_count =  parseInt(quiz_like) + parseInt(quiz_dislike);
        if(user_quiz_answer_display.length <= 0){
            $('#user_ready_fail_msg').show();
            $('#user_ready_fail_msg').html("정답을 선택 또는 포기하지 않았습니다.");
            $('#user_ready_fail_msg').fadeOut(2000); 
            return;
        }
        if(vote_count == 0){
            $('#user_ready_fail_msg').show();
            $('#user_ready_fail_msg').html("문제의 선호도를 선택해주세요.");
            $('#user_ready_fail_msg').fadeOut(2000); 
            return;
        }
        if(readyStatus =="완료"){
            $('#user_ready_fail_msg').show();
            $('#user_ready_fail_msg').html("이미 완료 상태입니다.");
            $('#user_ready_fail_msg').fadeOut(2000); 
            return;
        }
        
        var result = confirm("퀴즈준비 완료하겠습니까?, 완료이후 퀴즈정답 및 선호도를 수정할 수 없습니다. 진행하시겠습니까?");
        if (result == true) {
            var id = $("#quiz_no").html();
            requestAjax("Ajax_user_ready.php", ready_quiz_by_id_callback, {user_quiz_id : id});
        } 
    }
    function send_user_answer(answer){
        var readyStatus = $("#quiz_ready").html().trim();
        if(readyStatus =="완료"){
            $('#user_ready_fail_msg').show();
            $('#user_ready_fail_msg').html("이미 완료 상태입니다. 퀴즈 수정이 불가능합니다.");
            $('#user_ready_fail_msg').fadeOut(2000); 
            return;
        }
        $("#user_quiz_answer").val(answer);
        
        var form_data = $("#user_answer_form").serialize();
        requestAjax("Ajax_user_answer.php", send_user_answer_callback, form_data);
    }
    function delete_quiz_by_id_callback(data){
        if(data == "delete_success"){
            requestAjax("Ajax_user_registered_quiz_list.php", user_registed_quiz_list, {});
        }
        
    }
    
    function delete_quiz_by_id(id){
        var result = confirm("퀴즈를 삭제 하시겠습니까?");
        if (result == true) {
            requestAjax("Ajax_quiz_delete.php", delete_quiz_by_id_callback, {quiz_id : id});
        } 
        
    }
    function update_quiz(quiz_no, quiz_answer, quiz_type){
        var quiz_context = $("#quiz_context_id_" + quiz_no).html();
        quiz_type = quiz_type.trim();
        quiz_answer = quiz_answer.trim();
        quiz_context = quiz_context.replace(/<br>/g, '\n');
        
        
        $(".registed_quizs").hide();
        $(".register_quiz").show();
        
        $("#registed_quiz_btn").html("퀴즈 수정"); 
        $("#registed_quiz_id").val(quiz_no);
        $("#register_quiz_question").html(quiz_context);
        $(".inlineRadio1").hide();
        $(".inlineRadio2").hide();
        $(".inlineRadio3").hide();
        if(quiz_type == "BINARY"){
            if(quiz_answer == "O"){
                $("#oxRadioO").click();
            }else if(quiz_answer == "X"){
                $("#oxRadioX").click();
            }
                        
            $(".inlineRadio1").show();
            $("#inlineRadio1").click();
        }else if(quiz_type == "SHORT"){
            $(".inlineRadio2").show();
            $("#inlineRadio2").click();
            $("#register_quiz_anser_short").val(quiz_answer) ;
        }else if(quiz_type == "MORETHANHALF"){
            $(".inlineRadio3").show();
            $("#inlineRadio3").click();
        }
        diplay_quiz_length();
        
    }
    function register_quiz_callback(data){
        
        if(data =="edit_success"){
            
            $("#registed_quiz_btn").html("퀴즈 수정"); 
            $('#success_msg').show();
            $('#success_msg').html("퀴즈가 수정되었습니다.");
            $('#success_msg').fadeOut(2000);
        }else if(data !="fail"){
            if(data.indexOf("MAX_ALLOW") != -1){
             
                var temp_str = data.split(":");
                var max_allow = temp_str[1];
                var user_quiz_count = temp_str[3];
                $('#register_quiz_fail_msg').show();
                $('#register_quiz_fail_msg').html("퀴즈는 종류별 각각 "+max_allow+"개씩 등록가능합니다. 현재 이종류의  "+user_quiz_count+"개가 등록되어있습니다.");
                $('#register_quiz_fail_msg').fadeOut(2000);
                $("#registed_quiz_btn").html("퀴즈 등록");  
            }else{
                $("#registed_quiz_id").val(data);
            $('#success_msg').show();
            $('#success_msg').html("퀴즈가 등록되었습니다.");
            $('#success_msg').fadeOut(2000);
            $("#registed_quiz_btn").html("퀴즈 수정");  
            }
        }
        
        
    }
    function register_quiz(){
        
        if( $("#register_quiz_question").val().length <= 10){
            $('#register_quiz_fail_msg').show();
            $('#register_quiz_fail_msg').html("퀴즈는 10자 이상입력해야합니다.");
            $('#register_quiz_fail_msg').fadeOut(2000);
            $("#register_quiz_question").focus();
            return;
        }
        
        if( $("#inlineRadio1").is(':checked') ){
           
        }else if( $("#inlineRadio2").is(':checked')){
            var short_answer = $("#register_quiz_anser_short").val().trim();; 
            
            //&&  /\s/.test( $("#register_quiz_anser_short").val() ) == true   
            
            
            if(short_answer.length == 0){
                $('#register_quiz_fail_msg').show();
                $('#register_quiz_fail_msg').html("정답을 입력해주세요.");
                $('#register_quiz_fail_msg').fadeOut(2000);
                $('#register_quiz_anser_short').focus();
                return;
            }else if(/\s/.test(short_answer)){
                $('#register_quiz_fail_msg').show();
                $('#register_quiz_fail_msg').html("정답은 한단어로 써주세요.");
                $('#register_quiz_fail_msg').fadeOut(2000);
                $('#register_quiz_anser_short').focus();
                return;
            }
            
            
        }else if( $("#inlineRadio3").is(':checked') ){
           
        }
        
        
        var form_data = $("#quiz_register_form").serialize();
        requestAjax("Ajax_quiz_register.php", register_quiz_callback, form_data);
       
    }
    function send_live_chat_msg() {
        var msg = $("#live_chat_msg").val();
        requestAjax("Ajax_live_chat_send_msg.php", msg_sent_reset, {context: msg});
    }
    function msg_sent_reset(data) {

        if (data ==$("#userid").val()) {
            alert("메세지가 등록되었습니다");
            $("#live_chat_msg").val('');
        }
    }
    function current_quiz_info(list) {

        var quiz_no = '';
        var quiz_context = '';
        var quiz_answer = '';
        var quiz_answer_display = ''
        var quiz_type = '';
        var quiz_register_user ='';
        var quiz_like_user = '';
        var quiz_dislike_user = '';
        var user_answer = '';
        var user_ready = '';
        

        for (var index in list) {
            quiz_no = list[index].id;
            quiz_context = list[index].quiz + "<br><br> ";
            quiz_answer = list[index].anwser + " ";
            quiz_answer_display = list[index].display;
            quiz_type = list[index].type;
            quiz_register_user = list[index].quiz_register_user;
            quiz_like_user = list[index].quiz_like_user;
            quiz_dislike_user = list[index].quiz_dislike_user;
            user_answer = list[index].user_answer;
            user_ready = list[index].user_ready;
           
            
        }
        
        $("#quiz_no").html(quiz_no);
        $("#quiz_type").html(" " + quiz_type);
        if(user_ready =='Y'){
            $("#quiz_ready").css("color","blue");
            $("#quiz_ready").html(" 완료");
        }else{
            $("#quiz_ready").css("color","red");
            $("#quiz_ready").html(" 준비중");
        }
            
        
        
        $("#user_quiz_id").val(quiz_no);
        $("#quiz_context").html(quiz_context);
        $("#quiz_register_user_display").html("Quiz 등록자: "+quiz_register_user);
        $("#quiz_like").html(quiz_like_user);
        $("#quiz_dislike").html(quiz_dislike_user);
        $("#user_quiz_answer_display").html(user_answer);
        
        
        if (quiz_answer_display == 'YES') {
            $("#quiz_answer").html(quiz_answer);
        } else {
            $("#quiz_answer").html('');
        }
    }
    
    function user_registed_quiz_list(list){
        var quiz_no = '';
        var quiz_context = '';
        var quiz_answer = '';
        var quiz_type = '';
        var quiz_type_code = ''
        var tbl_size = $(window).width() - 70;
        var html = '';
        for (var index in list) {
            quiz_no = list[index].id;
            quiz_context = list[index].quiz + "<br><br> ";
            quiz_type = list[index].type;
            quiz_type_code = list[index].type_code;
            quiz_answer = list[index].answer;
            
            
            html += '<tr>';
            html +=   '<td "text-center" style="padding:3px"><div style="padding:5px">';
            if(quiz_type == "과반수"){
            html +=      '<p>퀴즈 번호: '+quiz_no+' 퀴즈 종류: '+quiz_type+'</p><pre style="width:'+tbl_size+'px;margin:auto" id="quiz_context_id_'+quiz_no+'">'+quiz_context.trim()+'</pre>';    
            }else{
            html +=      '<p>퀴즈 번호: '+quiz_no+' 퀴즈 종류: '+quiz_type+'</p><pre style="width:'+tbl_size+'px;margin:auto" id="quiz_context_id_'+quiz_no+'">'+quiz_context.trim()+'</pre><p style="float:left;margin-top:10px">퀴즈 정답: '+quiz_answer+ '<br><br></p>';
            }    
            
            html +=      '<br><div style="clear:both"></div>'
            html +=      '<div style="float:right;width:100px;margin-right:30px;margin-bottom:10px">'
            html +=      '<button style="" type="button" class="btn btn-default btn-sm" onclick="update_quiz(\'' + quiz_no+'\' ,\' '+ quiz_answer+ '\' , \' '+ quiz_type_code+'\')">';
            html +=         '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 수정';
            html +=      '</button>';
            html +=      '<button style="" type="button" class="btn btn-default btn-sm" onclick="delete_quiz_by_id(\''+quiz_no+'\')">';
            html +=         '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> 삭제';
            html +=      '</button>';
            html +=      '</div>'
            html +=      '<div style="clear:both;margin-top:10px"></div>'
            html +=   '</div></td>';
            html += '</tr>';
        }
        if(list.length == 0){
            
            html +=     '<div class="alert alert-warning" role="alert"  onclick="quiz_menu(\'register_quiz\')" style="margin:10px">등록된 퀴즈가 없습니다. 클릭하면 퀴즈 등록으로 이동합니다.</div>';
        
        }
        
        $("#user_registed_quiz_table_body").html(html);
    }
    function quiz_type_select(type) {
        $(".register_quiz_anser_select, .register_quiz_anser_short, .register_quiz_anser_ox").hide();
        $(".register_quiz_answer").show();
        
        if (type == 'ox') {
            $(".register_quiz_anser_ox").show();
        } else if (type == 'short') {
            $(".register_quiz_anser_short").show();
        } else if (type == 'select') {
            $(".register_quiz_anser_select").show();
        } else if (type == 'morethanhalf') {
            $(".register_quiz_answer").hide();
        }


    }
    function debug_user_session_live(data) {
        //console.log(data);
    }
    function quiz_menu(type) {
        $(".register_quiz, .current_quiz,.registed_quizs, .live_chat").hide();

        if (type == 'register_quiz') {
            $(".inlineRadio1").show();
            $(".inlineRadio2").show();
            $(".inlineRadio3").show();
            $(".register_quiz").show();
            reset_form();
            $(".inlineRadio1").click();
        }else if (type == 'registed_quizs') {
            requestAjax("Ajax_user_registered_quiz_list.php", user_registed_quiz_list, {});
            $(".registed_quizs").show();
        } else if (type == 'home') {
            $(".current_quiz").show();
        } else if (type == 'live_chat') {
            $(".live_chat").show();
        }
    }
    $("document").ready(function() {
        $(function() {
            setInterval(function() {
                requestAjax("Ajax_user_session_live.php", debug_user_session_live, {});
                requestAjax("Ajax_current_quiz_info.php", current_quiz_info, {});
                
            }, 1000)
        });
        $(".register_quiz_anser_select, .register_quiz_anser_short, .register_quiz, .registed_quizs,.live_chat ").hide();
        
    });
</script>