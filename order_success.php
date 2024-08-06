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
    <title>Order Success</title>
    <link rel="stylesheet" href="dist/main.css">
    <link rel="stylesheet" href="dist/aseel.css">

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
        <!-- Account-Login -->
        <section class="account-sign">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div style="display: flex;" style="margin-right: 20px;" class="account-sign-in">
                            <div style="flex:1;margin-right: 20px; ">
                                <h3 style="margin-bottom: 20px;" class="text-center">Order Success 🎉 </h3>
                                <h4 style="margin-bottom: 20px;" class="text-left">Thank You for Your Order!
                                </h4>
                                <h6 style="margin-bottom: 20px; " class="text-left">Your order has been placed successfully. We’re on it!</h6>
                                <h4 style="margin-bottom: 20px;" class="text-left">What’s Next?
                                </h4>
                                <p style="margin-bottom: 20px; " class="text-left"><b>Order Confirmation:</b><br>
                                    Check your email for the details.<br><br>
                                    <b>Shipping Info:</b><br> We’ll update you as soon as your order ships.<br><br>
                                    <b>Need Help?:</b><br> Our support team is here for you.<br>
                                    Thank you for shopping with us! We can’t wait for you to receive your items. 😊
                                </p>
                                <h4 class="text-left">Stay Tuned!
                                </h4>
                            </div>
                            <div style="flex:1;"><img src="/Project-4-Ecommerce-WebsitePHP-MySql/dist/images/brand/thankyou.webp" alt=""></div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center newsletter-area">
                <div class="col-lg-5">
                    <div class="newsletter-area-text">
                        <h4 class="text-white">Subscribe to get notification.</h4>
                        <p>
                            Receive our weekly newsletter.
                            For dietary content, fashion insider and the best offers.
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
            <!-- <div class="row main-footer">
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="main-footer-info">
                        <img src="dist/images/logo/white.png" alt="Logo" class="img-fluid">
                        <p>
                            We’re available by phone +962 782 615 549<br>
                            info@example.com<br>
                            Sunday till Friday 10 to 6 EST
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
            </div> -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright d-flex justify-content-between align-items-center">
                        <div class="copyright-text order-2 order-lg-1">
                            <p>&copy; 2024. All rights reserved. </p>
                        </div>
                        <div class="copyright-links order-1 order-lg-2">
                            <a href="soon.php" class="ml-0"><i class="fab fa-facebook-f"></i></a>
                            <a href="soon.php"><i class="fab fa-twitter"></i></a>
                            <a href="soon.php"><i class="fab fa-youtube"></i></a>
                            <a href="soon.php"><i class="fab fa-instagram"></i></a>
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


</html>