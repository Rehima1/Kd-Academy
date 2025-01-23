<?php
// Start session and include database connection
session_start();
include 'db_connection.php';

// Fetch the student's name from the session or database
$student_id = $_SESSION['student_id']; // Assuming the student's ID is stored in the session
$stmt = $conn->prepare("SELECT full_name FROM students WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$student_name = $user['full_name'];
$stmt->close();
$conn->close();
?>