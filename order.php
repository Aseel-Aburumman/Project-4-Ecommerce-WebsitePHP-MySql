<?php
include 'connection.php';
session_start();

// Function to check if the user is signed in
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog -Order</title>
    <link rel="stylesheet" href="dist/main.css">
    <style>
        .btn-grey {
            background-color: grey;
            color: white;
            border: none;
            cursor: default;
        }

        .btn-green {
            background-color: green;
            color: white;
            border: none;
            cursor: default;
        }

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
                            <li class="breadcrumb-item active" aria-current="page">Order</li>
                        </ol>
                    </nav>
                    <h5>Order</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- BreadCrumb Start-->
    <main>
        <!-- Order Area Start -->
        <section class="order-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Dashboard-Nav  Start-->
                        <div class="dashboard-nav">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="user-dashboard.php">Account
                                        settings</a></li>
                                <li class="list-inline-item"><a href="deliver-info.php">Billing information</a></li>
                                <li class="list-inline-item"><a href="wishlist.php">My wishlist</a></li>
                                <li class="list-inline-item"><a href="cart.php">My cart</a></li>
                                <li class="list-inline-item"><a href="order.php" class="active">Order</a></li>
                                <li class="list-inline-item"><a href="/Project-4-Ecommerce-WebsitePHP-MySql/api/logout.php" class="mr-0">Log-out</a></li>
                            </ul>
                        </div>
                        <!-- Dashboard-Nav  End-->
                    </div>
                </div>
                <div class="rows">
                    <!-- Order Item Start -->
                    <div class="cart-items">
                        <div class="header">
                            <div class="image">
                                Image
                            </div>
                            <div class="name">
                                Name
                            </div>
                            <div class="price">
                                Prices
                            </div>
                            <div class="rating">
                                Rating
                            </div>
                            <div class="info">
                                Info
                            </div>
                        </div>
                        <div class="body">
                            <?php

                            $userId = $_SESSION['user_id'];
                            // $userId = $_SESSION[3];


                            // Fetch data from orders table for the signed-in user


                            $sqlOrderItems = "
                            SELECT oi.*, p.product_name, p.image, p.product_id, p.price, o.total, os.status_name, r.rating
                            FROM orderitems oi
                            JOIN products p ON oi.product_id = p.product_id
                            JOIN orders o ON oi.order_id = o.order_id
                            JOIN order_status os ON o.status_id = os.id
                            LEFT JOIN reviews r ON oi.product_id = r.product_id AND r.user_id = o.user_id
                            WHERE o.user_id = $userId
                        ";


                            $resultOrderItems = $conn->query($sqlOrderItems);
                            if ($resultOrderItems->num_rows > 0) {
                                while ($orderItem = $resultOrderItems->fetch_assoc()) {
                                    $statusStyle = '';
                                    if ($orderItem['status_name'] === 'pending') {
                                        $statusStyle = 'background-color: grey; color: white; border: none; cursor: default;width: 82%;';
                                    } elseif ($orderItem['status_name'] === 'accepted') {
                                        $statusStyle = 'background-color: #81d581; color: white; border: none; cursor: default;width: 82%;';
                                    } elseif ($orderItem['status_name'] === 'Rejected') {
                                        $statusStyle = 'background-color: #de1313; color: white; border: none; cursor: default;width: 82%;';
                                    }

                                    $rating = isset($orderItem['rating']) ? $orderItem['rating'] : 'No rating';

                                    echo '<div class="body">';
                                    echo '<div style="height:150px;" class="item">';
                                    echo '<div class="image">';
                                    echo '<img style="width: 400px;object-fit: cover;height:130px;" src="data:image/jpeg;base64,' . base64_encode($orderItem["image"]) . '">';
                                    echo '</div>';
                                    echo '<div class="name">';
                                    echo '<div class="name-text">';
                                    echo '<p>Product Name: ' . $orderItem["product_name"] . '</p>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<div class="price">';
                                    echo '<span>$' . $orderItem["price"] . '</span>';
                                    echo '</div>';
                                    echo '<div class="rating">';
                                    echo '<i class="fas fa-star"></i> ' . $rating;
                                    echo '</div>';
                                    echo '<div class="info status">';
                                    echo '<div class="name">';
                                    echo '<div style="display: flex;flex-direction:column;" class="button">';
                                    echo '<button style="margin-bottom: 5px;" type="button" class="btn bg-primary order-again" data-product-id="' . $orderItem['product_id'] . '">Order again</button>';
                                    echo '<button type="button" class="btn order_status" style="' . $statusStyle . '" disabled>' . $orderItem['status_name'] . '</button>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo "No order items found for the user.";
                            }





                            ?>

                        </div>
                    </div>
                    <!-- Order Item End -->
                </div>
            </div>
        </section>
        <!-- Order Area End -->
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

        document.addEventListener('DOMContentLoaded', function() {
            const statusButtons = document.querySelectorAll(".order_status");

            Array.from(statusButtons).forEach(button => {
                button.addEventListener("click", function() {
                    const statusName = this.dataset.statusName;
                    alert("Order Status: " + statusName);
                });
            });
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