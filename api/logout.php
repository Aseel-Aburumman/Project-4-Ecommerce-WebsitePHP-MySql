<?php
session_start();
session_unset();
session_destroy();
header("Location: ../account (1).php"); // Redirect to the login page
exit();
