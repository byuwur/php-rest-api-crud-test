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
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = $mysqli->prepare("INSERT INTO users (USERNAME, PASSWORD) VALUES (?, ?)");
    $sql->bind_param("ss", $username, $password);

    if ($sql->execute()) {
        respond(200, false, "User created successfully.");
    } else {
        respond(500, true, "Error creating user: " . $mysqli->error);
    }
} else {
    respond(400, true, "Invalid request method.");
}
