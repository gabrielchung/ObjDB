<?php $currUrlEncoded = urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>

<a href="https://www.facebook.com/dialog/oauth?client_id=391038000979036&redirect_uri=http://<?php echo $_SERVER['HTTP_HOST']; ?>/core/FBLogin/Login.php%3Fredirect%3D<?php echo $currUrlEncoded ?>&response_type=token&scope=email">Facebook</a>