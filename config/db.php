<?php

/*

Drop Database If Exists helpmsgtdd;
Create Database helpmsgtdd CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' ;

CREATE USER 'helpmsgtdduser'@'localhost' IDENTIFIED BY 'helpmsgtddpass';
GRANT ALL PRIVILEGES ON helpmsgtdd . * TO 'helpmsgtdduser'@'localhost'  WITH GRANT OPTION;

CREATE USER 'helpmsgtdduser'@'%' IDENTIFIED BY 'helpmsgtddpass';
GRANT ALL PRIVILEGES ON helpmsgtdd . * TO 'helpmsgtdduser'@'%'  WITH GRANT OPTION;

FLUSH PRIVILEGES;

*/
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
