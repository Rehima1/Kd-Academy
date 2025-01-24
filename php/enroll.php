<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['student_id'])) {
    header('Location: login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['student_id'];
    $course_id = $_POST['course_id']; 

    if (empty($course_id) || !is_numeric($course_id)) {
        die("Invalid course selection.");
    }

    $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id, status) VALUES (?, ?, 'Enrolled')");
    $stmt->bind_param("ii", $student_id, $course_id);

    if ($stmt->execute()) {
        echo "Enrollment successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

$student_id = $_SESSION['student_id']; // Assuming the student ID is stored in the session

// Fetch enrolled classes for the student
$stmt = $conn->prepare("SELECT e.student_id, c.course_name, e.enrollment_date, e.status FROM enrollments e JOIN courses c ON e.course_id = c.course_id WHERE e.student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$enrollments = [];
while ($row = $result->fetch_assoc()) {
    $enrollments[] = $row;
}

echo json_encode($enrollments);
$stmt->close();
$conn->close();
?>
