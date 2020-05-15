<?php



require_once "header_config.php";
require_once 'Utils/util.php';
require_once 'db/dbinfo.inc';


// report all occured error messages to the screen
ini_set('display_errors', 1);
error_reporting(E_ALL);



$file = 'prs_backup';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if file was uploaded without errors
    if (isset($_FILES[$file]) && $_FILES[$file]["error"] == 0) {

        $filename = 'prs_backup.sql';
        $filetype = $_FILES[$file]["type"];
        $location_to_save = 'backup/';

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

//    $dir = dirname(__FILE__).'/backup/'.$backup_fname.'.sql';
//    $configFile = dirname(__FILE__).'/backup/.dbUpload.cnf';

//    $mysql='/opt/bitnami/mysql/bin/mysql';

    $old_path = getcwd();
    chdir(dirname(__FILE__).'/backup/');
    $output = shell_exec('./upload.sh > > /dev/null 2>&1');
    chdir($old_path);

}


?>
