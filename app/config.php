<?php

$mysqli = new mysqli("localhost", "root", "", "php-rest-api-crud-test", "3306");
if ($mysqli->connect_errno) die("Connection failed: " . $mysqli->connect_errno . " = " . $mysqli->connect_error);

?>