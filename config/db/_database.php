<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "liga";

// Create connection

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
// null in boolean is false; string with value is true
// when connection is successful, connect_error will be null

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

?>
 