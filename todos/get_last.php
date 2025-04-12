<?php
include('../config.php');
header('Content-type: application/json');

if($_SERVER['REQUEST_METHOD'] != 'GET'){
    echo json_encode(array("status" => "error", "message" => "Invalid request."));
    exit;
}

$id = intval($_GET['id']); 

$sql = "SELECT * FROM todos ORDER BY id DESC LIMIT 1 ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $todo = mysqli_fetch_assoc($result);
    echo json_encode(array("status" => "success", "todo" => $todo));
} else {
    echo json_encode(array("status" => "error", "message" => "No todos found."));
}
mysqli_close($conn);