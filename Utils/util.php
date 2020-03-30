<?php

function validateDate($date, $format = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


function responseWithError(string $errMsg, int $errCode = 400) {
    http_response_code($errCode);
    echo json_encode(array("message" => "$errMsg"));
    exit(0);
}


function validatesAsInt($number) {
//    $number = filter_var($number, FILTER_VALIDATE_INT);
    return ctype_digit($number) || $number < 0;
}


function sendHttpResponseMsg(int $code = 200, string $message = '') {
    switch ($code) {
        case 200:
            header('HTTP/1.1 200 OK');
            echo json_encode($message);
            break;

        case 404:
            header('HTTP/1.1 404 Not Found');
            echo json_encode($message);
            break;
    }

}

?>
