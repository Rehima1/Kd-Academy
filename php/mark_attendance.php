<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_SESSION['student_id'])) {
        echo "Session expired. Please log in again.";
        exit();
    }

    $student_id = $_SESSION['student_id']; 
    $attendance_code = $_POST['attendanceCode'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("SELECT course_id FROM courses WHERE attendance_code = ?");
    $stmt->bind_param("s", $attendance_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();

    if ($course) {
        $course_id = $course['course_id'];
        $attendance_date = date('Y-m-d');

        $stmt = $conn->prepare("INSERT INTO attendance (student_id, course_id, attendance_date, attendance_code, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $student_id, $course_id, $attendance_date, $attendance_code, $status);

        if ($stmt->execute()) {
            echo "Attendance marked successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid attendance code. Please check with your teacher.";
    }

    $conn->close();
}
?>
