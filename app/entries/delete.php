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
    $id = $_POST["id"];
    
    // Validación de datos aquí (por ejemplo, asegurarse de que la entrada exista)
    
    $sql = $mysqli->prepare("DELETE FROM entries WHERE ID = ?");
    $sql->bind_param("i", $id);
    
    if ($sql->execute()) {
        respond(200, false, "Entry deleted successfully.");
    } else {
        respond(500, true, "Error deleting entry: " . $mysqli->error);
    }
} else {
    respond(400, true, "Invalid request method.");
}
