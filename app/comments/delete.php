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
    $comment_ID = $_POST["comment_ID"];
    
    // Validación de datos aquí (por ejemplo, asegurarse de que el comentario exista)
    
    $sql = $mysqli->prepare("DELETE FROM comments WHERE ID = ?");
    $sql->bind_param("i", $comment_ID);
    
    if ($sql->execute()) {
        respond(200, false, "Comment deleted successfully.");
    } else {
        respond(500, true, "Error deleting comment: " . $mysqli->error);
    }
} else {
    respond(400, true, "Invalid request method.");
}
