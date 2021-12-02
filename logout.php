<?php
//delete session variable and then redirect to signup page, first you have to start the sesion on the page
session_start();
session_unset();
session_destroy();// or unset($_SESSION['myVar']);// or session_unset()
// include 'includes/headerpage.php';

header("Location: ./login.php");
die(); //or die();
?>
