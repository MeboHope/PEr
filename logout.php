<?php
    session_start();
    include 'database.php';
    unset($_SESSION["id"]);
    unset($_SESSION["name"]);
    header("Location:login.php");
?>