<?php
    require 'user.php';
    
    $u = new User();
    $header = $u->authorize();
    if ($header!=null) { header($header); }

    if ($u->email != null) {
        $u->login();
        
        session_start();
        $_SESSION['UserID'] = $u->userID;
        $_SESSION['UserName'] = $u->firstName . " " . $u->lastName;
        
        header('location: ' . $_REQUEST['returnUrl']);
    }
?>