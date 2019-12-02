<?php

require_once 'dbinfo.inc';

class DB {

    public static function select($query = "") {
        $conn = connect();

        $result = $conn->query($query);
        if (!$result)
            die("\nErrormessage:".$conn->error);

        elseif ($result->num_rows > 0) {
            $result = $result->fetch_all(MYSQLI_ASSOC);
        }
        $conn->close();
        return $result;

    }
}

?>
