<?php
// ============================================================
// Database Connection for Amazon College System
// Database Server: 10.10.10.1
// Database Name: amazon_db
// Credentials: username = amazon_college, password = amazon_123
// ============================================================

$servername = "10.10.10.1";   // Database server IP Address
$username   = "amazon_college"; // Database username
$password   = "amazon_123";    // Database password
$dbname     = "amazon_db";     // Database name

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
