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
    
    // Construir la consulta SQL dinámicamente
    $query = "UPDATE comments SET ";
    $param_types = "";
    $param_values = array();
    
    if (isset($_POST["comment"])) {
        $query .= "COMMENT = ?, ";
        $param_types .= "s";
        $param_values[] = $_POST["comment"];
    }
    
    // Eliminar la coma adicional y espacio al final de la consulta
    $query = rtrim($query, ", ");
    
    $query .= " WHERE ID = ?";
    $param_types .= "i";
    $param_values[] = $comment_ID;
    
    $sql = $mysqli->prepare($query);
    $sql->bind_param($param_types, ...$param_values);
    
    if ($sql->execute()) {
        respond(200, false, "Comment updated successfully.");
    } else {
        respond(500, true, "Error updating comment: " . $mysqli->error);
    }
} else {
    respond(400, true, "Invalid request method.");
}
