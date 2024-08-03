<?php
session_start();
include 'connection.php';
include 'User.php';
include 'Validator.php';

$signup_error = '';
$signup_error1 = '';
$signup_error2 = '';
$signup_error3 = '';
$signup_error4 = '';
$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User($conn);

    if (isset($_POST['signup'])) {
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['RepeatPassword'];

        if (empty($fullName) || empty($email) || empty($password) || empty($repeatPassword)) {
            $signup_error = "All fields are required.";
        } elseif (!Validator::validateName($fullName)) {
            $signup_error1 = "Full name must be at least 4 words.";
        } elseif (!Validator::validateEmail($email)) {
            $signup_error2 = "Invalid email format.";
        } elseif (!Validator::validatePassword($password)) {
            $signup_error3 = "Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.";
        } elseif (!Validator::passwordsMatch($password, $repeatPassword)) {
            $signup_error4 = "Passwords do not match.";
        } else {
            if ($user->register($fullName, $email, $password)) {
                echo "Registration successful!";
            } else {
                $signup_error = "Error registering user.";
            }
        }
    }

    if (isset($_POST['login'])) {
        $email = $_POST['loginEmail'];
        $password = $_POST['loginPassword'];

        if (empty($email) || empty($password)) {
            $login_error = "All fields are required.";
        } else {
            if ($user->login($email, $password)) {
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $user->getUsername($email);
                $_SESSION['user_id'] = $user->getUserId($email); // Save user ID in session
                $_SESSION['user_role'] = $user->getRoleId($email);
                echo "Login successful!";
                if ($_SESSION['user_role'] == 1) {
                    header("Location: adminPages/dashboard.php");
                } elseif ($_SESSION['user_role'] == 2) {
                    header("Location: index.php");
                }
                exit();
            } else {
                $login_error = "Invalid email or password.";
            }
        }
    }
}


