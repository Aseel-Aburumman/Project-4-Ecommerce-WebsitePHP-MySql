<?php
include 'connection.php';

session_start();


$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$coupon = isset($_SESSION['coupon']) ? $_SESSION['coupon'] : null;

// Handle quantity update via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] == 'update_quantity') {
        $product_id = $_POST['product_id'];
        $quantity = max(1, intval($_POST['quantity'])); // Ensure quantity is at least 1
        $_SESSION['cart_quantities'][$product_id] = $quantity;
        echo json_encode(['success' => true]);
        exit;
    } elseif ($_POST['action'] == 'remove_from_cart') {
        $product_id = $_POST['product_id'];
        if (($key = array_search($product_id, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            unset($_SESSION['cart_quantities'][$product_id]); // Remove the quantity as well
            // Re-index the array to maintain proper indexing
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
        echo json_encode(['success' => true]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog -Billing-Information</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Billing information</li>
                        </ol>
                    </nav>
                    <h5>Billing information</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- BreadCrumb Start-->
    <main>
        <!-- Billing Info Area Start -->
        <section class="billing-info-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Dashboard-Nav  Start-->
                        <div class="dashboard-nav">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="billing-information.php" class="active">Billing
                                        information</a>
                                    <i class="fas fa-angle-right"></i>
                                </li>
                                <li class="list-inline-item"><a href="shipping.php">Shipping</a> <i class="fas fa-angle-right"></i></li>
                                <li class="list-inline-item"><a href="payment.php" class="mr-0">Payment</a></li>
                            </ul>
                        </div>
                        <!-- Dashboard-Nav  End-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7 order-2 order-lg-1">
                        <div class="payment-method-area">
                            <h5>Available payment methods</h5>
                            <div style="justify-content: space-evenly;" class="payment-method d-flex justify-content-between align-items-center flex-wrap">
                                <div class="method">
                                    <a href="#">
                                        <svg id="Apple" xmlns="http://www.w3.org/2000/svg" width="66.418" height="27.232" viewBox="0 0 66.418 27.232">
                                            <path id="Path_35" data-name="Path 35" d="M12.574,3.711A5.243,5.243,0,0,0,13.733,0a5.214,5.214,0,0,0-3.367,1.743A4.943,4.943,0,0,0,9.151,5.285a3.935,3.935,0,0,0,3.422-1.574m1.159,1.912C11.856,5.51,10.255,6.69,9.372,6.69S7.109,5.678,5.618,5.678A5.526,5.526,0,0,0,.927,8.6C-1.061,12.144.375,17.373,2.362,20.24c.938,1.406,2.1,2.98,3.588,2.924,1.435-.056,1.987-.956,3.7-.956s2.208.956,3.753.9,2.539-1.406,3.478-2.867a11.424,11.424,0,0,0,1.546-3.261,5.136,5.136,0,0,1-.607-9.052,5.11,5.11,0,0,0-4.085-2.305" transform="translate(0.026)" />
                                            <path id="Path_36" data-name="Path 36" d="M47.938,2.9a6.624,6.624,0,0,1,6.9,6.972,6.7,6.7,0,0,1-7.01,7.028H43.357v7.253H40.1V2.9ZM43.357,14.144h3.7c2.815,0,4.416-1.574,4.416-4.217,0-2.7-1.6-4.217-4.416-4.217H43.3v8.433Zm12.309,5.678c0-2.7,2.042-4.385,5.685-4.61l4.2-.225V13.807c0-1.743-1.159-2.755-3.036-2.755-1.822,0-2.926.9-3.2,2.249H56.328c.166-2.811,2.539-4.891,6.293-4.891,3.7,0,6.072,1.968,6.072,5.116V24.208H65.712v-2.53h-.055a5.392,5.392,0,0,1-4.8,2.811C57.764,24.489,55.666,22.578,55.666,19.823Zm9.881-1.406V17.18l-3.753.225c-1.877.112-2.926.956-2.926,2.305s1.1,2.249,2.76,2.249A3.675,3.675,0,0,0,65.547,18.417Zm5.906,11.526V27.357a5.892,5.892,0,0,0,.994.056c1.435,0,2.208-.618,2.7-2.193,0-.056.276-.956.276-.956L69.907,8.747h3.367L77.138,21.4h.055l3.864-12.65h3.312L78.684,25.108c-1.325,3.767-2.815,4.948-5.961,4.948C72.5,30,71.729,30,71.453,29.943Z" transform="translate(-17.951 -2.823)" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="method">
                                    <a href="#">
                                        <svg id="masterclass" xmlns="http://www.w3.org/2000/svg" width="46.156" height="36.31" viewBox="0 0 46.156 36.31">
                                            <path id="Path_87" data-name="Path 87" d="M146.411,1322.182v.093h.086a.09.09,0,0,0,.046-.012.041.041,0,0,0,.017-.036.04.04,0,0,0-.017-.035.08.08,0,0,0-.046-.012h-.086Zm.087-.066a.159.159,0,0,1,.1.03.1.1,0,0,1,.036.083.094.094,0,0,1-.029.072.14.14,0,0,1-.083.035l.115.133h-.089l-.106-.132h-.034v.132h-.074v-.353h.162Zm-.023.475a.273.273,0,0,0,.113-.024.289.289,0,0,0,.092-.063.3.3,0,0,0,.063-.093.3.3,0,0,0-.062-.324.29.29,0,0,0-.092-.063.28.28,0,0,0-.113-.022.288.288,0,0,0-.21.085.3.3,0,0,0-.062.326.276.276,0,0,0,.062.093.291.291,0,0,0,.094.063.282.282,0,0,0,.115.023m0-.676a.384.384,0,0,1,.271.112.373.373,0,0,1,.082.121.38.38,0,0,1,0,.3.392.392,0,0,1-.082.121.4.4,0,0,1-.122.082.367.367,0,0,1-.149.03.376.376,0,0,1-.151-.03.364.364,0,0,1-.2-.207.379.379,0,0,1,0-.3.372.372,0,0,1,.082-.121.366.366,0,0,1,.123-.082.378.378,0,0,1,.151-.03m-35.333-1.359a1.148,1.148,0,1,1,1.149,1.226,1.144,1.144,0,0,1-1.149-1.226m3.066,0v-1.916h-.824v.467a1.429,1.429,0,0,0-1.2-.561,2.015,2.015,0,0,0,0,4.022,1.43,1.43,0,0,0,1.2-.561v.465h.823v-1.916Zm27.826,0a1.148,1.148,0,1,1,1.149,1.226,1.144,1.144,0,0,1-1.149-1.226m3.067,0V1317.1h-.824v2a1.429,1.429,0,0,0-1.2-.561,2.015,2.015,0,0,0,0,4.022,1.43,1.43,0,0,0,1.2-.561v.465h.824Zm-20.672-1.266a.945.945,0,0,1,.959.929h-1.965a.98.98,0,0,1,1.007-.929m.016-.746a2.014,2.014,0,0,0,.055,4.022,2.283,2.283,0,0,0,1.552-.537l-.4-.617a1.793,1.793,0,0,1-1.1.4,1.055,1.055,0,0,1-1.133-.938h2.812c.008-.1.016-.208.016-.32a1.829,1.829,0,0,0-1.8-2.011m9.943,2.011a1.148,1.148,0,1,1,1.149,1.226,1.144,1.144,0,0,1-1.149-1.226m3.066,0v-1.914h-.823v.467a1.43,1.43,0,0,0-1.2-.561,2.015,2.015,0,0,0,0,4.022,1.431,1.431,0,0,0,1.2-.561v.465h.823v-1.916Zm-7.717,0a1.924,1.924,0,0,0,2.02,2.011,1.965,1.965,0,0,0,1.361-.457l-.4-.673a1.652,1.652,0,0,1-.992.345,1.229,1.229,0,0,1,0-2.452,1.657,1.657,0,0,1,.992.345l.4-.673a1.968,1.968,0,0,0-1.361-.457,1.924,1.924,0,0,0-2.02,2.011m10.617-2.011a1.116,1.116,0,0,0-1,.561v-.464h-.816v3.83h.824v-2.147c0-.634.269-.986.808-.986a1.321,1.321,0,0,1,.515.1l.254-.785a1.734,1.734,0,0,0-.587-.1m-22.074.4a2.807,2.807,0,0,0-1.544-.4c-.959,0-1.577.465-1.577,1.226,0,.625.46,1.01,1.307,1.13l.389.056c.452.064.665.184.665.4,0,.3-.3.465-.863.465a2,2,0,0,1-1.26-.4l-.387.649a2.709,2.709,0,0,0,1.64.5c1.094,0,1.728-.521,1.728-1.25,0-.673-.5-1.025-1.323-1.145l-.388-.057c-.357-.047-.642-.119-.642-.376,0-.28.269-.449.721-.449a2.423,2.423,0,0,1,1.181.328l.357-.673Zm10.626-.4a1.113,1.113,0,0,0-1,.561v-.466h-.816v3.83h.824v-2.147c0-.634.269-.986.808-.986a1.321,1.321,0,0,1,.515.1l.254-.785a1.735,1.735,0,0,0-.587-.1m-7.027.1h-1.347v-1.162H119.7v1.162h-.768v.761h.768v1.747c0,.888.341,1.418,1.315,1.418a1.919,1.919,0,0,0,1.03-.3l-.238-.713a1.512,1.512,0,0,1-.729.217c-.412,0-.546-.257-.546-.641v-1.73h1.347Zm-12.312,3.83v-2.4a1.419,1.419,0,0,0-1.49-1.522,1.461,1.461,0,0,0-1.331.682,1.387,1.387,0,0,0-1.252-.682,1.248,1.248,0,0,0-1.109.569v-.474h-.824v3.83h.831v-2.123a.892.892,0,0,1,.928-1.018c.547,0,.824.361.824,1.01v2.131h.833v-2.124a.9.9,0,0,1,.927-1.018c.562,0,.831.36.831,1.009v2.131Z" transform="translate(-101.17 -1286.368)" fill="#231f20" />
                                            <path id="Path_88" data-name="Path 88" d="M1930.052,977.78v-.56h-.144l-.167.384-.166-.384h-.145v.56h.1v-.422l.156.364h.106l.156-.365v.423h.1Zm-.915,0v-.464h.184v-.094h-.472v.094h.185v.464h.1Z" transform="translate(-1884.342 -954.418)" fill="#f79410" />
                                            <path id="Path_89" data-name="Path 89" d="M742.19,154.83H729.71V132.15h12.48Z" transform="translate(-712.872 -129.067)" fill="#ff5f00" />
                                            <path id="Path_90" data-name="Path 90" d="M17.629,14.423a14.458,14.458,0,0,1,5.447-11.34A14.1,14.1,0,0,0,14.262,0,14.343,14.343,0,0,0,0,14.423,14.343,14.343,0,0,0,14.262,28.847a14.1,14.1,0,0,0,8.815-3.084,14.458,14.458,0,0,1-5.448-11.34" transform="translate(0 0.001)" fill="#eb001b" />
                                            <path id="Path_91" data-name="Path 91" d="M1023.188,14.423a14.343,14.343,0,0,1-14.262,14.424,14.106,14.106,0,0,1-8.816-3.084,14.525,14.525,0,0,0,0-22.68A14.107,14.107,0,0,1,1008.925,0a14.344,14.344,0,0,1,14.262,14.424" transform="translate(-977.032 0.001)" fill="#f79e1b" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="method">
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="85.556" height="23.828" viewBox="0 0 85.556 23.828">
                                            <g id="Logo" transform="translate(0)">
                                                <path id="Path_26" data-name="Path 26" d="M45.927,6.749H39.272a.938.938,0,0,0-.914.816L35.667,25.4a.6.6,0,0,0,.127.467.545.545,0,0,0,.422.2h3.177a.938.938,0,0,0,.914-.817l.726-4.81a.938.938,0,0,1,.913-.817h2.107c4.384,0,6.913-2.217,7.574-6.61a5.548,5.548,0,0,0-.848-4.49c-.946-1.161-2.623-1.776-4.851-1.776Zm.768,6.514c-.364,2.5-2.188,2.5-3.953,2.5h-1l.7-4.661a.563.563,0,0,1,.548-.489h.46c1.2,0,2.335,0,2.921.716a2.4,2.4,0,0,1,.323,1.938Zm19.124-.08H62.632a.563.563,0,0,0-.548.489l-.141.932-.223-.338c-.69-1.046-2.228-1.4-3.764-1.4-3.521,0-6.529,2.788-7.115,6.7a6.5,6.5,0,0,0,1.187,5.117,4.881,4.881,0,0,0,4.014,1.694,6,6,0,0,0,4.411-1.907l-.142.925a.6.6,0,0,0,.125.467.545.545,0,0,0,.421.2h2.87a.938.938,0,0,0,.914-.817l1.722-11.4a.6.6,0,0,0-.125-.466.543.543,0,0,0-.421-.2Zm-4.442,6.482a3.6,3.6,0,0,1-3.6,3.18,2.632,2.632,0,0,1-2.14-.9,2.93,2.93,0,0,1-.5-2.34A3.62,3.62,0,0,1,58.712,16.4a2.633,2.633,0,0,1,2.125.907,2.981,2.981,0,0,1,.539,2.356ZM82.79,13.183h-3.2a.918.918,0,0,0-.766.424l-4.417,6.8-1.872-6.534a.933.933,0,0,0-.887-.69H68.5a.548.548,0,0,0-.452.242.6.6,0,0,0-.074.525L71.5,24.768l-3.316,4.893a.6.6,0,0,0-.041.6.552.552,0,0,0,.493.314h3.2a.913.913,0,0,0,.76-.415L83.246,14.093a.6.6,0,0,0,.036-.6.552.552,0,0,0-.491-.311Z" transform="translate(-35.66 -6.748)" fill="#253b80" />
                                                <path id="Path_27" data-name="Path 27" d="M94.708,6.749H88.052a.938.938,0,0,0-.913.816L84.448,25.4a.6.6,0,0,0,.126.466.544.544,0,0,0,.421.2H88.41a.657.657,0,0,0,.638-.572l.764-5.055a.938.938,0,0,1,.913-.817h2.106c4.385,0,6.913-2.217,7.575-6.61a5.544,5.544,0,0,0-.849-4.49c-.945-1.161-2.621-1.776-4.849-1.776Zm.768,6.514c-.363,2.5-2.187,2.5-3.953,2.5h-1l.705-4.661a.561.561,0,0,1,.547-.489h.46c1.2,0,2.335,0,2.921.716a2.4,2.4,0,0,1,.322,1.938Zm19.123-.08h-3.185a.56.56,0,0,0-.547.489l-.141.932-.224-.338c-.69-1.046-2.227-1.4-3.763-1.4-3.521,0-6.528,2.788-7.114,6.7a6.5,6.5,0,0,0,1.186,5.117,4.884,4.884,0,0,0,4.014,1.694,6,6,0,0,0,4.411-1.907l-.142.925a.6.6,0,0,0,.126.468.545.545,0,0,0,.423.2h2.869a.938.938,0,0,0,.913-.817l1.723-11.4a.6.6,0,0,0-.128-.467.546.546,0,0,0-.422-.2Zm-4.442,6.482a3.6,3.6,0,0,1-3.6,3.18,2.634,2.634,0,0,1-2.14-.9,2.937,2.937,0,0,1-.5-2.34,3.621,3.621,0,0,1,3.571-3.206,2.633,2.633,0,0,1,2.125.907A2.966,2.966,0,0,1,110.157,19.665Zm8.2-12.427L115.624,25.4a.6.6,0,0,0,.126.466.544.544,0,0,0,.421.2h2.746a.937.937,0,0,0,.914-.817l2.693-17.834a.6.6,0,0,0-.126-.467.545.545,0,0,0-.421-.2H118.9a.564.564,0,0,0-.547.49Z" transform="translate(-36.975 -6.748)" fill="#179bd7" />
                                            </g>
                                        </svg>
                                    </a>
                                </div>

                            </div>
                            <div class="payment-method-area-text text-center">
                                <p>or</p>
                                <h6>Cash on Delivery</h6>
                            </div>
                        </div>
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
                                <div class="row">
                                    <div class="col-12 d-flex align-items-center justify-content-between bottom flex-wrap">
                                        <a href="shipping.php">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                                                <polyline points="15 18 9 12 15 6"></polyline>
                                            </svg>
                                            Return to cart</a>
                                        <button class="btn bg-primary mt-0" type="submit">Continue</button>
                                    </div>
                                </div>
                            </form>
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
            </div>
        </section>
        <!-- Billing Info Area End -->
    </main>
    <!-- Footer -->
    <?php
    include 'footer.php';
    ?>
    <!-- Footer -->


    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script src="src/scss/vendors/plugin/js/jquery.nice-select.min.js"></script>
    <script src="path/to/jquery.exzoom.js"></script>

    <script src="dist/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

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
                    if (!data.error) {
                        document.querySelector('input[name="firstname"]').value = data.firstname;
                        document.querySelector('input[name="lastname"]').value = data.lastname;
                        document.querySelector('input[name="address"]').value = data.address;
                        document.querySelector('input[name="building"]').value = data.building;
                        document.querySelector('input[name="city"]').value = data.city;
                        document.querySelector('input[name="phone"]').value = data.phone;
                        document.querySelector('input[name="email"]').value = data.email;
                    } else {
                        alert(data.error);
                    }
                });

            fetch('http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/api/update_billing_info.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        window.location.href = 'shipping.php';
                    }
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                    alert('Failed to update billing information. Please try again.');
                });

        });








        // Call updateCartCount on page load to set the initial cart count
        document.addEventListener('DOMContentLoaded', updateCartCount);

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