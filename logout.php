<?php
    session_start();
    $_SESSION=array();
    session_destroy();

    header("Location:/r40208/login.php");
?>