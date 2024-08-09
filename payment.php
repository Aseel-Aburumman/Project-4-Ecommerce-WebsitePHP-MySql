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
    <title>Olog -Payment</title>
    <link rel="stylesheet" href="dist/main.css">
    <style>
        .error {
            color: red;
            font-size: 0.875em;
            margin-top: 0.25em;
            display: block;
        }

        .form__div {
            position: relative;
            margin-bottom: 1.5em;
        }

        .form__input {
            margin-bottom: 0.5em;
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
                            <li class="breadcrumb-item" aria-current="page">Cart</li>
                            <li class="breadcrumb-item" aria-current="page">Billing information</li>
                            <li class="breadcrumb-item" aria-current="page">Shipping</li>
                            <li class="breadcrumb-item" aria-current="page">Payment</li>
                        </ol>
                    </nav>
                    <h5>Payment</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- BreadCrumb Start-->
    <main>
        <!-- Payment Area Start -->
        <section class="payment-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Dashboard-Nav Starts Here -->
                        <div class="dashboard-nav">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="billing-information.php">Billing
                                        information</a>
                                    <i class="fas fa-angle-right"></i>
                                </li>
                                <li class="list-inline-item"><a href="shipping.php">Shipping</a> <i class="fas fa-angle-right"></i></li>
                                <li class="list-inline-item"><a href="payment.php" class="mr-0 active">Payment</a></li>
                            </ul>
                        </div>
                        <!-- Dashboard-Nav Ends Here -->
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="payment-area-payment">
                            <form id="payment_form">
                                <legend class="text-center">Express payment</legend>
                                <div style="justify-content: space-evenly;" class="payment-methods">
                                    <div class="methods">
                                        <div class="input">
                                            <input type="radio" name="payment-methods" id="paypal" checked>
                                        </div>
                                        <a href="https://www.paypal.com/jo/home" target="_blank" class="active">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="85.556" height="23.828" viewBox="0 0 85.556 23.828">
                                                <g id="Logo" transform="translate(0)">
                                                    <path id="Path_26" data-name="Path 26" d="M45.927,6.749H39.272a.938.938,0,0,0-.914.816L35.667,25.4a.6.6,0,0,0,.127.467.545.545,0,0,0,.422.2h3.177a.938.938,0,0,0,.914-.817l.726-4.81a.938.938,0,0,1,.913-.817h2.107c4.384,0,6.913-2.217,7.574-6.61a5.548,5.548,0,0,0-.848-4.49c-.946-1.161-2.623-1.776-4.851-1.776Zm.768,6.514c-.364,2.5-2.188,2.5-3.953,2.5h-1l.7-4.661a.563.563,0,0,1,.548-.489h.46c1.2,0,2.335,0,2.921.716a2.4,2.4,0,0,1,.323,1.938Zm19.124-.08H62.632a.563.563,0,0,0-.548.489l-.141.932-.223-.338c-.69-1.046-2.228-1.4-3.764-1.4-3.521,0-6.529,2.788-7.115,6.7a6.5,6.5,0,0,0,1.187,5.117,4.881,4.881,0,0,0,4.014,1.694,6,6,0,0,0,4.411-1.907l-.142.925a.6.6,0,0,0,.125.467.545.545,0,0,0,.421.2h2.87a.938.938,0,0,0,.914-.817l1.722-11.4a.6.6,0,0,0-.125-.466.543.543,0,0,0-.421-.2Zm-4.442,6.482a3.6,3.6,0,0,1-3.6,3.18,2.632,2.632,0,0,1-2.14-.9,2.93,2.93,0,0,1-.5-2.34A3.62,3.62,0,0,1,58.712,16.4a2.633,2.633,0,0,1,2.125.907,2.981,2.981,0,0,1,.539,2.356ZM82.79,13.183h-3.2a.918.918,0,0,0-.766.424l-4.417,6.8-1.872-6.534a.933.933,0,0,0-.887-.69H68.5a.548.548,0,0,0-.452.242.6.6,0,0,0-.074.525L71.5,24.768l-3.316,4.893a.6.6,0,0,0-.041.6.552.552,0,0,0,.493.314h3.2a.913.913,0,0,0,.76-.415L83.246,14.093a.6.6,0,0,0,.036-.6.552.552,0,0,0-.491-.311Z" transform="translate(-35.66 -6.748)" fill="#253b80" />
                                                    <path id="Path_27" data-name="Path 27" d="M94.708,6.749H88.052a.938.938,0,0,0-.913.816L84.448,25.4a.6.6,0,0,0,.126.466.544.544,0,0,0,.421.2H88.41a.657.657,0,0,0,.638-.572l.764-5.055a.938.938,0,0,1,.913-.817h2.106c4.385,0,6.913-2.217,7.575-6.61a5.544,5.544,0,0,0-.849-4.49c-.945-1.161-2.621-1.776-4.849-1.776Zm.768,6.514c-.363,2.5-2.187,2.5-3.953,2.5h-1l.705-4.661a.561.561,0,0,1,.547-.489h.46c1.2,0,2.335,0,2.921.716a2.4,2.4,0,0,1,.322,1.938Zm19.123-.08h-3.185a.56.56,0,0,0-.547.489l-.141.932-.224-.338c-.69-1.046-2.227-1.4-3.763-1.4-3.521,0-6.528,2.788-7.114,6.7a6.5,6.5,0,0,0,1.186,5.117,4.884,4.884,0,0,0,4.014,1.694,6,6,0,0,0,4.411-1.907l-.142.925a.6.6,0,0,0,.126.468.545.545,0,0,0,.423.2h2.869a.938.938,0,0,0,.913-.817l1.723-11.4a.6.6,0,0,0-.128-.467.546.546,0,0,0-.422-.2Zm-4.442,6.482a3.6,3.6,0,0,1-3.6,3.18,2.634,2.634,0,0,1-2.14-.9,2.937,2.937,0,0,1-.5-2.34,3.621,3.621,0,0,1,3.571-3.206,2.633,2.633,0,0,1,2.125.907A2.966,2.966,0,0,1,110.157,19.665Zm8.2-12.427L115.624,25.4a.6.6,0,0,0,.126.466.544.544,0,0,0,.421.2h2.746a.937.937,0,0,0,.914-.817l2.693-17.834a.6.6,0,0,0-.126-.467.545.545,0,0,0-.421-.2H118.9a.564.564,0,0,0-.547.49Z" transform="translate(-36.975 -6.748)" fill="#179bd7" />
                                                </g>
                                            </svg>
                                        </a>
                                    </div>

                                    <div class="methods">
                                        <div class="input">
                                            <input type="radio" name="payment-methods" id="apple-pay">
                                        </div>
                                        <a href="https://www.apple.com/jo-ar/apple-pay/" target="_blank">
                                            <svg id="Apple" xmlns="http://www.w3.org/2000/svg" width="66.418" height="27.232" viewBox="0 0 66.418 27.232">
                                                <path id="Path_35" data-name="Path 35" d="M12.574,3.711A5.243,5.243,0,0,0,13.733,0a5.214,5.214,0,0,0-3.367,1.743A4.943,4.943,0,0,0,9.151,5.285a3.935,3.935,0,0,0,3.422-1.574m1.159,1.912C11.856,5.51,10.255,6.69,9.372,6.69S7.109,5.678,5.618,5.678A5.526,5.526,0,0,0,.927,8.6C-1.061,12.144.375,17.373,2.362,20.24c.938,1.406,2.1,2.98,3.588,2.924,1.435-.056,1.987-.956,3.7-.956s2.208.956,3.753.9,2.539-1.406,3.478-2.867a11.424,11.424,0,0,0,1.546-3.261,5.136,5.136,0,0,1-.607-9.052,5.11,5.11,0,0,0-4.085-2.305" transform="translate(0.026)" />
                                                <path id="Path_36" data-name="Path 36" d="M47.938,2.9a6.624,6.624,0,0,1,6.9,6.972,6.7,6.7,0,0,1-7.01,7.028H43.357v7.253H40.1V2.9ZM43.357,14.144h3.7c2.815,0,4.416-1.574,4.416-4.217,0-2.7-1.6-4.217-4.416-4.217H43.3v8.433Zm12.309,5.678c0-2.7,2.042-4.385,5.685-4.61l4.2-.225V13.807c0-1.743-1.159-2.755-3.036-2.755-1.822,0-2.926.9-3.2,2.249H56.328c.166-2.811,2.539-4.891,6.293-4.891,3.7,0,6.072,1.968,6.072,5.116V24.208H65.712v-2.53h-.055a5.392,5.392,0,0,1-4.8,2.811C57.764,24.489,55.666,22.578,55.666,19.823Zm9.881-1.406V17.18l-3.753.225c-1.877.112-2.926.956-2.926,2.305s1.1,2.249,2.76,2.249A3.675,3.675,0,0,0,65.547,18.417Zm5.906,11.526V27.357a5.892,5.892,0,0,0,.994.056c1.435,0,2.208-.618,2.7-2.193,0-.056.276-.956.276-.956L69.907,8.747h3.367L77.138,21.4h.055l3.864-12.65h3.312L78.684,25.108c-1.325,3.767-2.815,4.948-5.961,4.948C72.5,30,71.729,30,71.453,29.943Z" transform="translate(-17.951 -2.823)" />

                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="payment-info">
                                    <div class="payment-area-info d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="credit-card-option">
                                            <input type="radio" name="payment-methods" id="card-option">
                                            <label for="card-option">Payment with your credit card</label>
                                        </div>
                                        <div class="credit-card">
                                            <a href="#">
                                                <svg id="masterclass" xmlns="http://www.w3.org/2000/svg" width="18.219" height="14.22" viewBox="0 0 18.219 14.22">
                                                    <path id="Path_87" data-name="Path 87" d="M120.475,1319.09v.037h.034a.036.036,0,0,0,.018,0,.016.016,0,0,0,.007-.014.016.016,0,0,0-.007-.014.033.033,0,0,0-.018,0h-.034Zm.034-.026a.064.064,0,0,1,.041.012.04.04,0,0,1,.014.032.037.037,0,0,1-.011.028.055.055,0,0,1-.033.014l.046.052h-.035l-.042-.052h-.014v.052h-.029v-.138h.064Zm-.009.186a.108.108,0,0,0,.045-.009.117.117,0,0,0,.061-.061.115.115,0,0,0-.025-.127.117.117,0,0,0-.036-.025.111.111,0,0,0-.045-.009.115.115,0,0,0-.083.033.118.118,0,0,0-.024.128.108.108,0,0,0,.024.037.118.118,0,0,0,.037.025.114.114,0,0,0,.046.009m0-.265a.152.152,0,0,1,.107.044.146.146,0,0,1,.032.047.148.148,0,0,1,0,.116.156.156,0,0,1-.032.047.165.165,0,0,1-.048.032.144.144,0,0,1-.059.012.148.148,0,0,1-.06-.012.157.157,0,0,1-.048-.032.155.155,0,0,1-.032-.049.15.15,0,0,1,.14-.207m-13.947-.532a.453.453,0,1,1,.454.48.449.449,0,0,1-.454-.48m1.21,0v-.75h-.325v.183a.566.566,0,0,0-.472-.22.789.789,0,0,0,0,1.575.566.566,0,0,0,.472-.22v.182h.325v-.75Zm10.984,0a.453.453,0,1,1,.454.48.449.449,0,0,1-.454-.48m1.211,0V1317.1h-.325v.785a.566.566,0,0,0-.472-.22.789.789,0,0,0,0,1.575.566.566,0,0,0,.472-.22v.182h.325Zm-8.16-.5a.372.372,0,0,1,.378.364H111.4a.386.386,0,0,1,.4-.364m.006-.292a.788.788,0,0,0,.022,1.575.905.905,0,0,0,.613-.21l-.159-.242a.711.711,0,0,1-.435.157.416.416,0,0,1-.447-.367h1.11c0-.04.006-.082.006-.125a.719.719,0,0,0-.71-.788m3.925.788a.453.453,0,1,1,.454.48.45.45,0,0,1-.454-.48m1.21,0v-.75h-.325v.183a.566.566,0,0,0-.472-.22.789.789,0,0,0,0,1.575.567.567,0,0,0,.472-.22v.182h.325v-.75Zm-3.046,0a.756.756,0,0,0,.8.788.781.781,0,0,0,.537-.179l-.156-.264a.656.656,0,0,1-.392.135.481.481,0,0,1,0-.96.657.657,0,0,1,.392.135l.156-.264a.781.781,0,0,0-.537-.179.756.756,0,0,0-.8.788m4.191-.788a.441.441,0,0,0-.394.22v-.182h-.322v1.5h.325v-.841c0-.248.106-.386.319-.386a.523.523,0,0,1,.2.038l.1-.308a.691.691,0,0,0-.232-.041m-8.714.157a1.116,1.116,0,0,0-.61-.157c-.379,0-.623.182-.623.48,0,.245.182.4.516.443l.154.022c.178.025.262.072.262.157,0,.116-.118.182-.341.182a.8.8,0,0,1-.5-.157l-.153.254a1.076,1.076,0,0,0,.647.195c.432,0,.682-.2.682-.49,0-.264-.2-.4-.522-.448l-.153-.022c-.141-.018-.253-.047-.253-.147s.106-.176.285-.176a.963.963,0,0,1,.466.128l.141-.264Zm4.195-.156a.44.44,0,0,0-.394.22v-.182h-.322v1.5h.325v-.841c0-.248.106-.386.319-.386a.522.522,0,0,1,.2.038l.1-.308a.691.691,0,0,0-.232-.041m-2.774.037h-.532v-.455h-.329v.455h-.3v.3h.3v.684c0,.348.135.555.519.555a.761.761,0,0,0,.407-.116l-.094-.279a.6.6,0,0,1-.288.085c-.162,0-.216-.1-.216-.251V1318h.532Zm-4.86,1.5v-.941a.558.558,0,0,0-.588-.6.578.578,0,0,0-.525.267.548.548,0,0,0-.494-.267.494.494,0,0,0-.438.223v-.186h-.325v1.5h.328v-.832a.351.351,0,0,1,.366-.4c.216,0,.325.141.325.4v.835h.329v-.832a.353.353,0,0,1,.366-.4c.222,0,.328.141.328.4v.835Z" transform="translate(-102.616 -1305.064)" fill="#231f20" />
                                                    <path id="Path_88" data-name="Path 88" d="M1929.324,977.439v-.219h-.057l-.066.151-.065-.151h-.057v.219h.04v-.165l.062.143h.042l.062-.143v.166h.04Zm-.361,0v-.182h.073v-.037h-.186v.037h.073v.182h.04Z" transform="translate(-1911.281 -968.29)" fill="#f79410" />
                                                    <path id="Path_89" data-name="Path 89" d="M734.636,141.032H729.71V132.15h4.926Z" transform="translate(-723.063 -130.942)" fill="#ff5f00" />
                                                    <path id="Path_90" data-name="Path 90" d="M6.959,5.648a5.646,5.646,0,0,1,2.15-4.441A5.626,5.626,0,0,0,0,5.648a5.626,5.626,0,0,0,9.109,4.441,5.646,5.646,0,0,1-2.15-4.441" transform="translate(0 0.001)" fill="#eb001b" />
                                                    <path id="Path_91" data-name="Path 91" d="M1009.22,5.648a5.627,5.627,0,0,1-9.11,4.441,5.66,5.66,0,0,0,0-8.882,5.627,5.627,0,0,1,9.11,4.441" transform="translate(-991 0.001)" fill="#f79e1b" />
                                                </svg>
                                            </a>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.885" height="7.999" viewBox="0 0 24.885 7.999">
                                                    <path id="Path_93" data-name="Path 93" d="M22.014,59.384H19.983l1.269-7.727h2.031Zm-3.739-7.727-1.936,5.315-.229-1.145h0l-.683-3.475a.866.866,0,0,0-.963-.7h-3.2l-.038.131a7.638,7.638,0,0,1,2.124.883l1.764,6.713H17.23l3.231-7.728Zm15.971,7.727h1.864l-1.626-7.728H32.853a.932.932,0,0,0-.937.576l-3.028,7.152H31l.423-1.148h2.581Zm-2.234-2.733,1.067-2.892.6,2.892Zm-2.966-3.136.29-1.659a5.908,5.908,0,0,0-1.826-.337c-1.008,0-3.4.436-3.4,2.558,0,2,2.809,2.021,2.809,3.07s-2.519.861-3.351.2l-.3,1.735a5.735,5.735,0,0,0,2.292.436c1.386,0,3.476-.711,3.476-2.646,0-2.009-2.834-2.2-2.834-3.07S28.177,53.041,29.046,53.515Z" transform="translate(-11.226 -51.519)" fill="#2566af" />
                                                    <path id="Path_94" data-name="Path 94" d="M16.44,56.639l-.729-3.71a.925.925,0,0,0-1.028-.743H11.266l-.04.14a8.434,8.434,0,0,1,3.217,1.6A6.43,6.43,0,0,1,16.44,56.639Z" transform="translate(-11.226 -52.039)" fill="#e6a540" />
                                                </svg>
                                            </a>
                                            <!-- <p>and more...</p> -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form__div">
                                                <input type="text" class="form__input" id="card-name" name="card_name" placeholder="">
                                                <label for="card-name" class="form__label">Name on Card</label>
                                                <p style="line-height: 44px;"><br> </p>
                                                <div class="error" id="card-name-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form__div">
                                                <input type="number" class="form__input" id="card-number" name="card_number" placeholder="">
                                                <label for="card-number" class="form__label">Card Number</label>
                                                <p style="line-height: 44px;"><br> </p>

                                                <div class="error" id="card-number-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form__div">
                                                <input type="text" class="form__input" id="exp-date" name="exp_date" placeholder="">
                                                <label for="exp-date" class="form__label">Expiration Date (MM / YY)</label>
                                                <p style="line-height: 44px;"><br> </p>

                                                <div class="error" id="exp-date-error"></div>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="col-lg-6">
                                            <div class="form__div">
                                                <input type="text" class="form__input" id="cvc" name="cvc" placeholder="">
                                                <label for="cvc" class="form__label">CVC</label>
                                                <p style="line-height: 44px;"><br> </p>

                                                <div class="error" id="cvc-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="on-delivery">
                            <input type="radio" name="payment-methods" id="on-delivery">
                            <label for="on-delivery">Cash on Delivery</label>
                        </div>

                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-between bottom flex-wrap">
                                <a href="shipping.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>
                                    Return to shipping
                                </a>
                                <button class="btn bg-primary mt-0" type="submit">Pay Now</button>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
            </div>
        </section>
        <!-- Payment Area End -->
    </main>
    <!-- Footer -->
    <?php
    include 'footer.php';
    ?>
    <!-- Footer -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- THE ABOVE IS A TEST -->
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
            const paymentForm = document.getElementById("payment_form");

            if (paymentForm) {
                paymentForm.addEventListener("submit", function(e) {
                    e.preventDefault();
                    if (validateForm()) {
                        const cardname = document.getElementById("card-name").value;
                        const card_number = document.getElementById("card-number").value;
                        const exp_date = document.getElementById("exp-date").value;
                        const cvc = document.getElementById("cvc").value;

                        fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/process_payment.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify({
                                    card_name: cardname,
                                    card_number: card_number,
                                    exp_date: exp_date,
                                    cvc: cvc
                                }),
                            })
                            .then((response) => response.text()) // Get the raw response text
                            .then((text) => {
                                console.log("Raw Response:", text); // Log the raw response

                                try {
                                    const data = JSON.parse(text);
                                    if (data.success) {
                                        alert("Payment successful");
                                        window.location.href = "order_success.php";
                                    } else {
                                        displayErrors(data.errors);
                                    }
                                } catch (error) {
                                    console.error("Response is not valid JSON:", text);
                                }
                            })
                            .catch((error) => {
                                console.error("Error:", error);
                            });
                    }
                });
            } else {
                console.error("Form with id 'payment_form' not found.");
            }

            function validateForm() {
                let isValid = true;

                // Validate Name on Card
                const cardName = document.getElementById('card-name').value.trim();
                if (cardName === '') {
                    document.getElementById('card-name-error').textContent = 'Name on card is required';
                    isValid = false;
                } else {
                    document.getElementById('card-name-error').textContent = '';
                }

                // Validate Card Number
                const cardNumber = document.getElementById('card-number').value.trim();
                const cardNumberRegex = /^\d{16}$/;
                if (!cardNumberRegex.test(cardNumber)) {
                    document.getElementById('card-number-error').textContent = 'Invalid card number';
                    isValid = false;
                } else {
                    document.getElementById('card-number-error').textContent = '';
                }

                // Validate Expiration Date
                const expDate = document.getElementById('exp-date').value.trim();
                const expDateRegex = /^(0[1-9]|1[0-2])\/?([0-9]{2})$/;
                if (!expDateRegex.test(expDate)) {
                    document.getElementById('exp-date-error').textContent = 'Invalid expiration date';
                    isValid = false;
                } else {
                    document.getElementById('exp-date-error').textContent = '';
                }

                // Validate CVC
                const cvc = document.getElementById('cvc').value.trim();
                const cvcRegex = /^[0-9]{3,4}$/;
                if (!cvcRegex.test(cvc)) {
                    document.getElementById('cvc-error').textContent = 'Invalid CVC';
                    isValid = false;
                } else {
                    document.getElementById('cvc-error').textContent = '';
                }

                return isValid;
            }

            function displayErrors(errors) {
                if (errors.card_name) {
                    document.getElementById('card-name-error').textContent = errors.card_name;
                }
                if (errors.card_number) {
                    document.getElementById('card-number-error').textContent = errors.card_number;
                }
                if (errors.exp_date) {
                    document.getElementById('exp-date-error').textContent = errors.exp_date;
                }
                if (errors.cvc) {
                    document.getElementById('cvc-error').textContent = errors.cvc;
                }
            }
        });

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