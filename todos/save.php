<?php
include('../config.php');
header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $data = json_decode(file_get_contents("php://input"), true);

    $title = trim($data['title'] ?? '');
    $description = trim($data['description'] ?? '');
    $status = trim($data['status'] ?? '');
    $id = (int) ($data['id'] ?? 0);
    $now = date('Y-m-d H:i:s');
   
    if (empty($title) || empty($status)) {
        echo json_encode(["status" => "error", "message" => "Title and status are required."]);
        exit;
    }

    if (!empty($id)) {
    //   var_dump($data); die();
        $stmt = $conn->prepare("UPDATE todos SET title = ?, description = ?, status = ?, updated_at = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $title, $description, $status, $now, $id);
        $querySuccess = $stmt->execute();
        $selectedId = $id;
        $stmt->close();
    } else {
        
        $stmt = $conn->prepare("INSERT INTO todos (title, description, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $status, $now, $now);
        $querySuccess = $stmt->execute();
        $selectedId = $stmt->insert_id;
        $stmt->close();
        
        
    }
    // echo json_encode($data);die();

    if ($querySuccess) {
        $stmt = $conn->prepare("SELECT * FROM todos WHERE id = ?");
        $stmt->bind_param("i", $selectedId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo json_encode(["status" => "success", "todo" => $row]);
        } else {
            echo json_encode(["status" => "error", "message" => "Operation successful but failed to retrieve todo."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Database error.", "error" => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
