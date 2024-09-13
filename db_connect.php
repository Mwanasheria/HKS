<?php
$servername = "localhost";
$username = "HKS";
$password = "WELCOME";
$dbname = "HKS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>