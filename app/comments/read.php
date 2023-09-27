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

$conditions = array();
$param_types = "";
$param_values = array();
$query = "SELECT * FROM comments ";
if (isset($_GET["id"])) {
    $conditions[] = "ID = ?";
    $param_types .= "i";
    $param_values[] = $_GET["id"];
}
if (isset($_GET["uid"])) {
    $conditions[] = "users_ID = ?";
    $param_types .= "i";
    $param_values[] = $_GET["uid"];
}
if (isset($_GET["eid"])) {
    $conditions[] = "entries_ID = ?";
    $param_types .= "i";
    $param_values[] = $_GET["eid"];
}
if (!empty($conditions)) $query .= "WHERE " . implode(" AND ", $conditions);
$query .= " GROUP BY ID;";
//var_dump($query);

$sql = $mysqli->prepare($query);
if (!empty($conditions)) $sql->bind_param($param_types, ...$param_values);
if ($sql->execute()) $res = $sql->get_result();
else respond(500, true, "Query failed: " . $mysqli->connect_errno . " = " . $mysqli->connect_error . " = " . $mysqli->error);

if (!$res->num_rows) respond(404, true, "No comments exist yet.");

while ($row = $res->fetch_assoc()) $data[] = $row;

respond(200, false, "The query was executed successfully.", $data);
