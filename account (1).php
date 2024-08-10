<?php
session_start();
include 'connection.php';
include 'User.php';
include 'Validator.php';



// Delfault value
$gender = 'all';
$product_type = 'all';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_REQUEST['gender'])) {
        $gender = $_REQUEST['gender'];
    }
    if (isset($_REQUEST['product_type'])) {
        $product_type = $_REQUEST['product_type'];
    }
}

// Function to check if the user is signed in
function isUserSignedIn()
{
    return isset($_SESSION['user_id']);
}


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
            $signup_error1 = "Full Name Must be at least 4 words.";
        } elseif (!Validator::validateEmail($email)) {
            $signup_error2 = "Invalid email format.";
        } elseif (!Validator::validatePassword($password)) {
            $signup_error3 = "Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.";
        } elseif (!Validator::passwordsMatch($password, $repeatPassword)) {
            $signup_error4 = "Passwords do not match.";
        } else {
            if ($user->register($fullName, $email, $password)) {
                // echo "Registration successful!";
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
                // echo "Login successful!";
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
    <style>
        .header-bottom .search-bar {
            margin-left: 16px;
            min-width: 298px;
        }

        .signInBtn {
            width: 120px;
            padding-left: 20px;
            padding-top: 10px;
            height: 40px;
            padding-right: 20px;
        }

        #suggestions {
            position: absolute;
            top: 44px;
            width: 100%;
            z-index: 2000;
            border-radius: 0 0 10px 10px;
            border: none;
            border-top: none;
            box-shadow: 0 4px 5px #0000001f;
            /* background-color: red;  */
            background-color: white;

        }

        .suggestion-item {
            cursor: pointer;
            padding: 2px 0 2px 16px;
            background-color: transparent;
            border-radius: 0 !important;
            border: none !important;

        }

        .suggestion-item:hover {
            background-color: #2b2b5b45;
        }

        .style_searching_input {
            border-radius: 10px 10px !important;
            border-bottom: none !important;
            border: none !important;
            box-shadow: 0 -2px 5px #0000001f;
        }

        .style_searching_input_with_results {
            border-bottom: none !important;

            border-radius: 10px 10px 0 0 !important;
            border-bottom: none !important;
            border: none !important;
            box-shadow: 0 -4px 5px #0000001f;
        }
    </style>
</head>

<body>
    <!-- Header Area Start -->
    <header class="header">

        <div class="header-bottom">
            <div class="container">
                <div class="d-none d-lg-block">
                    <nav class="menu-area d-flex align-items-center">
                        <div class="logo">
                            <a href="index.php"><img src="dist/images/logo/logo.png" alt="logo" /></a>
                        </div>
                        <ul class="main-menu d-flex align-items-center">
                            <li><a href="shop.php?gender=Clothing">Clothing</a></li>
                            <li><a href="shop.php?gender=Footwear">Footwear</a></li>
                            <li><a href="shop.php?gender=Accessories">Accessories</a></li>
                            <li><a href="shop.php">Shop</a></li>
                            <li>
                                <a href="javascript:void(0)">Category
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                        <g id="Arrow" transform="translate(0.99 0.99)">
                                            <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                        </g>
                                    </svg> -->
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=T-Shirt"; ?>">T-Shirt</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shoes"; ?>">Shoes</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Hoodies"; ?>">Hoodies</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Jeans"; ?>">Jeans</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Casual"; ?>">Casual</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Accessories"; ?>">Accessories</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shorts"; ?>">Shorts</a></li>
                                </ul>
                            </li>
                            <li><a href="sales.php">Sales</a></li>
                        </ul>

                        <!-- <div class="search-bar"> -->
                        <form class="search-bar" action="product-details.php">

                            <!-- <input type="text" placeholder="Search for product..." id="searchInput" class="style_searching_input" onchange="performSearch(this)"> -->
                            <!-- <input type="text" onchange="hi123()"> -->
                            <input type="text" placeholder="Search for product..." oninput="performSearch(this)" id="searchInput" class="style_searching_input">

                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414" viewBox="0 0 20.414 20.414">
                                    <g id="Search_Icon" data-name="Search Icon" transform="translate(1 1)">
                                        <ellipse id="Ellipse_1" data-name="Ellipse 1" cx="8.158" cy="8" rx="8.158" ry="8" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <line id="Line_4" data-name="Line 4" x1="3.569" y1="3.5" transform="translate(14.431 14.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                            <div id="suggestions"></div>
                            <!-- </div> -->
                        </form>



                        <div class="menu-icon ml-auto">
                            <ul>
                                <li>
                                    <a href="<?php echo $userPageUrlFavList; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20">
                                            <g id="Heart" transform="translate(1 1)">
                                                <path id="Heart-2" data-name="Heart" d="M20.007,4.59a5.148,5.148,0,0,0-7.444,0L11.548,5.636,10.534,4.59a5.149,5.149,0,0,0-7.444,0,5.555,5.555,0,0,0,0,7.681L4.1,13.317,11.548,21l7.444-7.681,1.014-1.047a5.553,5.553,0,0,0,0-7.681Z" transform="translate(-1.549 -2.998)" fill="#fff" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="heart" id="wishlist-count"><?php echo isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $userPageUrlCart; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                            <g id="Icon" transform="translate(-1524 -89)">
                                                <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1531.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1541.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path id="Path_3" data-name="Path 3" d="M1,1H4.636L7.073,13.752a1.84,1.84,0,0,0,1.818,1.533h8.836a1.84,1.84,0,0,0,1.818-1.533L21,5.762H5.545" transform="translate(1524 89)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="cart" id="cart-count">0</span>
                                    </a>
                                </li>
                                <li>
                                    <button type="submit" class="btn bg-secondary border text-capitalize signInBtn">
                                        <a href="<?php echo $userPageUrl; ?>">Sign Up
                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg> -->
                                        </a>
                                    </button>
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
                        <li><a href="shop.php">Shop</a></li>
                        <li><a href="shop.php?gender=Clothing">Clothing</a></li>
                        <li><a href="shop.php?gender=Footwear">Footwear</a></li>
                        <li><a href="shop.php?gender=Accessories">Accessories</a></li>
                        <li>
                            <a href="javascript:void(0)">Category
                                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                    <g id="Arrow" transform="translate(0.99 0.99)">
                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                    </g>
                                </svg> -->
                            </a>
                            <ul class="sub-menu">
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=T-Shirt"; ?>">T-Shirt</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shoes"; ?>">Shoes</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Hoodies"; ?>">Hoodies</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Jeans"; ?>">Jeans</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Casual"; ?>">Casual</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Pajamas"; ?>">Pajamas</a></li>
                                <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shorts"; ?>">Shorts</a></li>
                            </ul>
                        </li>
                        <li><a href="sales.php">Sales</a></li>
                    </div>
                    <div class="mobile-nav d-flex align-items-center justify-content-between">
                        <div class="logo">
                            <a href="index.php"><img src="dist/images/logo/logo.png" alt="logo" /></a>
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
                                <li>
                                    <a href="<?php echo $userPageUrlFavList; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20">
                                            <g id="Heart" transform="translate(1 1)">
                                                <path id="Heart-2" data-name="Heart" d="M20.007,4.59a5.148,5.148,0,0,0-7.444,0L11.548,5.636,10.534,4.59a5.149,5.149,0,0,0-7.444,0,5.555,5.555,0,0,0,0,7.681L4.1,13.317,11.548,21l7.444-7.681,1.014-1.047a5.553,5.553,0,0,0,0-7.681Z" transform="translate(-1.549 -2.998)" fill="#fff" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="heart" id="wishlist-count"><?php echo isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $userPageUrlCart; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                            <g id="Icon" transform="translate(-1524 -89)">
                                                <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1531.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1541.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path id="Path_3" data-name="Path 3" d="M1,1H4.636L7.073,13.752a1.84,1.84,0,0,0,1.818,1.533h8.836a1.84,1.84,0,0,0,1.818-1.533L21,5.762H5.545" transform="translate(1524 89)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="cart" id="cart-count">0</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $userPageUrl; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg></a>
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
                                </div>
                                <span id="loginEmailError" class="text-danger"><?php echo $login_error; ?></span><br><br>

                                <div class="form__div mb-0">
                                    <input type="password" name="loginPassword" id="loginPassword" class="form__input" placeholder=" " required>
                                    <label for="loginPassword" class="form__label">Password</label>
                                </div>
                                <span id="loginPasswordError" class="text-danger"><?php echo $login_error; ?></span><br><br>

                                <div class="password-info d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="password-info-left">
                                        <input type="checkbox" id="showpass" class="mb-0" onclick="togglePasswordVisibility('loginPassword')">
                                        <label for="showpass" class="mb-0">Show Password</label>
                                    </div>
                                    <div class="password-info-right">
                                        <a href="forget-password.php">Forget Password</a>
                                    </div>
                                </div>
                                <button type="submit" name="login" class="btn bg-primary">Sign in</button>
                            </form>
                            <div class="social-signing">
                                <!-- <p class="text-center">or sign in with</p> -->
                                <div class="social-signing-link">
                                    <!-- <a href="https://web.facebook.com/osama.alabsi.9081" class="ml-0"> -->
                                    <!-- Google Icon SVG omitted for brevity -->
                                    <!-- Facebook -->
                                    <!-- </a> -->

                                    <!-- <a href="#"> -->
                                    <!-- Twitter Icon SVG omitted for brevity -->
                                    <!-- Twitter -->
                                    <!-- </a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="account-sign-up">
                            <h5 class="text-center">Sign up</h5>
                            <form id="signUpForm" method="POST" action="">

                                <div class="form__div">

                                    <input type="text" name="fullName" id="signUpName" class="form__input" placeholder=" ">
                                    <label for="signUpName" class="form__label">Full Name</label>


                                </div>
                                <span id="signUpNameError" class="text-danger"><?php echo $signup_error1; ?></span><br><br>

                                <div class="form__div">
                                    <input type="email" name="email" id="signUpEmail" class="form__input" placeholder=" ">
                                    <label for="signUpEmail" class="form__label">Email</label>


                                </div>
                                <span id="signUpEmailError" class="text-danger"><?php echo $signup_error2; ?></span><br><br>


                                <div class="form__div">
                                    <input type="password" name="password" id="signUpPassword" class="form__input" placeholder=" ">
                                    <label for="signUpPassword" class="form__label">Password</label>

                                </div>
                                <span id="signUpPasswordError" class="text-danger"><?php echo $signup_error3; ?></span><br><br>

                                <div class="form__div mb-0">
                                    <input type="password" name="RepeatPassword" id="signUpRepeatPassword" class="form__input" placeholder=" ">
                                    <label for="signUpRepeatPassword" class="form__label">Repeat Password</label>


                                </div>
                                <span id="signUpRepeatPasswordError" class="text-danger"><?php echo $signup_error4; ?></span><br><br>
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

        <script>
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
            }
        </script>










        <!-- Footer -->
        <?php
        include 'footer.php';
        ?>
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


            ent.addEventListener('DOMContentLoaded', function() {
                const orderButtons = document.querySelectorAll(".order-again");

                Array.from(orderButtons).forEach(button => {
                    button.addEventListener("click", function() {
                        const productId = this.dataset.productId;

                        fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/add_to_cart.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify({
                                    product_id: productId
                                }),
                            })
                            .then(response => response.text()) // Get the raw response text
                            .then(text => {
                                console.log("Raw Response:", text); // Log the raw response

                                try {
                                    const data = JSON.parse(text);
                                    if (data.status === "success") {
                                        alert(data.message);
                                    } else {
                                        alert("Failed to add product to cart: " + data.message);
                                    }
                                } catch (error) {
                                    console.error("Response is not valid JSON:", text);
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                            });
                    });
                });
            });
        </script>
        <script>
            function check_my_div() {

                myYousef = document.querySelector("#suggestions");
                if (myYousef.innerHTML == '') {
                    // myYousef.style.borderColor = 'green';
                    document.querySelector("#searchInput").className = 'style_searching_input';
                    myYousef.style.visibility = 'hidden';
                    // document.querySelector("#searchInput").classList.remove("mystyle") = 'style_searching_input';
                } else {
                    document.querySelector("#searchInput").className = 'style_searching_input_with_results';
                    myYousef.style.visibility = 'visible';
                    // myYousef.style.borderColor = 'red ';
                }
            }
            check_my_div()






            let list_for_search = [];
            async function yousef() {
                let api = await fetch(`api_get.php/products.json`);
                // console.log(api);

                let Json = await api.json();
                console.log(Json);
                Json.forEach(element => {

                    const name = element['product_name'].split(",")[0];

                    Object_yousef = {
                        // name: name
                        name: element['product_name']
                    }
                    list_for_search.push(Object_yousef);
                });
            }
            yousef()



            function performSearch(ele) {

                var search_id = 'searchInput';
                var div_id = 'suggestions';


                const query = document.getElementById(search_id).value.toLowerCase();
                const suggestionsDiv = document.getElementById(div_id);

                suggestionsDiv.innerHTML = '';


                if (query.length === 0) {
                    return;
                }

                const filteredData = list_for_search.filter(item => item.name.toLowerCase().includes(query));

                console.log(filteredData)

                if (filteredData.length > 0) {

                    for (let i = 0; i < 8; i++) {

                        const div = document.createElement('input');
                        div.type = 'submit';
                        div.name = 'serch_product';

                        div.value = filteredData[i].name;
                        div.className = 'suggestion-item';

                        suggestionsDiv.appendChild(div);
                        check_my_div()
                    }
                }
            }

            function selectSuggestion(suggestion = '', search_id = '', div_id = '') {
                if (suggestion && search_id && div_id) {

                    document.getElementById(search_id).value = suggestion;
                    document.getElementById(div_id).innerHTML = '';
                }
            }
        </script>
</body>