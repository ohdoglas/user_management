<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "user_management";

$conn = mysqli_connect(
    $db_server,
    $db_user,
    $db_pass,
    $db_name
);

if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}

echo "Database connected successfully" . "<br>";
