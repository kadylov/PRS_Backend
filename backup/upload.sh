#!/bin/bash

prs_file=`echo $PWD`'/prs_backup.sql'

host='ls-a1f8ce36f06eeb4f03f53664d8911745db5895f4.cn5ycdfnko6g.us-east-1.rds.amazonaws.com'
user='dbmasteruser'
password='-knCbr0%{?T.J6wZDe4p2|W>iheads>r'

/opt/bitnami/mysql/bin/mysql --host=$host --user=$user --password=$password --protocol=tcp --port=3306 --default-character-set=utf8 --comments --database=peer_review_db  < $prs_file
