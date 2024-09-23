<?php

$sname= "localhost";
$uname= "root";
$password = "";
$database = "condo";

$conn = mysqli_connect($sname, $uname, $password, $database);

if (!$conn) {
	echo "Connection failed!";
}


