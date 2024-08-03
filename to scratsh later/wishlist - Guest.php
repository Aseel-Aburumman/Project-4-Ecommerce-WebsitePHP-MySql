<?php
include 'connection.php';

session_start();

// Function to check if the user is signed in
function isUserSignedIn()
{
    return isset($_SESSION['user_id']);
}

$userPageUrl = isUserSignedIn() ? 'user-dashboard.php' : 'account.php';
$userPageUrlFavList = isUserSignedIn() ? 'wishlist.php' : 'fav-list.php';
$userPageUrlCart = isUserSignedIn() ? 'cart.php' : 'fav-list.php';

$wishlistItems = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : [];

// Handle add to cart via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_to_cart') {
        $product_id = $_POST['product_id'];
        if (!in_array($product_id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $product_id;
            $_SESSION['cart_quantities'][$product_id] = 1;
        }
        echo json_encode(['success' => true]);
        exit;
    } elseif ($_POST['action'] == 'remove_from_wishlist') {
        $product_id = $_POST['product_id'];
        if (($key = array_search($product_id, $_SESSION['wishlist'])) !== false) {
            unset($_SESSION['wishlist'][$key]);
            // Re-index the array to maintain proper indexing
            $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
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
    <title>Olog -Wishlist</title>
    <link rel="stylesheet" href="dist/main.css">
    <link rel="stylesheet" href="dist/aseel.css">
    <style>
        .thingstothinkabout {
            /* visibility: hidden; */
            display: none;

        }

        .quantity {
            text-align: center;
        }
    </style>
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
                            <li><a class="active" href="index.php">Home</a></li>
                            <li><a href="shop.html">Men</a></li>
                            <li><a href="shop.html">Women</a></li>
                            <li><a href="shop.html">Shop</a></li>
                            <li>
                                <a href="javascript:void(0)">Category
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                        <g id="Arrow" transform="translate(0.99 0.99)">
                                            <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                        </g>
                                    </svg>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="javascript:void(0)">Category 1</a></li>
                                    <li><a href="javascript:void(0)">Category 2</a></li>
                                    <li><a href="javascript:void(0)">Category 3</a></li>
                                    <li><a href="javascript:void(0)">Category 4</a></li>
                                    <li><a href="javascript:void(0)">Category 5</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0)">Sales</a></li>
                        </ul>
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="shop.html">Men</a></li>
                        <li><a href="shop.html">Women</a></li>
                        <li><a href="shop.html">Shop</a></li>
                        <li>
                            <a href="javascript:void(0)">Category
                                <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                    <g id="Arrow" transform="translate(0.99 0.99)">
                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                    </g>
                                </svg>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="javascript:void(0)">Category 1</a></li>
                                <li><a href="javascript:void(0)">Category 2</a></li>
                                <li><a href="javascript:void(0)">Category 3</a></li>
                                <li><a href="javascript:void(0)">Category 4</a></li>
                                <li><a href="javascript:void(0)">Category 5</a></li>
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
                                <li> <a href="wishlist - Guest.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20">
                                            <g id="Heart" transform="translate(1 1)">
                                                <path id="Heart-2" data-name="Heart" d="M20.007,4.59a5.148,5.148,0,0,0-7.444,0L11.548,5.636,10.534,4.59a5.149,5.149,0,0,0-7.444,0,5.555,5.555,0,0,0,0,7.681L4.1,13.317,11.548,21l7.444-7.681,1.014-1.047a5.553,5.553,0,0,0,0-7.681Z" transform="translate(-1.549 -2.998)" fill="#fff" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="heart">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="cart.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                            <g id="Icon" transform="translate(-1524 -89)">
                                                <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1531.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.909" cy="0.952" rx="0.909" ry="0.952" transform="translate(1541.364 108.095)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <path id="Path_3" data-name="Path 3" d="M1,1H4.636L7.073,13.752a1.84,1.84,0,0,0,1.818,1.533h8.836a1.84,1.84,0,0,0,1.818-1.533L21,5.762H5.545" transform="translate(1524 89)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                        <span class="cart">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="account.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg>
                                    </a>
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
                            <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                        </ol>
                    </nav>
                    <h5>Wishlist</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- BreadCrumb End-->

    <!-- Wishlist Area Start -->
    <section class="wishlist-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Dashboard-Nav  Start-->
                    <div class="dashboard-nav">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="wishlist - Guest.html" class="active">My wishlist</a></li>
                            <li class="list-inline-item"><a href="cart-Guest.php">My cart</a></li>

                        </ul>
                    </div>
                    <!-- Dashboard-Nav  End-->
                </div>
            </div>
            <div class="rows">
                <!-- Wishlist Item Start -->

                <div class="cart-items">
                    <div class="header">
                        <div class="image">Image</div>
                        <div class="name">Name</div>
                        <div class="price">Prices</div>
                        <div class="action">Action</div>
                    </div>
                    <div class="body">
                        <?php
                        if (count($wishlistItems) > 0) {
                            $wishlistIds = implode(',', $wishlistItems);
                            $wishlistQuery = "SELECT * FROM products WHERE product_id IN ($wishlistIds)";
                            $result = $conn->query($wishlistQuery);

                            if ($result && $result->num_rows > 0) {
                                while ($product = $result->fetch_assoc()) {
                                    $product_id = $product['product_id'];
                        ?>
                                    <div class="item" data-product-id="<?php echo $product_id; ?>">
                                        <div class="image">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo $product['product_name']; ?>">
                                        </div>
                                        <div class="name">
                                            <div class="name-text">
                                                <p><?php echo $product['product_name']; ?></p>

                                            </div>
                                            <div class="button">
                                                <div class="product-pricelist-selector-button">
                                                    <form method="post" style="display:inline;" onsubmit="return addToCart(event, <?php echo $product_id; ?>)">
                                                        <input type="hidden" name="action" value="add_to_cart">
                                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                        <button type="submit" class="btn cart-bg">Add to cart
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                                                <g id="Your_Bag" data-name="Your Bag" transform="translate(1)">
                                                                    <g id="Icon" transform="translate(0 1)">
                                                                        <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                        <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                        <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <iframe name="cart-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>

                                                    <form method="post" style="display:inline;" onsubmit="return removeFromWishlist(event, <?php echo $product_id; ?>)">
                                                        <input type="hidden" name="action" value="remove_from_wishlist">
                                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                        <button type="submit" style="display:inline;" class="btn btn-remove">Remove</button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="price">
                                            <span><?php echo '$' . number_format($product['price'], 2); ?></span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i> 5.0
                                        </div>

                                        <div class="info">
                                            <div class="size">
                                                <div class="product-pricelist-selector-size">
                                                    <h6>Sizes</h6>
                                                    <div class="sizes" id="sizes">
                                                        <li class="sizes-all active">M</li>
                                                    </div>
                                                </div>
                                                <div class="product-pricelist-selector-color">
                                                    <h6>Colors</h6>
                                                    <div class="colors" id="colors">
                                                        <li class="colorall color-1 active"></li>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                        <?php
                                }
                            } else {
                                echo "<p>Your wishlist is empty.</p>";
                            }
                        } else {
                            echo "<p>Your wishlist is empty.</p>";
                        }
                        ?>
                    </div>
                </div>

                <!-- نسخة الريموف
                
                <div class="cart-items">
                    <div class="header">
                        <div class="image">Image</div>
                        <div class="name">Name</div>
                        <div class="price">Prices</div>
                        <div class="action">Action</div>
                    </div>
                    <div class="body">
                        <?php
                        if (count($wishlistItems) > 0) {
                            $wishlistIds = implode(',', $wishlistItems);
                            $wishlistQuery = "SELECT * FROM products WHERE product_id IN ($wishlistIds)";
                            $result = $conn->query($wishlistQuery);

                            if ($result && $result->num_rows > 0) {
                                while ($product = $result->fetch_assoc()) {
                                    $product_id = $product['product_id'];
                        ?>
                                    <div class="item" data-product-id="<?php echo $product_id; ?>">
                                        <div class="image">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo $product['product_name']; ?>">
                                        </div>
                                        <div class="name">
                                            <div class="name-text">
                                                <p><?php echo $product['product_name']; ?></p>

                                            </div>
                                            <div class="button">
                                                <div class="product-pricelist-selector-button">
                                                    <form method="post" action="cartAction.php" target="cart-frame-<?php echo $product['product_id']; ?>" style="display:inline;">
                                                        <input type="hidden" name="action" value="add_to_cart">
                                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                        <button type="submit" class="btn cart-bg">Add to cart
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                                                <g id="Your_Bag" data-name="Your Bag" transform="translate(1)">
                                                                    <g id="Icon" transform="translate(0 1)">
                                                                        <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                        <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                        <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <iframe name="cart-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>

                                                    <form method="post" style="display:inline;" onsubmit="return removeFromWishlist(event, <?php echo $product_id; ?>)">
                                                        <input type="hidden" name="action" value="remove_from_wishlist">
                                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                        <button type="submit" style="display:inline;" class="btn btn-remove">Remove</button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="price">
                                            <span><?php echo '$' . number_format($product['price'], 2); ?></span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i> 5.0
                                        </div>

                                        <div class="info">
                                            <div class="size">
                                                <div class="product-pricelist-selector-size">
                                                    <h6>Sizes</h6>
                                                    <div class="sizes" id="sizes">
                                                        <li class="sizes-all active">M</li>
                                                    </div>
                                                </div>
                                                <div class="product-pricelist-selector-color">
                                                    <h6>Colors</h6>
                                                    <div class="colors" id="colors">
                                                        <li class="colorall color-1 active"></li>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                        <?php
                                }
                            } else {
                                echo "<p>Your wishlist is empty.</p>";
                            }
                        } else {
                            echo "<p>Your wishlist is empty.</p>";
                        }
                        ?>
                    </div>
                </div> -->


                <!-- نسخة بدون الكبسات 
                <div class="cart-items">
                    <div class="header">
                        <div class="image">Image</div>
                        <div class="name">Name</div>
                        <div class="price">Prices</div>
                        <div class="rating">Rating</div>
                        <div class="info">Info</div>
                    </div>
                    <div class="body">
                        <?php
                        if (count($wishlistItems) > 0) {
                            $wishlistIds = implode(',', $wishlistItems);
                            $wishlistQuery = "SELECT * FROM products WHERE product_id IN ($wishlistIds)";
                            $result = $conn->query($wishlistQuery);

                            if ($result && $result->num_rows > 0) {
                                while ($product = $result->fetch_assoc()) {
                        ?>
                                    <div class="item">
                                        <div class="image">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo $product['product_name']; ?>">
                                        </div>
                                        <div class="name">
                                            <div class="name-text">
                                                <p><?php echo $product['product_name']; ?></p>
                                            </div>
                                            <div class="button">
                                                <div class="product-pricelist-selector-button">
                                                    <form method="post" action="cartAction.php" target="cart-frame-<?php echo $product['product_id']; ?>" style="display:inline;">
                                                        <input type="hidden" name="action" value="add_to_cart">
                                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                        <button type="submit" class="btn cart-bg">Add to cart
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                                                <g id="Your_Bag" data-name="Your Bag" transform="translate(1)">
                                                                    <g id="Icon" transform="translate(0 1)">
                                                                        <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                        <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                        <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <iframe name="cart-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                                    <form method="post" action="wishlistAction.php" target="wishlist-frame-<?php echo $product['product_id']; ?>" style="display:inline;" onsubmit="return removeFromWishlist(event, <?php echo $product['product_id']; ?>)">
                                                        <input type="hidden" name="action" value="remove">
                                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                        <button type="submit" class="del">Remove</button>
                                                    </form>
                                                    <iframe name="wishlist-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="price">
                                            <span><?php echo '$' . $product['price']; ?></span> <del><?php echo '$'; ?></del>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i> 5.0
                                        </div>
                                        <div class="info">
                                            <div class="size">
                                                <div class="product-pricelist-selector-size">
                                                    <h6>Sizes</h6>
                                                    <div class="sizes" id="sizes">
                                                        <li class="sizes-all active">M</li>
                                                    </div>
                                                </div>
                                                <div class="product-pricelist-selector-color">
                                                    <h6>Colors</h6>
                                                    <div class="colors" id="colors">
                                                        <li class="colorall color-1 active"></li>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="quantity">
                                                <div class="product-pricelist-selector-quantity">
                                                    <h6>Quantity</h6>
                                                    <div class="wan-spinner wan-spinner-4">
                                                        <a href="javascript:void(0)" class="minus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="11.98" height="6.69" viewBox="0 0 11.98 6.69">
                                                                <path id="Arrow" d="M1474.286,26.4l5,5,5-5" transform="translate(-1473.296 -25.41)" fill="none" stroke="#989ba7" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                            </svg>
                                                        </a>
                                                        <input type="text" value="1" min="1">
                                                        <a href="javascript:void(0)" class="plus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="11.98" height="6.69" viewBox="0 0 11.98 6.69">
                                                                <g id="Arrow" transform="translate(10.99 5.7) rotate(180)">
                                                                    <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l5,5,5-5" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                                </g>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            } else {
                                echo "<p>Your wishlist is empty.</p>";
                            }
                        } else {
                            echo "<p>Your wishlist is empty.</p>";
                        }
                        ?>
                    </div>
                </div> -->
            </div>
            <!-- Wishlist Item End -->
        </div>
        </div>
    </section>
    <!-- Wishlist Area End -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center newsletter-area">
                <div class="col-lg-5">
                    <div class="newsletter-area-text">
                        <h4 class="text-white">Subscribe to get notification.</h4>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
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
            <div class="row main-footer">
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="main-footer-info">
                        <img src="dist/images/logo/white.png" alt="Logo" class="img-fluid">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam molestie malesuada
                            metus, non molestie ligula laoreet vitae. Ut et fringilla risus, vel.
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
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright d-flex justify-content-between align-items-center">
                        <div class="copyright-text order-2 order-lg-1">
                            <p>&copy; 2020. Design and Developed by <a href="#">Zakir Soft</a></p>
                        </div>
                        <div class="copyright-links order-1 order-lg-2">
                            <a href="#" class="ml-0"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
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



        function toggleWishlist(event, productId) {
            event.preventDefault(); // Prevent the form from submitting normally
            const form = document.getElementById(`wishlist-form-${productId}`);
            const formData = new FormData(form);

            fetch("http://localhost/ecommercebreifdb/index.php", { // Use the current page URL
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
                })
                .catch(error => console.error('Error:', error));

            return false;
        }

        function toggleCart(event, productId) {
            event.preventDefault(); // Prevent the form from submitting normally
            const form = document.getElementById(`cart-form-${productId}`);
            const formData = new FormData(form);

            fetch("http://localhost/ecommercebreifdb/index.php", { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Toggle the cart icon
                    const icon = document.getElementById(`cart-icon-${productId}`);
                    const actionInput = form.querySelector('input[name="action"]');
                    updateCartCount(); // Update the cart count
                    if (actionInput.value === 'add_to_cart') {
                        // If you want to change the icon, add class manipulation here
                        actionInput.value = 'remove_from_cart';
                    } else {
                        // If you want to change the icon, add class manipulation here
                        actionInput.value = 'add_to_cart';
                    }
                })
                .catch(error => console.error('Error:', error));

            return false;
        }

        function removeFromWishlist(event, productId) {
            event.preventDefault();
            const itemElement = document.querySelector(`.item[data-product-id="${productId}"]`);

            // Remove item from session via AJAX
            const formData = new FormData();
            formData.append('action', 'remove_from_wishlist');
            formData.append('product_id', productId);

            fetch(window.location.href, { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        itemElement.remove();
                        updateWishlistCount();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function addToCart(event, productId) {
            event.preventDefault();
            const itemElement = document.querySelector(`.item[data-product-id="${productId}"]`);

            // Add item to cart via AJAX
            const formData = new FormData();
            formData.append('action', 'add_to_cart');
            formData.append('product_id', productId);

            fetch(window.location.href, { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateWishlistCount() {
            fetch("get_wishlist_count.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('wishlist-count').innerText = data.count;
                })
                .catch(error => console.error('Error:', error));
        }

        function updateCartCount() {
            fetch("get_cart_count.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').innerText = data.count;
                })
                .catch(error => console.error('Error:', error));
        }

        // Call updateWishlistCount and updateCartCount on page load to set the initial counts
        document.addEventListener('DOMContentLoaded', function() {
            updateWishlistCount();
            updateCartCount();
        });
    </script>
</body>