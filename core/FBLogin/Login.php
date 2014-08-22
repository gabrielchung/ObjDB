<script>
if (document.location.href.indexOf('#') > -1)
	document.location.href=document.location.href.replace('#','&');
</script>
<?php
	function get_http_body($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.6 (KHTML, like Gecko) Chrome/16.0.897.0 Safari/535.6');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        //$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //$header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);
        //return new curl_response($http_code, $header, $body);
        //return $http_code;
        return $body;
    }
    
    // echo $_SERVER['REQUEST_URI'] . '<br />';
    // echo $_REQUEST['access_token'] . '<br />';
    // echo $_GET['access_token'] . '<br />';

    $body = get_http_body('https://graph.facebook.com/me?access_token='.$_GET['access_token']);
    // echo $body;

    $resObj = json_decode($body);

    // print_r($resObj);

    session_start();

    // $_SESSION['login'] = 'true';

    // echo $resObj->{'first_name'} . '<br />';

    // echo $resObj->{'last_name'} . '<br />';

    // echo $resObj->{'email'} . '<br />';

    // echo $_GET['redirect'];

    require dirname(__FILE__) . '/../user.php';
    
    //if (isset($_REQUEST['email']) && isset($_REQUEST['firstName']) && isset($_REQUEST['lastName'])) {
        $u = new User(false);
        $u->email = $resObj->{'email'};
        $u->firstName = $resObj->{'first_name'};
        $u->lastName = $resObj->{'last_name'};
        
        $u->login();

        session_start();
        $_SESSION['UserID'] = $u->userID;
        $_SESSION['UserName'] = $u->firstName . " " . $u->lastName;

        //echo 0;
    //}

    // echo $_SESSION['UserID'] . '<br />';
    // echo $_SESSION['UserName'] . '<br />';
?>
<script>
    document.location.href='<?php echo $_GET['redirect']; ?>';
</script>