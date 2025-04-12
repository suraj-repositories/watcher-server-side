<?php
date_default_timezone_set('Asia/Kolkata');

$server = 'localhost';
$user = 'root';
$password = '';
$database = 'watcher';

$conn = mysqli_connect($server, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
