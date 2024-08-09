<?php
include 'connection.php';

session_start();



$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$coupon = isset($_SESSION['coupon']) ? $_SESSION['coupon'] : null;

// Handle quantity update via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $productId = $_POST['product_id'];

    if ($action == 'update_quantity') {
        $quantity = $_POST['quantity'];

        if (isset($_SESSION['cart_quantities'][$productId])) {
            $_SESSION['cart_quantities'][$productId] = $quantity;
        } else {
            $_SESSION['cart'][] = $productId;
            $_SESSION['cart_quantities'][$productId] = $quantity;
        }
    } elseif ($action == 'remove_from_cart') {
        if (($key = array_search($productId, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            unset($_SESSION['cart_quantities'][$productId]);
        }
    }

    // Return a JSON response
    echo json_encode(['success' => true]);
    exit;
}

// Fetch user data
$user_id = $_SESSION['user_id'];
// $user_id = $_SESSION['3'];

$userQuery = $conn->prepare("SELECT username, Full_name, email FROM users WHERE user_id = ?");
$userQuery->bind_param('i', $user_id);
// $userQuery->bind_param('i', '3');

$userQuery->execute();
$userResult = $userQuery->get_result();
$userData = $userResult->fetch_assoc();

$userQuery2 = $conn->prepare("SELECT address, building, city, phone FROM billing_information WHERE user_id = ?");
$userQuery2->bind_param('i', $user_id);
// $userQuery->bind_param('i', '3');

$userQuery2->execute();
$userResult2 = $userQuery2->get_result();
$userData2 = $userResult2->fetch_assoc();


$email = $userData['email'];
$phone = $userData2['phone'] ? $userData2['phone'] : '<span style="color: red;">Please complete your profile</span>';
$address = $userData2['building'] . ', ' . $userData2['address'];
$city = $userData2['city'];

$userQuery->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog Shipping-Information</title>
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
                            <li class="breadcrumb-item" aria-current="page">Cart</li>
                            <li class="breadcrumb-item" aria-current="page">Billing information</li>
                            <li class="breadcrumb-item active" aria-current="page">Shipping</li>
                        </ol>
                    </nav>
                    <h5>Shipping</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- BreadCrumb Start-->

    <!-- Shipping Area Start -->
    <section class="shipping-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Dashboard-Nav  Start-->
                    <div class="dashboard-nav">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="billing-information.php">Billing
                                    information</a>
                                <i class="fas fa-angle-right"></i>
                            </li>
                            <li class="list-inline-item"><a href="shipping.php" class="active">Shipping</a> <i class="fas fa-angle-right"></i></li>
                            <li class="list-inline-item"><a href="payment.php" class="mr-0">Payment</a></li>
                        </ul>
                    </div>
                    <!-- Dashboard-Nav  End-->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 order-2 order-lg-1">
                    <div class="shipping-info-form">
                        <div class="shipping-info-form-text">
                            <h6>Your information</h6>
                            <div class="shipping-info mod">
                                <div class="shipping-info-text">
                                    <div class="left">
                                        <span>Contact:</span>
                                    </div>
                                    <div class="right mar-5">
                                        <p> <?php echo $email;  ?></p>
                                        <p><?php echo $phone;  ?></p>
                                    </div>
                                </div>
                                <div class="shipping-info-button">
                                    <form action="#">
                                        <button type="submit"><a href="deliver-info.php">Change</a></button>
                                    </form>
                                </div>
                            </div>
                            <div class="shipping-info mod">
                                <div class="shipping-info-text">
                                    <div class="left">
                                        <span>Ship to:</span>
                                    </div>
                                    <div class="right mar-5">
                                        <p> <?php echo $address;  ?> </p>
                                        <p><?php echo $city;  ?></p>
                                    </div>
                                </div>
                                <div class="shipping-info-button">
                                    <form action="#">
                                        <button type="submit"><a href="billing-information.php">Change</a></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <h6>Shipping method</h6>
                            <form action="#">
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <div class="select-button">
                                            <div class="button-area">
                                                <div class="radio-button">
                                                    <input type="radio" name="shipping" id="shippingMethod">
                                                </div>
                                                <div class="text-area">
                                                    <p>Fast Shipping (Delivered in 8-12 days, includes 3-4 days for
                                                        processing)</p>
                                                </div>
                                            </div>
                                            <div class="select-button-text">
                                                <span>1 JD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="select-button modifier">
                                            <div class="button-area">
                                                <div class="radio-button">
                                                    <input type="radio" name="shipping" id="shippingMethod">
                                                </div>
                                                <div class="text-area">
                                                    <p>
                                                        Faster Shipping (Delivered in 4-6 days, includes 2 days for
                                                        processing)
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="select-button-text">
                                                <span>2 JD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="select-button">
                                            <div class="button-area">
                                                <div class="radio-button">
                                                    <input type="radio" name="shipping" id="shippingMethod" checked>
                                                </div>
                                                <div class="text-area">
                                                    <p>Fastest Shipping (Delivered in 2-3 days, includes 1 days for
                                                        processing)</p>
                                                </div>
                                            </div>
                                            <div class="select-button-text">
                                                <span>3 JD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex align-items-center justify-content-between bottom flex-wrap">
                                        <a href="billing-information.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                                                <polyline points="15 18 9 12 15 6"></polyline>
                                            </svg>
                                            Return to Billing information</a>
                                        <button class="btn bg-primary mt-0" type="submit"><a href="payment.php">Continue</a></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2">
                    <div class="card-price">
                        <h6>Check Summary</h6>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p id="item-count">0 items</p>
                            </div>
                            <div class="price">
                                <p id="item-total-price">JD0.00</p>
                            </div>
                        </div>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p>Shipping Cost</p>
                            </div>
                            <div class="price">
                                <p id="shipping-cost">JD3.00</p>
                            </div>
                        </div>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p>Discount</p>
                            </div>
                            <div class="price">
                                <p id="discount">0%</p>
                            </div>
                        </div>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p>Taxes</p>
                            </div>
                            <div class="price">
                                <p id="taxes">JD0.00</p>
                            </div>
                        </div>
                        <div class="card-price-subtotal d-flex justify-content-between align-items-center">
                            <div class="total-text">
                                <p>Total Price</p>
                            </div>
                            <div class="total-price">
                                <p id="total-price">JD0.00</p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-price">
                        <h6>Check Summary</h6>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p id="item-count">0 items</p>
                            </div>
                            <div class="price">
                                <p id="item-total-price">JD0.00</p>
                            </div>
                        </div>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p>Shipping Cost</p>
                            </div>
                            <div class="price">
                                <p id="shipping-cost">JD3.00</p>
                            </div>
                        </div>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p>Discount</p>
                            </div>
                            <div class="price">
                                <p id="discount">0%</p>
                            </div>
                        </div>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p>Taxes</p>
                            </div>
                            <div class="price">
                                <p id="taxes">JD0.00</p>
                            </div>
                        </div>
                        <div class="card-price-subtotal d-flex justify-content-between align-items-center">
                            <div class="total-text">
                                <p>Total Price</p>
                            </div>
                            <div class="total-price">
                                <p id="total-price">JD0.00</p>
                            </div>
                        </div>

                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- Shipping Area End -->

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


        // the cart coupon funcitionality
        function updateCardPrice() {
            fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/get_cart_summary.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('item-count').innerText = data.itemCount + ' items';
                    document.getElementById('item-total-price').innerText = 'JD' + data.itemTotalPrice.toFixed(2);
                    document.getElementById('discount').innerText = data.discount + '%';
                    document.getElementById('taxes').innerText = 'JD' + data.taxes.toFixed(2);
                    document.getElementById('total-price').innerText = 'JD' + data.totalPrice.toFixed(2);
                });
        }

        // Call updateCardPrice initially to populate data
        updateCardPrice();

        document.getElementById('coupon-form').onsubmit = async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const response = await fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/applyCoupon.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            document.getElementById('coupon-message').innerHTML = result.message;
            if (result.success) {
                document.getElementById('coupon-message').classList.add('success');
            } else {
                document.getElementById('coupon-message').classList.add('error');
            }
            updateCardPrice();
        }

        function updateQuantity(productId, delta, quantity = null) {
            const itemElement = document.querySelector(`.item[data-product-id="${productId}"]`);
            const quantityInput = itemElement.querySelector('.quantity-input');
            let currentQuantity = parseInt(quantityInput.value);
            if (quantity === null) {
                currentQuantity = Math.max(1, currentQuantity + delta);
            } else {
                currentQuantity = Math.max(1, parseInt(quantity));
            }
            quantityInput.value = currentQuantity;

            const unitPriceElement = itemElement.querySelector('.unit-price');
            const totalPriceElement = itemElement.querySelector('.total-price');
            const unitPrice = parseFloat(unitPriceElement.textContent.replace('JD', ''));
            const totalPrice = (unitPrice * currentQuantity).toFixed(2);
            totalPriceElement.textContent = 'JD' + totalPrice;

            // Update quantity in session via AJAX
            const formData = new FormData();
            formData.append('action', 'update_quantity');
            formData.append('product_id', productId);
            formData.append('quantity', currentQuantity);

            fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/cart.php", { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount();
                        updateCardPrice(); // Update the card price summary
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function removeFromCart(event, productId) {
            event.preventDefault();
            const itemElement = document.querySelector(`.item[data-product-id="${productId}"]`);

            // Remove item from session via AJAX
            const formData = new FormData();
            formData.append('action', 'remove_from_cart');
            formData.append('product_id', productId);

            fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/cart-Guest.php", { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        itemElement.remove();
                        updateCartCount();
                        updateCardPrice(); // Update the card price summary
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>