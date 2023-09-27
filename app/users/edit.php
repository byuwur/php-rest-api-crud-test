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

    // Validación de datos aquí (por ejemplo, asegurarse de que el usuario exista)

    // Construir la consulta SQL dinámicamente
    $query = "UPDATE users SET ";
    $param_types = "";
    $param_values = array();

    if (isset($_POST["username"])) {
        $query .= "username = ?, ";
        $param_types .= "s";
        $param_values[] = $_POST["username"];
    }

    if (isset($_POST["password"])) {
        $query .= "password = ?, ";
        $param_types .= "s";
        $param_values[] = $_POST["password"];
    }

    // Eliminar la coma adicional y espacio al final de la consulta
    $query = rtrim($query, ", ");

    $query .= " WHERE ID = ?";
    $param_types .= "i";
    $param_values[] = $id;

    $sql = $mysqli->prepare($query);
    $sql->bind_param($param_types, ...$param_values);
    if ($sql->execute()) {
        respond(200, false, "User updated successfully.");
    } else {
        respond(500, true, "Error updating user: " . $mysqli->error);
    }
} else {
    respond(400, true, "Invalid request method.");
}
