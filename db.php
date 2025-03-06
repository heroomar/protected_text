<?php
// db.php
$servername = "localhost";
$username = "tgnu12345678_ci";
$password = "tgnu12345678_ci";
$dbname = "tgnu12345678_ci";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>