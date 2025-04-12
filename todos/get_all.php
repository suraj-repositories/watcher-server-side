<?php
include('../config.php');
header('Content-type: application/json');

if($_SERVER['REQUEST_METHOD'] != 'GET'){
    echo json_encode(array("status" => "error", "message" => "Invalid request."));
    exit;
}

$sql = "SELECT * FROM todos";
$result = mysqli_query($conn, $sql);
$todos = array();
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $todos[] = $row;
    }
    echo json_encode(array("status" => "success", "todos" => $todos));
} else {
    echo json_encode(array("status" => "error", "message" => "No todos found."));
}
mysqli_close($conn);