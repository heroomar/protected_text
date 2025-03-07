<?php
// check_url.php
include 'db.php';

$url = $_POST['url'];
$pass = $_POST['pass'];
$result = $conn->query("SELECT * FROM notes_url WHERE url = '$url'");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row['pass'] == ''){
        $pass = password_hash($pass,PASSWORD_DEFAULT);
        $conn->query("UPDATE notes_url SET pass='".$pass."' WHERE url = '$url'");
        echo json_encode(["response" => true]); exit();
    } else {
        if (password_verify($pass,$row['pass'])){
            $id = $_POST['id'];
            $result = $conn->query("SELECT * FROM notes WHERE id=".$id." AND user_id =".$row['id']);
            if ($result->num_rows > 0){
                echo json_encode(["response" => true,"text"=> $result->fetch_assoc()['text']]); exit();
            }
            echo json_encode(["response" => false]); exit();
        }else {
            echo json_encode(["response" => false]); exit();
        }
    }
} else {
    echo json_encode(["response" => false]); exit();
}
?>