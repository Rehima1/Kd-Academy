<?php
// Database connection
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $year = $_POST['year'];

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_tmp = $_FILES['profile_pic']['tmp_name'];
        $file_name = basename($_FILES['profile_pic']['name']);
        
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = $student_id . '.' . $file_ext;
        $upload_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $stmt = $conn->prepare("UPDATE students SET profile_pic = ?, full_name = ?, email = ?, year = ? WHERE student_id = ?");
            $stmt->bind_param("sssss", $new_file_name, $full_name, $email, $year, $student_id);
            $stmt->execute();
            $stmt->close();
            echo "Profile updated successfully.";
        } else {
            echo "Failed to upload profile picture.";
        }
    } else {
        $stmt = $conn->prepare("UPDATE students SET full_name = ?, email = ?, year = ? WHERE student_id = ?");
        $stmt->bind_param("ssss", $full_name, $email, $year, $student_id);
        $stmt->execute();
        $stmt->close();
        echo "Profile updated successfully.";
    }
}

$conn->close();
?>