#!/bin/bash

dir=`echo $PWD`'/backup/prs_backup.sql'
configFile=`echo $PWD`'/backup/.dbUpload.cnf'

echo $dir



mysql --defaults-extra-file=$configFile --protocol=tcp  --port=3306 --default-character-set=utf8 --comments --database=peer_review_db  < $dir
