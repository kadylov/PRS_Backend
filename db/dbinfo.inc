<?php

define ('DB_SERVER', 'ls-a1f8ce36f06eeb4f03f53664d8911745db5895f4.cn5ycdfnko6g.us-east-1.rds.amazonaws.com');
define('DB_USERNAME', 'dbmasteruser');
define('DB_PASSWORD', '-knCbr0%{?T.J6wZDe4p2|W>iheads>r');
define('DB_DATABASE', 'peer_review_db');


/*Connect to MySQL and select the database.*/
function connect() {
	
	 $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

	if ($connection->connect_error) {
            die("Failed to connect to the database: " . $connection->connect_error);
        }
        return $connection;

    }

#connect();

?>
