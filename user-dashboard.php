<?php
include 'connection.php';
session_start();





?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog - Account Settings</title>
    <link rel="stylesheet" href="dist/main.css">
    <style>
        mark {
            background: linear-gradient(-100deg, hsla(48, 92%, 75%, .3), hsla(48, 92%, 75%, .7) 95%, hsla(48, 92%, 75%, .1));
            border-radius: 1em 0;
            padding: .5rem;
        }
    </style>
</head>

<body>
    <!-- Header Area Start -->
    <header class="header">

        <?php

        function isUserSignedInbtn()
        {
            return isset($_SESSION['user_id']);
        }
        // اكاونت من عبسي

        if (isUserSignedInbtn()) {
            include 'navbar.php';
        } else {
            include 'navbar_guest.php';
        }



        ?>
    </header>
    <!-- Header Area End -->

    <main>
        <!-- Breadcrumb Area Start -->
        <section class="breadcrumb-area mt-15">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb">
                            <?php if (isUserSignedInbtn()) {
                                echo '<h3 style="font-size: 1.5rem;" class="breadcrumb-item"><a href="user-dashboard.php">Hi <mark id="usernameHighlight"></mark></a></h3>';
                            }
                            ?>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Account</li>
                            </ol>
                        </nav>
                        <h5>Account</h5>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Area End -->

        <!--Acount Area Start -->
        <section class="account">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Dashboard-Nav  Start-->
                        <div class="dashboard-nav">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="user-dashboard.php" class="active">Account
                                        settings</a></li>
                                <li class="list-inline-item"><a href="deliver-info.php">Billing information</a></li>
                                <li class="list-inline-item"><a href="wishlist.php">My wishlist</a></li>
                                <li class="list-inline-item"><a href="cart.php">My cart</a></li>
                                <li class="list-inline-item"><a href="order.php">Order</a></li>
                                <li class="list-inline-item"><a href="/Project-4-Ecommerce-WebsitePHP-MySql/api/logout.php" class="mr-0">Log-out</a></li>
                            </ul>
                        </div>
                        <!-- Dashboard-Nav  End-->
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="account-setting">
                            <h6>Account setting</h6>
                            <form action="#">
                                <div class="form__div">
                                    <input type="text" name="username" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">UserName</label>
                                </div>
                                <div class="form__div">
                                    <input type="text" name="full_name" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">Full Name</label>
                                </div>
                                <div class="form__div">
                                    <input type="email" name="email" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">Email</label>
                                </div>
                                <button type="submit" class="btn bg-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="change-password">
                            <h6>Change password</h6>
                            <form action="#">
                                <div class="form__div">
                                    <input type="password" name="current_password" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">Current password</label>
                                </div>
                                <div class="form__div">
                                    <input type="password" name="new_password" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">New password</label>
                                </div>
                                <div class="form__div mb-40">
                                    <input type="password" name="confirm_password" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">Confirm password</label>
                                </div>
                                <button type="submit" class="btn bg-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 col-md-12">
                        <div class="account-setting">
                            <h6>Account setting</h6>
                            <form action="#">
                                <div class="form__div">
                                    <input type="text" class="form__input" placeholder="
                                    ">
                                    <label for="" class="form__label">UserName</label>
                                </div>
                                <div class="form__div">
                                    <input type="text" class="form__input" placeholder="
                                    ">
                                    <label for="" class="form__label">Full Name</label>
                                </div>
                                <div class="form__div">
                                    <input type="email" class="form__input" placeholder="
                                    ">
                                    <label for="" class="form__label">Email</label>
                                </div>
                                <button type="submit" class="btn bg-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="change-password">
                            <h6>Change password</h6>
                            <form action="#">
                                <div class="form__div">
                                    <input type="password" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">Current password</label>
                                </div>
                                <div class="form__div">
                                    <input type="password" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">New passwords</label>
                                </div>
                                <div class="form__div mb-40">
                                    <input type="password" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">Confirm passwords</label>
                                </div>
                                <button type="submit" class="btn bg-primary">Save Changes</button>
                            </form>
                        </div>
                    </div> -->
                </div>
            </div>
        </section>
        <!--Acount Area End -->

    </main>

    <!-- Footer -->
    <?php
    include 'footer.php';
    ?>
    <!-- Footer -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/fetch_aseel_user_data.php')
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        let firstName = data.username.split(' ')[0];
                        document.getElementById('usernameHighlight').textContent = firstName;
                    } else {
                        alert(data.error);
                    }
                });

        })
    </script>
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

        document.addEventListener('DOMContentLoaded', function() {
            fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/fetch_aseel_user_data.php')
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        document.querySelector('input[name="username"]').value = data.username;
                        document.querySelector('input[name="full_name"]').value = data.Full_name;
                        document.querySelector('input[name="email"]').value = data.email;
                    } else {
                        alert(data.error);
                    }
                });

            document.querySelector('.account-setting form').addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);

                fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/update_aseel_user_data.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.success || data.error);
                    });
            });

            document.querySelector('.change-password form').addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);

                fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/update_aseel_user_data.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.success || data.error);
                    });
            });
        });
    </script>
</body>