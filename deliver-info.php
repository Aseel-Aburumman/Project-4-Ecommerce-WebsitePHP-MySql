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
    <title>Olog - deliver-Info</title>
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

    <!-- BreadCrumb Start-->
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
                            <li class="breadcrumb-item active" aria-current="page">Billing information</li>
                        </ol>
                    </nav>
                    <h5>Billing information</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- BreadCrumb Start-->

    <!--Deliver Info Start-->
    <section class="deliver-info">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Dashboard-Nav  Start-->
                    <div class="dashboard-nav">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="user-dashboard.php">Account
                                    settings</a></li>
                            <li class="list-inline-item"><a href="deliver-info.php" class="active">Billing information</a></li>
                            <li class="list-inline-item"><a href="wishlist.php">My wishlist</a></li>
                            <li class="list-inline-item"><a href="cart.php">My cart</a></li>
                            <li class="list-inline-item"><a href="order.php">Order</a></li>
                            <li class="list-inline-item"><a href="/Project-4-Ecommerce-WebsitePHP-MySql/api/logout.php" class="mr-0">Log-out</a></li>
                        </ul>
                    </div>
                    <!-- Dashboard-Nav  End-->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="deliver-info-form">
                        <h6>Billing information</h6>
                        <form action="#">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form__div">
                                        <input type="text" name="firstname" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">First Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form__div">
                                        <input type="text" name="lastname" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">Last Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div">
                                        <input type="text" name="address" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div">
                                        <input type="text" name="building" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">Apartment, House</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div mb-0">
                                        <input type="text" name="city" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">City</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div">
                                        <input type="text" name="phone" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">Phone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div">
                                        <input type="email" name="email" class="form__input" placeholder=" " readonly>
                                        <label for="" class="form__label">Email</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn bg-primary" type="submit">Save Changes</button>
                        </form>
                    </div>
                    <!-- <div class="deliver-info-form">
                        <h6>Billing information</h6>
                        <form action="#">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form__div">
                                        <input type="text" class="form__input" placeholder="
                                        ">
                                        <label for="" class="form__label">First Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form__div">
                                        <input type="text" class="form__input" placeholder="
                                        ">
                                        <label for="" class="form__label">Last Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div">
                                        <input type="text" class="form__input" placeholder="
                                        ">
                                        <label for="" class="form__label">Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div">
                                        <input type="text" class="form__input" placeholder="
                                        ">
                                        <label for="" class="form__label">Apartment, House</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div mb-0">
                                        <input type="text" class="form__input" placeholder="
                                        ">
                                        <label for="" class="form__label">City</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <br>
                                <div class="col-lg-4 col-md-4 col-12 mt-30">
                                    <select name="" id="">
                                        <option value="01">Country/Region</option>
                                        <option value="02">United States</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12 mt-30">
                                    <select name="" id="">
                                        <option value="01">States</option>
                                        <option value="02">Chicago</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12 mt-30">
                                    <div class="form__div">
                                        <input type="text" class="form__input" placeholder="
                                        ">
                                        <label for="" class="form__label">Zip Code</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div">
                                        <input type="text" class="form__input" placeholder="
                                        ">
                                        <label for="" class="form__label">Phone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form__div">
                                        <input type="email" class="form__input" placeholder="
                                        ">
                                        <label for="" class="form__label">Email</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn bg-primary" type="submit">Save Changes</button>
                        </form>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!--Deliver Info End-->

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
        document.addEventListener('DOMContentLoaded', function() {
            fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/fetch_billing_info.php')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Log the fetched data to the console
                    if (!data.error) {
                        document.querySelector('input[name="firstname"]').value = data.firstname;
                        document.querySelector('input[name="lastname"]').value = data.lastname;
                        document.querySelector('input[name="address"]').value = data.address;
                        document.querySelector('input[name="building"]').value = data.building;
                        document.querySelector('input[name="city"]').value = data.city;
                        document.querySelector('input[name="phone"]').value = data.phone;
                        document.querySelector('input[name="email"]').value = data.email;
                    } else {
                        console.error("Error from API:", data.error);
                        alert(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error fetching billing info:', error);
                });

            document.querySelector('.deliver-info-form form').addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);

                fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/update_billing_info.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.success || data.error);
                    })
                    .catch(error => {
                        console.error('Error updating billing info:', error);
                    });
            });
        });



        // document.addEventListener('DOMContentLoaded', function() {
        //     fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/fetch_billing_info.php')
        //         .then(response => response.json())
        //         .then(data => {
        //             if (!data.error) {
        //                 document.querySelector('input[name="firstname"]').value = data.firstname;
        //                 document.querySelector('input[name="lastname"]').value = data.lastname;
        //                 document.querySelector('input[name="address"]').value = data.address;
        //                 document.querySelector('input[name="building"]').value = data.building;
        //                 document.querySelector('input[name="city"]').value = data.city;
        //                 document.querySelector('input[name="phone"]').value = data.phone;
        //                 document.querySelector('input[name="email"]').value = data.email;
        //             } else {
        //                 alert(data.error);
        //             }
        //         });

        //     document.querySelector('.deliver-info-form form').addEventListener('submit', function(event) {
        //         event.preventDefault();
        //         const formData = new FormData(this);

        //         fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/update_billing_info.php', {
        //                 method: 'POST',
        //                 body: formData
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 alert(data.success || data.error);
        //             });
        //     });
        // });


        function toggleWishlist(event, productId) {
            event.preventDefault(); // Prevent the form from submitting normally
            const form = document.getElementById(`wishlist-form-${productId}`);
            const formData = new FormData(form);

            fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/deliver-info.php", { // Use the current page URL
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

            fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/deliver-info.php", { // Use the current page URL
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

        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
            updateWishlistCount();
        });
    </script>
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
</body>