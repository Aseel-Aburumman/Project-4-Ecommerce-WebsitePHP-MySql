<?php
session_start();

// Unset the specific session variable
unset($_SESSION['user_name']);

// Optionally, unset other related session variables if needed
unset($_SESSION['user_email']);
unset($_SESSION['user_id']);
unset($_SESSION['user_role']);

// Redirect to login page
header("Location: ../account (1).php");
exit();
?>