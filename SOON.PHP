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
    <title>Olog - Coming soon</title>
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
                            <div style="margin-right: 20px; ">
                                <h3 style="margin-bottom: 20px;" class="text-center">Coming Soon 🚀 </h3>
                                <h4 style="margin-bottom: 20px;" class="text-left">Big Things Are Coming!
                                </h4>
                                <h6 style="margin-bottom: 20px; " class="text-left">We’re working on something amazing just for <br> you. Stay tuned for updates and be
                                    the first to experience it!</h6>
                                <h4 class="text-left">Stay Tuned!
                                </h4>
                            </div>
                            <div><img src="/Project-4-Ecommerce-WebsitePHP-MySql/dist/images/brand/slow-loading.png" alt=""></div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
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
    </script>
</body>