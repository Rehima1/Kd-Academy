<?php
session_start();
include 'db_connection.php';

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password !== $confirm_password) {
    die('Error: New passwords do not match!');
}

$user_id = 1;

$sql = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($db_password);
$stmt->fetch();

if (!password_verify($current_password, $db_password)) {
    die('Error: Current password is incorrect!');
}

$new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
$sql = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $new_password_hashed, $user_id);
if ($stmt->execute()) {
    echo 'Password updated successfully!';
} else {
    echo 'Error updating password!';
}
?>
<?php
session_start();
include 'db_connection.php';

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password !== $confirm_password) {
    die('Error: New passwords do not match!');
}

$user_id = 1; 

$sql = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($db_password);
$stmt->fetch();

if (!password_verify($current_password, $db_password)) {
    die('Error: Current password is incorrect!');
}

$new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
$sql = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $new_password_hashed, $user_id);
if ($stmt->execute()) {
    echo 'Password updated successfully!';
} else {
    echo 'Error updating password!';
}
?>
