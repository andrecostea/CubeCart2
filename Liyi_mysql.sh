#!/bin/bash

DATABASE="cubecart"
TABLE="cubecartCubeCart_chatmsg"

######################
#create table
mysql -uroot -pstudent cubecart << EOFMYSQL
CREATE TABLE $TABLE(
id int,
send varchar(50),
receive varchar(50),
rflag int,msg varchar(100),
flag int);
EOFMYSQL
[ $? -eq 0 ] && echo "Created table chatmsg" || echo "Table chatmsg already exist"

