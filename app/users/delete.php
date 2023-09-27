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
    $user_ID = $_POST["user_ID"];
    
    // Validación de datos aquí (por ejemplo, asegurarse de que el usuario exista)
    
    $sql = $mysqli->prepare("DELETE FROM users WHERE ID = ?");
    $sql->bind_param("i", $user_ID);
    
    if ($sql->execute()) {
        respond(200, false, "User deleted successfully.");
    } else {
        respond(500, true, "Error deleting user: " . $mysqli->error);
    }
} else {
    respond(400, true, "Invalid request method.");
}
