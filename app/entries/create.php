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
    $users_ID = $_POST["users_ID"];
    $entry = $_POST["entry"];
    
    // Validación de datos aquí (por ejemplo, asegurarse de que el usuario exista)
    
    $sql = $mysqli->prepare("INSERT INTO entries (users_ID, ENTRY, TIMESTAMP) VALUES (?, ?, NOW())");
    $sql->bind_param("is", $users_ID, $entry);
    
    if ($sql->execute()) {
        respond(200, false, "Entry created successfully.");
    } else {
        respond(500, true, "Error creating entry: " . $mysqli->error);
    }
} else {
    respond(400, true, "Invalid request method.");
}
