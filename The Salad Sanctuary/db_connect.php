<?php
$servername = "localhost";
$username = "root";
$password = "Bbmwkkil7"; // change if needed
$dbname = "salad_sanctuary";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
