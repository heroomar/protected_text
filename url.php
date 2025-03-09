<?php
// url.php
include 'db.php';

$url = $_POST['url'];
$url = str_replace(' ','',$url);
$result = $conn->query("SELECT * FROM notes_url WHERE url = '$url'");
if ($result->num_rows == 0) {
    $conn->query("INSERT INTO notes_url (url) VALUES ('$url')");
}
?>
<script>
    window.location.href = '/<?= $url ?>';
</script>