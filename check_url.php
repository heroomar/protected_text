<?php
// check_url.php
include 'db.php';

$url = $_POST['url'];
$result = $conn->query("SELECT * FROM notes_url WHERE url = '$url'");
if ($result->num_rows > 0) {
    echo json_encode(["exists" => true]);
} else {
    echo json_encode(["exists" => false]);
}
?>