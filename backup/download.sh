#!/bin/bash

dir=`echo $PWD`'/backup/prs_backup.sql'

host='ls-a1f8ce36f06eeb4f03f53664d8911745db5895f4.cn5ycdfnko6g.us-east-1.rds.amazonaws.com'
user='dbmasteruser'
password='-knCbr0%{?T.J6wZDe4p2|W>iheads>r'


/opt/bitnami/mysql/bin/mysqldump --tz-utc=FALSE --protocol=tcp --set-gtid-purged=OFF --default-character-set=utf8 --host=$host --insert-ignore=TRUE --user=$user --password=$password --dump-date=FALSE --port=3306 --routines --no-create-info=TRUE --skip-triggers "peer_review_db" --result-file=$dir
