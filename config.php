<?php
$servername = "localhost";  // or your server name
$username = "root";         // replace with your DB username
$password = "";             // replace with your DB password
$dbname = "sunsetvilla";   // your target database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
