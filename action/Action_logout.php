<?php

    include_once("../include/common_function.php");
    
    session_start();
    session_destroy();
    header( "Location:../login.php" );
?>