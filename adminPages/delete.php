<?php 

if(isset($_GET["user_id"])){
    $id = $_GET["user_id"];
    include '../connection.php';
$sql="DELETE FROM users WHERE user_id=$id";
$conn ->query($sql);
}
header("location: manageUser.php");
exit;
?>