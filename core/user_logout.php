<?php
    session_start();
    unset($_SESSION['UserID']);
    unset($_SESSION['UserName']);
    
    header('location: ' . $_REQUEST['returnUrl']);
?>