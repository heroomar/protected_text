<?php
// check_url.php
include 'db.php';

$url = $_POST['url'];
$pass = $_POST['pass'];
$result = $conn->query("SELECT * FROM notes_url WHERE url = '$url'");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
        if (password_verify($pass,$row['pass'])){
            $notes=[];
            $title = $_POST['title'];
            $text = $_POST['text'];
            $id = $_POST['id'];

            $result = $conn->query("UPDATE notes SET `title`='".$title."', `text`='".$text."' WHERE id=".$id." AND user_id =".$row['id']);
            
            echo json_encode(["response" => true]); exit();
        } else {
            echo json_encode(["response" => false]); exit();
        }
} else {
    echo json_encode(["response" => false]); exit();
}
?>