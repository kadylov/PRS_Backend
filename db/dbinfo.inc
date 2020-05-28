<?php




/*Connect to MySQL and select the database.*/
function connect() {

    $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    /* check connection */
    if (mysqli_connect_errno()) {
        die("Failed to connect to the database: ".$connection->connect_error);

    }
    return $connection;
}
?>
