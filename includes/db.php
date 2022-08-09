<?php

$hostname = 'localhost';
$username = 'id19393529_root';
$password = 'RC+F#v0Qj6njnFR7';
$database = 'id19393529_blog';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
