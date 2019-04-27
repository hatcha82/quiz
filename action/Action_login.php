<?php
    echo "test";
    include_once("../include/common_function.php");
    session_start();

    $userid = $_POST["userid"];
    $password = $_POST["password"];
    

    $sql = "SELECT * FROM user WHERE user.userid = '$userid' and user.pw = '$password'";        
    echo $sql;
    $list = getList($sql);
      

    $userInDBatabase = count($list);

    if($userInDBatabase != 0){
      $_SESSION["login_error_msg"] = "";
      $_SESSION["userid"] = $list[0]->userid;
      $_SESSION["password"] = $list[0]->pw;
      $_SESSION["username"]= $list[0]->name;
      header( "Location:../user_control.php" );
    }else{
      $_SESSION["login_error_msg"] = "로그인 할수 없습니다. 비밀번호 또는 아이디를 확인해주세요.";
      $_SESSION["userid"] = $userid;
      $_SESSION["password"] = $password;
      $_SESSION["username"] = "";
      header( "Location:../login.php" );
    }
    exit; 
?>