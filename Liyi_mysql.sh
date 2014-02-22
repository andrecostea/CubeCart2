#!/bin/bash

DATABASE="message"
TABLE="chatmsg"

######################
#crate database
mysql -uroot -pstudent << EOFMYSQL
CREATE DATABASE $DATABASE;
EOFMYSQL
[ $? -eq 0 ] && echo "created DB" || echo DB already exists

######################
#create table
mysql -uroot -pstudent message << EOFMYSQL
CREATE TABLE $TABLE(
id int,
send varchar(50),
receive varchar(50),
rflag int,msg varchar(100),
flag int);
EOFMYSQL
[ $? -eq 0 ] && echo "Created table chatmsg" || echo "Table chatmsg already exist"
