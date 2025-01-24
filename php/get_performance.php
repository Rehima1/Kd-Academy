<?php
session_start();
include 'db_connection.php';

$student_id = $_SESSION['student_id']; // Assuming the student's ID is stored in the session

$stmt = $conn->prepare("SELECT p.performance_id, c.course_name, p.semester, p.grade, p.comments, p.performance_date 
                        FROM performance p 
                        JOIN courses c ON p.course_id = c.course_id 
                        WHERE p.student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$performance = [];
while ($row = $result->fetch_assoc()) {
    $performance[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($performance);
?>