if (isset($_POST['login'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    if (empty($email) || empty($password)) {
        $login_error = "All fields are required.";
    } else {
        if ($user->login($email, $password)) {
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $user->getUsername($email);
            $_SESSION['user_role'] = $user->getRoleId($email);
            echo "Login successful!";
            if ($_SESSION['user_role'] == 1) {
                header("Location: adminPages/dashboard.php");
            } elseif ($_SESSION['user_role'] == 2) {
                header("Location: index.php");
            }
            exit();
        } else {
            $login_error = "Invalid email or password.";
        }
    }
}




?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog - Account</title>
    <link rel="stylesheet" href="dist/main.css">
</head>

<body>
    <!-- Header Area Start -->
    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="header-top-wrapper">
                            <div class="header-top-info">
                                <div class="email">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.95" height="13.4" viewBox="0 0 16.95 13.4">
                                            <g id="Mail" transform="translate(0.975 0.7)">
                                                <path id="Path_1" data-name="Path 1" d="M3.5,4h12A1.5,1.5,0,0,1,17,5.5v9A1.5,1.5,0,0,1,15.5,16H3.5A1.5,1.5,0,0,1,2,14.5v-9A1.5,1.5,0,0,1,3.5,4Z" transform="translate(-2 -4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                <path id="Path_2" data-name="Path 2" d="M17,6,9.5,11.25,2,6" transform="translate(-2 -4.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="text">
                                        <span>olog.wetbise@mail.com</span>
                                    </div>
                                </div>
                                <div class="cta">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13.401" height="13.401" viewBox="0 0 13.401 13.401">
                                            <g id="Phone_Icon" data-name="Phone Icon" transform="translate(0.7 0.7)">
                                                <path id="Phone_Icon-2" data-name="Phone Icon" d="M14.111,10.984v1.806A1.206,1.206,0,0,1,12.8,14a11.956,11.956,0,0,1-5.207-1.849,11.754,11.754,0,0,1-3.62-3.613A11.9,11.9,0,0,1,2.117,3.313,1.205,1.205,0,0,1,3.317,2h1.81A1.206,1.206,0,0,1,6.334,3.036a7.719,7.719,0,0,0,.422,1.692A1.2,1.2,0,0,1,6.485,6l-.766.765a9.644,9.644,0,0,0,3.62,3.613l.766-.765a1.208,1.208,0,0,1,1.273-.271,7.76,7.76,0,0,0,1.7.422,1.205,1.205,0,0,1,1.038,1.222Z" transform="translate(-2.112 -2)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="text">
                                        <span>+8801658 874521</span>
                                    </div>
                                </div>
                            </div>
                            <div class="header-top-switcher">
                                <div class="language">
                                    <select>
                                        <option data-display="English">English</option>
                                        <option value="1">Arabic</option>
                                        <option value="2">Aramaic</option>
                                        <option value="4">Bangla</option>
                                    </select>
                                </div>
                                <div class="currency">
                                    <select>
                                        <option data-display="Currency">USD</option>
                                        <option value="1">BDT</option>
                                        <option value="2">SNG</option>
                                        <option value="4">ERU</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="d-none d-lg-block">
                    <nav class="menu-area d-flex align-items-center">
                        <div class="logo">
                            <a href="index.html"><img src="dist/images/logo/logo.png" alt="logo" /></a>
                        </div>
                        <ul class="main-menu d-flex align-items-center">
                            <li><a class="active" href="index.html">Home</a></li>
                            <li><a href="shop.html">Men</a></li>
                            <li><a href="shop.html">Women</a></li>
                            <li><a href="shop.html">Shop</a></li>
                            <li>
                                <a href="javascript:void(0)">Category
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                        <g id="Arrow" transform="translate(0.99 0.99)">
                                            <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                        </g>
                                    </svg>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="javascript:void(0)">Category 1</a></li>
                                    <li><a href="javascript:void(0)">Category 2</a></li>
                                    <li><a href="javascript:void(0)">Category 3</a></li>
                                    <li><a href="javascript:void(0)">Category 4</a></li>
                                    <li><a href="javascript:void(0)">Category 5</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0)">Sales</a></li>
                        </ul>
                        <div class="search-bar">
                            <input type="text" placeholder="Search for product...">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414" viewBox="0 0 20.414 20.414">
                                    <g id="Search_Icon" data-name="Search Icon" transform="translate(1 1)">
                                        <ellipse id="Ellipse_1" data-name="Ellipse 1" cx="8.158" cy="8" rx="8.158" ry="8" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <line id="Line_4" data-name="Line 4" x1="3.569" y1="3.5" transform="translate(14.431 14.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="menu-icon ml-auto">
                            <ul>
                                <li>
                                    <a href="wishlist.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20">
                                            <g id="Heart" transform="translate(1 1)">
                                                <path id="Heart-2" data-name="Heart" d="M20.007,4.59a5.148,5.148,0,0,0-7.444,0L11.548,5.636,10.534,4.59a5.149,5.149,0,0,0-7.444,0,5.555,5.555,0,0,0,0,7.681L4.1,13.317,11.548,21l7.444-7.681,1.014-1.047a5.553,5.553,0,0,0,0-7.681Z" transform="translate(-1.549 -2.998)" fill="#fff" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="heart">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="cart.html"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                            <g id="Icon" transform="translate(-1524 -89)">
                                                <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1531.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1541.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path id="Path_3" data-name="Path 3" d="M1,1H4.636L7.073,13.752a1.84,1.84,0,0,0,1.818,1.533h8.836a1.84,1.84,0,0,0,1.818-1.533L21,5.762H5.545" transform="translate(1524 89)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="cart">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="account.html"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- Mobile Menu -->
                <aside class="d-lg-none">
                    <div id="mySidenav" class="sidenav">
                        <div class="close-mobile-menu">
                            <a href="javascript:void(0)" id="menu-close" class="closebtn" onclick="closeNav()">&times;</a>
                        </div>
                        <div class="search-bar">
                            <input type="text" placeholder="Search for product...">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414" viewBox="0 0 20.414 20.414">
                                    <g id="Search_Icon" data-name="Search Icon" transform="translate(1 1)">
                                        <ellipse id="Ellipse_1" data-name="Ellipse 1" cx="8.158" cy="8" rx="8.158" ry="8" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <line id="Line_4" data-name="Line 4" x1="3.569" y1="3.5" transform="translate(14.431 14.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="shop.html">Men</a></li>
                        <li><a href="shop.html">Women</a></li>
                        <li><a href="shop.html">Shop</a></li>
                        <li>
                            <a href="javascript:void(0)">Category
                                <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                    <g id="Arrow" transform="translate(0.99 0.99)">
                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                    </g>
                                </svg>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="javascript:void(0)">Category 1</a></li>
                                <li><a href="javascript:void(0)">Category 2</a></li>
                                <li><a href="javascript:void(0)">Category 3</a></li>
                                <li><a href="javascript:void(0)">Category 4</a></li>
                                <li><a href="javascript:void(0)">Category 5</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0)">Sales</a></li>
                    </div>
                    <div class="mobile-nav d-flex align-items-center justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="dist/images/logo/logo.png" alt="logo" /></a>
                        </div>
                        <div class="search-bar">
                            <input type="text" placeholder="Search for product...">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414" viewBox="0 0 20.414 20.414">
                                    <g id="Search_Icon" data-name="Search Icon" transform="translate(1 1)">
                                        <ellipse id="Ellipse_1" data-name="Ellipse 1" cx="8.158" cy="8" rx="8.158" ry="8" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <line id="Line_4" data-name="Line 4" x1="3.569" y1="3.5" transform="translate(14.431 14.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="menu-icon">
                            <ul>
                                <li> <a href="wishlist.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20">
                                            <g id="Heart" transform="translate(1 1)">
                                                <path id="Heart-2" data-name="Heart" d="M20.007,4.59a5.148,5.148,0,0,0-7.444,0L11.548,5.636,10.534,4.59a5.149,5.149,0,0,0-7.444,0,5.555,5.555,0,0,0,0,7.681L4.1,13.317,11.548,21l7.444-7.681,1.014-1.047a5.553,5.553,0,0,0,0-7.681Z" transform="translate(-1.549 -2.998)" fill="#fff" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="heart">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="cart.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                            <g id="Icon" transform="translate(-1524 -89)">
                                                <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1531.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1541.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path id="Path_3" data-name="Path 3" d="M1,1H4.636L7.073,13.752a1.84,1.84,0,0,0,1.818,1.533h8.836a1.84,1.84,0,0,0,1.818-1.533L21,5.762H5.545" transform="translate(1524 89)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="cart">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="account.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="hamburger-menu">
                            <a style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</a>
                        </div>
                    </div>
                </aside>
                <!-- Body overlay -->
                <div class="overlay" id="overlayy"></div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->
    <main>
        <section class="account-sign">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="account-sign-in">
                            <h5 class="text-center">Sign in</h5>
                            <form id="loginForm" method="POST" action="">
                                <div class="form__div">
                                    <input type="email" name="loginEmail" id="loginEmail" class="form__input" placeholder=" " required>
                                    <label for="loginEmail" class="form__label">Email</label>
                                    <small id="loginEmailError" class="text-danger"><?php echo $login_error; ?></small>
                                </div>
                                <small id="loginEmailError" class="text-danger"><?php echo $login_error; ?></small>
                                <div class="form__div mb-0">
                                    <input type="password" name="loginPassword" id="loginPassword" class="form__input" placeholder=" " required>
                                    <label for="loginPassword" class="form__label">Password</label>
                                    <small id="loginPasswordError" class="text-danger"><?php echo $login_error; ?></small>
                                </div>
                                <div class="password-info d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="password-info-left">
                                        <input type="checkbox" id="showpass" class="mb-0" onclick="togglePasswordVisibility('loginPassword')">
                                        <label for="showpass" class="mb-0">Show Password</label>
                                    </div>
                                    <div class="password-info-right">
                                        <a href="forget-password.html">Forget Password</a>
                                    </div>
                                </div>
                                <button type="submit" name="login" class="btn bg-primary">Sign in</button>
                            </form>
                            <div class="social-signing">
                                <p class="text-center">or sign in with</p>
                                <div class="social-signing-link">
                                    <a href="#" class="ml-0">
                                        <!-- Google Icon SVG omitted for brevity -->
                                        Google
                                    </a>
                                    <a href="#">
                                        <!-- Facebook Icon SVG omitted for brevity -->
                                        Facebook
                                    </a>
                                    <a href="#">
                                        <!-- Twitter Icon SVG omitted for brevity -->
                                        Twitter
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="account-sign-up">
                            <h5 class="text-center">Sign up</h5>
                            <small id="signUpNameError" class="text-danger"><?php echo $signup_error1; ?></small><br>
                            <form id="signUpForm" method="POST" action="">
                                <div class="form__div">

                                    <input type="text" name="fullName" id="signUpName" class="form__input" placeholder=" ">
                                    <label for="signUpName" class="form__label">Full Name</label>

                                </div>
                                <small id="signUpEmailError" class="text-danger"><?php echo $signup_error2; ?></small>
                                <div class="form__div">
                                    <input type="email" name="email" id="signUpEmail" class="form__input" placeholder=" " required>
                                    <label for="signUpEmail" class="form__label">Email</label>


                                </div>
                                <small id="signUpPasswordError" class="text-danger"><?php echo $signup_error3; ?></small>

                                <div class="form__div">
                                    <input type="password" name="password" id="signUpPassword" class="form__input" placeholder=" " required>
                                    <label for="signUpPassword" class="form__label">Password</label>

                                </div>
                                <small id="signUpRepeatPasswordError" class="text-danger"><?php echo $signup_error4; ?></small>
                                <div class="form__div mb-0">
                                    <input type="password" name="RepeatPassword" id="signUpRepeatPassword" class="form__input" placeholder=" " required>
                                    <label for="signUpRepeatPassword" class="form__label">Repeat Password</label>

                                </div>

                                <div class="password-info-show">
                                    <input type="checkbox" id="showpassagain" class="mb-0" onclick="togglePasswordVisibility('signUpPassword', 'signUpRepeatPassword')">
                                    <label for="showpassagain" class="mb-0">Show Password</label>
                                </div>
                                <button type="submit" name="signup" class="btn bg-primary">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- <script>

document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const signUpForm = document.getElementById("signUpForm");

    loginForm.addEventListener("submit", function(event) {
        let valid = true;
        const loginEmail = document.getElementById("loginEmail");
        const loginPassword = document.getElementById("loginPassword");
        
        if (!validateEmail(loginEmail.value)) {
            document.getElementById("loginEmailError").innerText = "Invalid email format.";
            valid = false;
        } else {
            document.getElementById("loginEmailError").innerText = "";
        }
        
        if (loginPassword.value.trim() === "") {
            document.getElementById("loginPasswordError").innerText = "Password is required.";
            valid = false;
        } else {
            document.getElementById("loginPasswordError").innerText = "";
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    signUpForm.addEventListener("submit", function(event) {
        let valid = true;
        const signUpName = document.getElementById("signUpName");
        const signUpEmail = document.getElementById("signUpEmail");
        const signUpPassword = document.getElementById("signUpPassword");
        const signUpRepeatPassword = document.getElementById("signUpRepeatPassword");
        
        if (!validateName(signUpName.value)) {
            document.getElementById("signUpNameError").innerText = "Full name must be at least 4 words.";
            valid = false;
        } else {
            document.getElementById("signUpNameError").innerText = "";
        }
        
        if (!validateEmail(signUpEmail.value)) {
            document.getElementById("signUpEmailError").innerText = "Invalid email format.";
            valid = false;
        } else {
            document.getElementById("signUpEmailError").innerText = "";
        }
        
        if (!validatePassword(signUpPassword.value)) {
            document.getElementById("signUpPasswordError").innerText = "Password must be hard paswwod inclode @#$%^";
            valid = false;
        } else {
            document.getElementById("signUpPasswordError").innerText = "";
        }

        if (signUpPassword.value !== signUpRepeatPassword.value) {
            document.getElementById("signUpRepeatPasswordError").innerText = "Passwords do not match.";
            valid = false;
        } else {
            document.getElementById("signUpRepeatPasswordError").innerText = "";
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
    }

    function validateName(name) {
        const words = name.trim().split(/\s+/);
        return words.length >= 4;
    }

    function validatePassword(password) {
        const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return re.test(password);
    }
});

function togglePasswordVisibility(...fields) {
    fields.forEach(field => {
        const fieldElem = document.getElementById(field);
        fieldElem.type = fieldElem.type === 'password' ? 'text' : 'password';
    });
} -->



        </script>










        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row align-items-center newsletter-area">
                    <div class="col-lg-5">
                        <div class="newsletter-area-text">
                            <h4 class="text-white">Subscribe to get notification.</h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-1">
                        <div class="newsletter-area-button">
                            <form action="#">
                                <div class="form">
                                    <input type="email" name="email" id="mail" placeholder="Enter your email address" class="form-control">
                                    <button class="btn bg-secondary border text-capitalize">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row main-footer">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="main-footer-info">
                            <img src="dist/images/logo/white.png" alt="Logo" class="img-fluid">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam molestie malesuada
                                metus, non molestie ligula laoreet vitae. Ut et fringilla risus, vel.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-2 offset-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="main-footer-quicklinks">
                            <h6>Company</h6>
                            <ul class="quicklink">
                                <li><a href="#">About</a></li>
                                <li><a href="#">Help &amp; Support</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms of Service</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="main-footer-quicklinks">
                            <h6>Quick links</h6>
                            <ul class="quicklink">
                                <li><a href="#">New Realease</a></li>
                                <li><a href="#">Customize</a></li>
                                <li><a href="#">Sale &amp; Discount</a></li>
                                <li><a href="#">Men</a></li>
                                <li><a href="#">Women</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="main-footer-quicklinks">
                            <h6>Account</h6>
                            <ul class="quicklink">
                                <li><a href="#">Your Bag</a></li>
                                <li><a href="#">Profile</a></li>
                                <li><a href="#">Order Completed</a></li>
                                <li><a href="#">Log-out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright d-flex justify-content-between align-items-center">
                            <div class="copyright-text order-2 order-lg-1">
                                <p>&copy; 2020. Design and Developed by <a href="#">Zakir Soft</a></p>
                            </div>
                            <div class="copyright-links order-1 order-lg-2">
                                <a href="#" class="ml-0"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer -->

        <script src="src/js/jquery.min.js"></script>
        <script src="src/js/bootstrap.min.js"></script>
        <script src="src/scss/vendors/plugin/js/jquery.nice-select.min.js"></script>
        <script src="dist/main.js"></script>
        <script>
            function openNav() {

                document.getElementById("mySidenav").style.width = "350px";
                $('#overlayy').addClass("active");
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                $('#overlayy').removeClass("active");
            }
        </script>
</body>