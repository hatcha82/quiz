<?session_start(); ?>
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  
</head>

<body>
  <div class="container">
    <div class="page-header">
      <h1>티투엘(주)<br><small> Trade to logistics</small></h1>
    </div>
    <div class="panel panel-default panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">사용자 로그인</h3>
      </div>
      <div class="panel-body">
        <form class="form-signin" role="form" action="action/Action_login.php" method="post">
          <div class="form-group">
            <label for="inputEmail" >사용자 ID</label>
            <input type="text" id="userid" name="userid" class="form-control" placeholder="사용자 ID" required="" autofocus="" value="<?= (isset($_SESSION["userid"]) ? $_SESSION["userid"] :"" )?>">
          </div>  
          <div class="form-group>
            <label for="inputPassword" class="sr-only">비밀번호</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="비밀번호" required="" value="<?=@(isset($_SESSION["password"]) ? $_SESSION["password"] :"" )?>">
          </div>
          

          <div style="padding:10px;"></div>
          <button class="btn btn-lg btn-primary btn-block" type="submit">로그인</button>
          <input type="hidden" id="login_error_msg" value="<?=$_SESSION["login_error_msg"]?>"/>
        </form>
      </div>
    </div>
    
  </div>     
 

</body>

</html>

<script>
  function checkLoginErrorMSG(){
    var login_error_msg = $("#login_error_msg").val();
    if(login_error_msg.length > 0){
      $(".password-error").addClass('has-error');
      $("#login_error_alert_div").show();
    }else{
      $("#login_error_alert_div").hide();
    }
  }
  $("document").ready(function(){
    checkLoginErrorMSG();
  });
</script>