<?php

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}


function responseWithError(string $errMsg, int $errCode = 400) {
        http_response_code($errCode);
        echo json_encode(array("message" => "$errMsg"));
        exit(0);
    }


function validatesAsInt($number)
{
//    $number = filter_var($number, FILTER_VALIDATE_INT);
    return ctype_digit($number) || $number < 0;
}
?>
