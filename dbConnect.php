<?php

$serverName = "localhost";
$userName = "root";
$password = "root";
$databaseName = "ezshopdb";
$link = mysqli_connect($serverName, $userName, $password) or die(mysqli_connect_error());
$result = mysqli_query($link, "set names utf8");
mysqli_select_db($link, $databaseName);

?>