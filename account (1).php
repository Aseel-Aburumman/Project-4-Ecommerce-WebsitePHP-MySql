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
        <?php
        include 'navbar.php';
        ?>

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


            function toggleWishlist(event, productId) {
                event.preventDefault(); // Prevent the form from submitting normally
                const form = document.getElementById(`wishlist-form-${productId}`);
                const formData = new FormData(form);

                fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/index.php", { // Use the current page URL
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Toggle the heart icon
                        const icon = document.getElementById(`wishlist-icon-${productId}`);
                        const actionInput = form.querySelector('input[name="action"]');
                        if (actionInput.value === 'add_to_wishlist') {
                            icon.classList.remove('far');
                            icon.classList.add('fas');
                            actionInput.value = 'remove_from_wishlist';
                        } else {
                            icon.classList.remove('fas');
                            icon.classList.add('far');
                            actionInput.value = 'add_to_wishlist';
                        }
                        updateWishlistCount();
                    })
                    .catch(error => console.error('Error:', error));

                return false;
            }


            function toggleCart(event, productId) {
                event.preventDefault(); // Prevent the form from submitting normally
                const form = document.getElementById(`cart-form-${productId}`);
                const formData = new FormData(form);

                fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/index.php", { // Use the current page URL
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        // Toggle the cart icon
                        const actionInput = form.querySelector('input[name="action"]');
                        updateCartCount(); // Update the cart count
                        if (actionInput.value === 'add_to_cart') {
                            actionInput.value = 'remove_from_cart';
                        } else {
                            actionInput.value = 'add_to_cart';
                        }
                    })
                    .catch(error => console.error('Error:', error));

                return false;
            }

            function updateCartCount() {
                fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/get_cart_count.php")
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('cart-count').innerText = data.count;
                    })
                    .catch(error => console.error('Error:', error));
            }

            function updateWishlistCount() {
                fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/get_wishlist_count.php")
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('wishlist-count').innerText = data.count;
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Call updateCartCount on page load to set the initial cart count
            document.addEventListener('DOMContentLoaded', () => {
                updateCartCount();
                updateWishlistCount();
            });

            document.addEventListener('DOMContentLoaded', function() {
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
</body>