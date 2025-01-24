<?php
    session_start();
    include 'db_connection.php';
    
    if (!isset($_SESSION['student_id'])) {
        header("Location: login.html");
        exit();
    }
    
    $student_id = $_SESSION['student_id'];
    $stmt = $conn->prepare("SELECT full_name FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $student_name = htmlspecialchars($user['full_name']); 
    } else {
        $student_name = "Guest"; 
    }
    
    $stmt->close();
    $conn->close();
    ?>