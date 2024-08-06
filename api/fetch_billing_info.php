<?php
header('Content-Type: application/json');
require '../connection.php';

session_start();
// user_id in session عفوري 
$user_id = $_SESSION['user_id'];
// test purpose pls fix aseel
// echo $user_id;

// $user_id = 3;

$sql = "SELECT bi.firstname, bi.lastname, bi.address, bi.building, bi.city, bi.phone, u.email 
        FROM billing_information bi 
        JOIN users u ON bi.user_id = u.user_id 
        WHERE bi.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $billing_info = $result->fetch_assoc();
    echo json_encode($billing_info);
} else {
    echo json_encode(['error' => 'Billing information not found']);
}

$stmt->close();
$conn->close();
