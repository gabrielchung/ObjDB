<?php

	$GLOBALS['db_dbname'] = 'jspg2';
	$GLOBALS['db_login'] = '';
	$GLOBALS['db_password'] = '';
	$GLOBALS['db_address'] = 'localhost';

	function connect_db($db_dbname = null) {
            
            if ($db_dbname == null) { $db_dbname = $GLOBALS['db_dbname']; }
            
            $dbh = new PDO('mysql:host='.$GLOBALS['db_address'].';dbname='.$db_dbname, $GLOBALS['db_login'], $GLOBALS['db_password']);

            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $dbh;
	}
?>