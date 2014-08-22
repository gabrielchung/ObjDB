<?php
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require 'openid.php';
try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID('http://www.beewii.com');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'https://www.google.com/accounts/o8/id';
//custom
	    $openid->required = array('contact/email', 'namePerson/first', 'namePerson/last');
//custom END
            header('Location: ' . $openid->authUrl());
        }
?>
<form action="?login" method="post">
    <button>Login with Google</button>
</form>
<?php
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
	$attributes = $openid->getAttributes();
        print_r($attributes['contact/email']);
        //print_r($openid->data);
        //echo 'Email: ' . $openid['contact/email']
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
?>
