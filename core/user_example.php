<?php
    session_start();
    
    if (isset($_GET['SignOut'])) {
        unset($_SESSION['UserID']);
    }
    
    if (!isset($_SESSION['UserID']))
    {
?>        
<a href="user_login.php?returnUrl=user_example.php">Login with Google</a>
<?php
    }
    else {
        echo 'Hello, ' . $_SESSION['UserName'] . '.';
?>
<br />
<a href="?SignOut">Sign Out</a>
<?php
    }
?>