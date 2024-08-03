<?php


include '../connection.php';

$sql = "SELECT count(user_id) as numberOfUsers FROM users where role_id=2";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $maxSalary = $row['max'];
    $minSalary = $row['min'];
    $sumSalary = $row['sum'];
    $avgSalary = $row['avg'];
} else {
    $maxSalary = $minSalary = $sumSalary = $avgSalary = "No data";
}

$conn->close();
?>