<?php

require_once 'Utils/util.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');


ini_set('display_errors', 1);
error_reporting(E_ALL);


$file = 'backup/prs_backup.sql';

//$filename='prs_backup';
//$mysqldump = '/opt/bitnami/mysql/bin/mysqldump';
//$dir = dirname(__FILE__).'/backup/'.$filename.'.sql';
//$configFile = dirname(__FILE__).'/backup/.dbCredential.cnf';
//
//$command = ' --defaults-extra-file='.$configFile.' --insert-ignore=TRUE --tz-utc=FALSE --protocol=tcp --set-gtid-purged=OFF --default-character-set=utf8 --dump-date=FALSE --port=3306 --routines --no-create-info=TRUE --skip-triggers "peer_review_db" --result-file='.$dir.' 2>&1';
//$res = exec($mysqldump.' '.$command);
//echo $mysqldump.' '.$command;



// wait until the backup data is generated
if (generateBackupFile('prs_backup')) {

    if (file_exists($file)) {


        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($file));

        readfile($file);
        exit;
    }
    else{
        sendHttpResponseMsg(400, 'The file not found on the server!');
    }
}
else{
    sendHttpResponseMsg(400, 'Unable to generate the file!');

}


function generateBackupFile($filename) {
    $statusFlag = false;
    if (!empty($filename)) {
//        $dir = dirname(__FILE__).'/backup/'.$filename.'.sql';
//        $configFile = dirname(__FILE__).'/backup/.dbCredential.cnf';

        $dir1 = dirname(__FILE__).'/backup/';

//        $mysqldump='/opt/bitnami/mysql/bin/mysqldump';
//        $command = $mysqldump.' --defaults-extra-file='.$configFile.' --insert-ignore=TRUE --tz-utc=FALSE --protocol=tcp --set-gtid-purged=OFF --default-character-set=utf8 --dump-date=FALSE --port=3306 --routines --no-create-info=TRUE --skip-triggers "peer_review_db" --result-file='.$dir;

        $old_path = getcwd();
        chdir(dirname($dir1));
        $output = shell_exec('./download.sh');
        chdir($old_path);

        $statusFlag = true;
    }

    return $statusFlag;
}

?>
