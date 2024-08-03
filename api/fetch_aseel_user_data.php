<?php
header('Content-Type: application/json');
require '../connection.php';

session_start();
// user_id in session عفوري 

$user_id = $_SESSION['user_id'];
// test purpose pls fix aseel
// $user_id = 3;


$sql = "SELECT username, Full_name, email FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    echo json_encode($user_data);
} else {
    echo json_encode(['error' => 'User not found']);
}

$stmt->close();
$conn->close();
