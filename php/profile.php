<?php
session_start();
include 'db_connection.php';

$student_id = $_SESSION['student_id']; 

$stmt = $conn->prepare("SELECT student_id, student_name, email, profile_image FROM students WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['student_name'];
    $email = $_POST['email'];

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_name = basename($_FILES['profile_image']['name']);
        
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = $student_id . '.' . $file_ext;
        $upload_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $stmt = $conn->prepare("UPDATE students SET profile_image = ?, student_name = ?, email = ? WHERE student_id = ?");
            $stmt->bind_param("sssi", $new_file_name, $full_name, $email, $student_id);
            $stmt->execute();
            $stmt->close();
            echo "Profile updated successfully.";
        } else {
            echo "Failed to upload profile picture.";
        }
    } else {
        $stmt = $conn->prepare("UPDATE students SET student_name = ?, email = ? WHERE student_id = ?");
        $stmt->bind_param("ssi", $full_name, $email, $student_id);
        $stmt->execute();
        $stmt->close();
        echo "Profile updated successfully.";
    }
    $conn->close();
}
?>