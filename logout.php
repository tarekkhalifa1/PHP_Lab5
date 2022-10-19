<?php 
require_once('auth/auth.php'); // auth users only can access this page
    session_unset();
    session_destroy();
    header("Location:index.php");
?>