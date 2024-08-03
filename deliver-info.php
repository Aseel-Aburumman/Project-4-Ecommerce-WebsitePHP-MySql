<?php
include 'connection.php';
session_start();

// Function to check if the user is signed in
function isUserSignedIn()
{
    return isset($_SESSION['user_id']);
}
// اكاونت من عبسي

$userPageUrl = isUserSignedIn() ? 'user-dashboard.php' : 'account (1).php';
$userPageUrlFavList = isUserSignedIn() ? 'wishlist.php' : 'fav-list.php';
$userPageUrlCart = isUserSignedIn() ? 'cart.php' : 'cart-Guest.php';

$query = 'SELECT * FROM products WHERE product_id < 5';
$result = $conn->query($query);

$popquery = 'SELECT * FROM products WHERE product_id > 5 AND product_id < 12';
$popresult = $conn->query($popquery);

$revsql = "SELECT reviews.comment, users.username FROM reviews JOIN users ON reviews.user_id = users.user_id";
$revresult = $conn->query($revsql);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = array();
    }
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if ($_POST['action'] == 'add_to_wishlist') {
        if (!in_array($product_id, $_SESSION['wishlist'])) {
            $_SESSION['wishlist'][] = $product_id;
        }
    } elseif ($_POST['action'] == 'remove_from_wishlist') {
        if (($key = array_search($product_id, $_SESSION['wishlist'])) !== false) {
            unset($_SESSION['wishlist'][$key]);
            $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
        }
    } elseif ($_POST['action'] == 'add_to_cart') {
        if (!in_array($product_id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $product_id;
        }
    } elseif ($_POST['action'] == 'remove_from_cart') {
        if (($key = array_search($product_id, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
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
    <title>Olog - deliver-Info</title>
    <link rel="stylesheet" href="dist/main.css">
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
                            <!-- <li><a class="active" href="index.php">Home</a></li> -->
                            <li><a href="shop.php?gender=Clothing">Clothing</a></li>
                            <li><a href="shop.php?gender=Footwear">Footwear</a></li>
                            <li><a href="shop.php?gender=Accessories">Accessories</a></li>
                            <li><a href="shop.php">Shop</a></li>
                            <li>
                                <a href="javascript:void(0)">Category
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                        <g id="Arrow" transform="translate(0.99 0.99)">
                                            <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                        </g>
                                    </svg>
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
                            <li><a href="javascript:void(0)">Sales</a></li>
                        </ul>

                        <div class="search-bar">
                            <input type="text" placeholder="Search for product..." id="searchInput" oninput="performSearch(this)"> <!-- //fdfdsfdsfdsf -->
                            <div id="suggestions"></div>
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414" viewBox="0 0 20.414 20.414">
                                    <g id="Search_Icon" data-name="Search Icon" transform="translate(1 1)">
                                        <ellipse id="Ellipse_1" data-name="Ellipse 1" cx="8.158" cy="8" rx="8.158" ry="8" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <line id="Line_4" data-name="Line 4" x1="3.569" y1="3.5" transform="translate(14.431 14.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                        </div>
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
                                    <a href="<?php echo $userPageUrl; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg></a>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                    <g id="Arrow" transform="translate(0.99 0.99)">
                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                    </g>
                                </svg>
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
                        <li><a href="javascript:void(0)">Sales</a></li>
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

    <!-- BreadCrumb Start-->
    <section class="breadcrumb-area mt-15">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
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
                            <li class="list-inline-item"><a href="account.php" class="mr-0">Log-out</a></li>
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
                    });
            });
        });


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
</body>