<?php


// $dbhost = "113.23.132.199"; //server ip address
// $dbuser = "dbmaster1";
// $dbpass = "db@2022";
// $dbname = "spas_db";
$dbhost = "localhost"; //server ip address
$dbuser = "root";
$dbpass = "";
$dbname = "imrgroup";

if(!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}