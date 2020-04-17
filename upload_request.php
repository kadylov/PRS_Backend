<?php



//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//
//header('Content-Description: File Transfer');
//header('Content-Type: application/octet-stream');
//header('Expires: 0');
//header('Cache-Control: must-revalidate');
//header('Pragma: public');

require_once "header_config.php";
require_once 'Utils/util.php';
require_once 'db/dbinfo.inc';


// report all occured error messages to the screen
ini_set('display_errors', 1);
error_reporting(E_ALL);



$file = 'prs_backup';

//restoreDataInDB('prs_backup');



// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if file was uploaded without errors
    if (isset($_FILES[$file]) && $_FILES[$file]["error"] == 0) {

        $filename = 'prs_backup.sql';
        $filetype = $_FILES[$file]["type"];
        $location_to_save = 'backup/';

//        echo 'File name: '.$filename."\n";
//        echo 'File type: '.$filetype."\n";
//        echo 'Location to save: '.$location_to_save.$filename."\n";
        if ($filetype !== 'application/sql') sendHttpResponseMsg(404, "Error: Please select a valid file format.");

        // copy from file fro mtemp folder to the project's backup folder
        if (!copy($_FILES[$file]["tmp_name"], $location_to_save.$filename)) {
            sendHttpResponseMsg(404, "failed to copy $file");
        }

        restoreDataInDB('prs_backup');
        sendHttpResponseMsg(200, "The backup file has been saved successfully");

    } else {
        sendHttpResponseMsg(404, "Error! Server expects to receive file with name ".$file);
    }

}

function restoreDataInDB($backup_fname) {

    $dir = dirname(__FILE__).'/backup/'.$backup_fname.'.sql';
    $configFile = dirname(__FILE__).'/backup/.dbUpload.cnf';

    $d = dirname(__FILE__).'/backup/upload.sh';

    $mysql='/opt/bitnami/mysql/bin/mysql';

    $command='--defaults-extra-file='.$configFile.' --protocol=tcp  --port=3306 --default-character-set=utf8 --comments --database=peer_review_db  < '. $dir;
    echo exec($mysql.' '.$command.' 2>&1');

}

?>
