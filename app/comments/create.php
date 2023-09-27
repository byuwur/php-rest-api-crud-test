<?php
require_once "../config.php";

function respond($status, $error, $message, $data = null)
{
    $response = new stdClass();
    $response->status = $status;
    $response->error = $error;
    $response->message = $message;
    $response->data = $data;
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $users_ID = $_POST["uid"];
    $entries_ID = $_POST["eid"];
    $comment = $_POST["comment"];
    
    // Validación de datos aquí (por ejemplo, asegurarse de que los IDs existan)
    
    $sql = $mysqli->prepare("INSERT INTO comments (users_ID, entries_ID, COMMENT, TIMESTAMP) VALUES (?, ?, ?, NOW())");
    $sql->bind_param("iis", $users_ID, $entries_ID, $comment);
    
    if ($sql->execute()) {
        respond(200, false, "Comment created successfully.");
    } else {
        respond(500, true, "Error creating comment: " . $mysqli->error);
    }
} else {
    respond(400, true, "Invalid request method.");
}
