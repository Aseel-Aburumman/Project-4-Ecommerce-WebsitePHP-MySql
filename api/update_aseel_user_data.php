<?php
header('Content-Type: application/json');
require '../connection.php';

session_start();
// user_id in session عفوري 
$user_id = $_SESSION['user_id'];
// test purpose pls fix aseel
// $user_id = 3;


$username = $_POST['username'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

$sql = "SELECT password FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

if ($current_password == $user_data['password']) {
    $sql = "UPDATE users SET username = ?, Full_name = ?, email = ?, password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $username, $full_name, $email, $new_password, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => 'User data updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update user data']);
    }
} else {
    echo json_encode(['error' => 'Current password is incorrect']);
}

$stmt->close();
$conn->close();
