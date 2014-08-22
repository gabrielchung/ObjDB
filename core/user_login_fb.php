<?php
    require 'user.php';
    
    if (isset($_REQUEST['email']) && isset($_REQUEST['firstName']) && isset($_REQUEST['lastName'])) {
        $u = new User(false);
        $u->email = $_REQUEST['email'];
        $u->firstName = $_REQUEST['firstName'];
        $u->lastName = $_REQUEST['lastName'];
        
        $u->login();

        session_start();
        $_SESSION['UserID'] = $u->userID;
        $_SESSION['UserName'] = $u->firstName . " " . $u->lastName;

        echo 0;
    }
?>