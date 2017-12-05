<?php
$config = [
    'mysql_host' => 'localhost',
    'mysql_user' => 'root',
    'mysql_password' => '',
    'mysql_db' => 'corsophp',
    'numPagesNavigator' => 5
];

const MAX_FILE_SIZE = 5000000;
const THUMB_MAX_FILE_HEIGHT = 200;
const THUMB_MAX_FILE_WIDTH = 200;
const BIG_MAX_FILE_WIDTH = 600;
const BIG_MAX_FILE_HEIGHT = 600;
const AVATAR_DIR = 'avatar/';
$orderByColumns = ['id','username','email','fiscalcode','age'];
return $config;