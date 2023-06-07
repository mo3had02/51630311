<?php
$dsn = 'mysql:host=localhost; dbname=megaplusdb2';
$user ='root';
$pass = '';
$option = array (
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

);
try {
    $con = new PDO ($dsn, $user, $pass, $option);
    $con ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $th) {
    echo 'failed to connect'. $th->getMessage();
}