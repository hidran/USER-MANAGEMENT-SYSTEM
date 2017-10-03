<?php
 //error_reporting(0);
require_once 'config.php';

$mysqli = new mysqli($config['mysql_host'],$config['mysql_user'], $config['mysql_password'],
        $config['mysql_db']
        );

if($mysqli && $mysqli->connect_error){   
  die($mysqli->connect_error);
}