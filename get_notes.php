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
            $notes=[];
            $result = $conn->query("SELECT * FROM notes WHERE user_id =".$row['id']);
            if ($result->num_rows == 0){
                $conn->query("INSERT INTO notes (title,text,user_id) VALUES ('Empty Tab','',".$row['id'].")");
                $result = $conn->query("SELECT * FROM notes WHERE user_id =".$row['id']);
            }
            while($row = $result->fetch_assoc()){
                $notes[] = ['id'=>$row['id'], 'title'=> $row['title'] , 'text'=> $row['text']];
            }
            echo json_encode(["response" => true,"notes"=> $notes]); exit();
        }else {
            echo json_encode(["response" => false]); exit();
        }
    }
} else {
    echo json_encode(["response" => false]); exit();
}
?>