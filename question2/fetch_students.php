<?php
// ============================================================
// Server-Side Script: fetch_students.php
// Hosted at the source code server (IP: 10.10.10.2)
// This script connects to the database, retrieves student
// information, and returns it as JSON for the AJAX request.
// ============================================================

// Include database connection
require_once __DIR__ . '/config/database.php';

// Set the content type to JSON for AJAX response
header('Content-Type: application/json');

// SQL query to select all students from the student table
$sql = "SELECT first_name, last_name, program, gender, registration_number 
        FROM student 
        ORDER BY registration_number ASC";

$result = $conn->query($sql);

// Build the response array
$students = array();

if ($result->num_rows > 0) {
    // Fetch each row and add to the students array
    while ($row = $result->fetch_assoc()) {
        $students[] = array(
            'first_name'          => $row['first_name'],
            'last_name'           => $row['last_name'],
            'program'             => $row['program'],
            'gender'              => $row['gender'],
            'registration_number' => $row['registration_number']
        );
    }
}

// Close the database connection
$conn->close();

// Return the data as a JSON encoded string
// This is what the AJAX request will receive
echo json_encode($students);
?>
