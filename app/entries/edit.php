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
    $uid = $_POST["uid"];
    
    $query = "UPDATE entries SET ";
    $param_types = "";
    $param_values = array();
    
    if (isset($_POST["entry"])) {
        $query .= "ENTRY = ?, ";
        $param_types .= "s";
        $param_values[] = $_POST["entry"];
    }
    
    $query = rtrim($query, ", ");
    
    $query .= " WHERE ID = ? AND users_ID = ?";
    $param_types .= "ii";
    $param_values[] = $id;
    $param_values[] = $uid;
    
    $sql = $mysqli->prepare($query);
    $sql->bind_param($param_types, ...$param_values);
    
    if ($sql->execute()) {
        respond(200, false, "Entry updated successfully.");
    } else {
        respond(500, true, "Error updating entry: " . $mysqli->error);
    }
} else {
    respond(400, true, "Invalid request method.");
}
?>
