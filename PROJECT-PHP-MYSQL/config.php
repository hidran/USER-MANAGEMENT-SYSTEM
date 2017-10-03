<?php
$config = [
    'mysql_host' => 'localhost',
    'mysql_user' => 'root',
    'mysql_password' => 'hidran',
    'mysql_db' => 'corsophp',
    'numPagesNavigator' => 5
];
const MAX_FILE_SIZE = 5000000;
const MAX_FILE_WIDTH = 200;
const MAX_FILE_HEIGHT = 200;
const AVATAR_DIR = 'avatar/';
$orderByColumns = ['id','username','email','fiscalcode','age'];
return $config;