<?php
include 'connection.php';
session_start();

// // Function to check if the user is signed in
// function isUserSignedIn()
// {
//     return isset($_SESSION['user_id']);
// }
// // اكاونت من عبسي

// $userPageUrl = isUserSignedIn() ? 'user-dashboard.php' : 'account (1).php';
// $userPageUrlFavList = isUserSignedIn() ? 'wishlist.php' : 'fav-list.php';
// $userPageUrlCart = isUserSignedIn() ? 'cart.php' : 'cart-Guest.php';

$query = 'SELECT * FROM products WHERE product_id < 5';
$result = $conn->query($query);

$popquery = 'SELECT * FROM products WHERE product_id > 5 AND product_id < 12';
$popresult = $conn->query($popquery);

$revsql = "
    SELECT reviews.comment, users.username, products.image 
    FROM reviews 
    JOIN users ON reviews.user_id = users.user_id
    JOIN products ON reviews.product_id = products.product_id";
$revresult = $conn->query($revsql);


// غباء عارفة بس مخي سكر 
$coountsql1 = "SELECT COUNT(*) AS product_count FROM products WHERE  product_type_id = 1";
$countresult1 = $conn->query($coountsql1);
$row1 = $countresult1->fetch_assoc();
$productCount1 = $row1['product_count'];

$coountsql2 = "SELECT COUNT(*) AS product_count FROM products WHERE  product_type_id = 2";
$countresult2 = $conn->query($coountsql2);
$row2 = $countresult2->fetch_assoc();
$productCount2 = $row2['product_count'];

$coountsql3 = "SELECT COUNT(*) AS product_count FROM products WHERE  product_type_id = 3";
$countresult3 = $conn->query($coountsql3);
$row3 = $countresult3->fetch_assoc();
$productCount3 = $row3['product_count'];

$coountsql4 = "SELECT COUNT(*) AS product_count FROM products WHERE  product_type_id = 4";
$countresult4 = $conn->query($coountsql4);
$row4 = $countresult4->fetch_assoc();
$productCount4 = $row4['product_count'];

$coountsql5 = "SELECT COUNT(*) AS product_count FROM products WHERE  product_type_id = 5";
$countresult5 = $conn->query($coountsql5);
$row5 = $countresult5->fetch_assoc();
$productCount5 = $row5['product_count'];

$coountsql6 = "SELECT COUNT(*) AS product_count FROM products WHERE  product_type_id = 6";
$countresult6 = $conn->query($coountsql6);
$row6 = $countresult6->fetch_assoc();
$productCount6 = $row6['product_count'];

$coountsql7 = "SELECT COUNT(*) AS product_count FROM products WHERE  product_type_id = 7";
$countresult7 = $conn->query($coountsql7);
$row7 = $countresult7->fetch_assoc();
$productCount7 = $row7['product_count'];




// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $product_id = $_POST['product_id'];
//     if (!isset($_SESSION['wishlist'])) {
//         $_SESSION['wishlist'] = array();
//     }
//     if (!isset($_SESSION['cart'])) {
//         $_SESSION['cart'] = array();
//         $_SESSION['cart_quantities'] = [];
//     }

//     if ($_POST['action'] == 'add_to_wishlist') {
//         if (!in_array($product_id, $_SESSION['wishlist'])) {
//             $_SESSION['wishlist'][] = $product_id;
//         }
//     } elseif ($_POST['action'] == 'remove_from_wishlist') {
//         if (($key = array_search($product_id, $_SESSION['wishlist'])) !== false) {
//             unset($_SESSION['wishlist'][$key]);
//             $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
//         }
//     } elseif ($_POST['action'] == 'add_to_cart') {
//         if (!in_array($product_id, $_SESSION['cart'])) {
//             $_SESSION['cart'][] = $product_id;
//             $_SESSION['cart_quantities'][$product_id] = 1;
//         }
//     } elseif ($_POST['action'] == 'remove_from_cart') {
//         if (($key = array_search($product_id, $_SESSION['cart'])) !== false) {
//             unset($_SESSION['cart'][$key]);
//             $_SESSION['cart'] = array_values($_SESSION['cart']);
//         }
//     }
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog - Home</title>
    <link rel="stylesheet" href="dist/main.css">

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
        <!--Banner Area Start -->
        <section class="banner-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="banner-area__content">
                            <h4>New Collection</h4>
                            <h2>FASHION TRENDS
                            </h2>
                            <p>Uncompromising in style, quality and performance</p>
                            <a class="btn bg-primary" href="shop.php">Shop Now</a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2">
                        <div style="padding: 29px 0 87px 0;" class="banner-area__img">
                            <img src="dist/images/banner_aseel.jpg" alt="banner-img" class="img-fluid">
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!--Banner Area End -->

        <!--Brands Area Start -->


        <div style="padding: 46px 0 45px 0;" class="populerproduct">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h2>Our Brands</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="brand-area">
                        <div class="brand-area-image">
                            <img style="width: 90px; " src="dist/images/brand/6.png" alt="Brand" class="img-fluid">
                        </div>
                        <div class="brand-area-image">
                            <img style="width: 100px;margin-top:10px;" src="dist/images/brand/7.png" alt="Brand" class="img-fluid">
                        </div>
                        <div class="brand-area-image">
                            <img style="width: 140px;margin-top:-10px; " src="dist/images/brand/8.png" alt="Brand" class="img-fluid">
                        </div>
                        <div class="brand-area-image">
                            <img style="width: 100px;margin-top:10px; " src="dist/images/brand/9.png" alt="Brand" class="img-fluid">
                        </div>
                        <div class="brand-area-image">
                            <img style="width: 100px;margin-top:-20px; " src="dist/images/brand/10.webp" alt="Brand" class="img-fluid">
                        </div>
                        <div class="brand-area-image">
                            <img src="dist/images/brand/05.png" alt="Brand" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Brands Area End -->



        <!-- Features Section Start -->
        <section class="features">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2>Featured Products</h2>
                        </div>
                    </div>
                </div>
                <div class="features-wrapper">
                    <div class="features-active">
                        <?php while ($product = $result->fetch_assoc()) : ?>
                            <?php
                            // Check if the product is in the wishlist or cart
                            $isInWishlist = isset($_SESSION['wishlist']) && in_array($product['product_id'], $_SESSION['wishlist']);
                            $isInCart = isset($_SESSION['cart']) && in_array($product['product_id'], $_SESSION['cart']);
                            ?>
                            <div class="product-item">
                                <div class="product-item-image">
                                    <a href="product-details.php?id=<?php echo $product['product_id']; ?>">
                                        <?php
                                        if (isset($product['image']) && !empty($product['image'])) {
                                            $imgData = base64_encode($product['image']);
                                            $src = 'data:image/jpeg;base64,' . $imgData;
                                        } else {
                                            $src = '/dist/images/nike-shoe.jpg';
                                        }
                                        ?>
                                        <img style="width: 400px; height: 400px;object-fit: cover;" src="<?php echo $src; ?>" alt="<?php echo $product['product_name']; ?>" class="img-fluid">
                                    </a>
                                    <div class="cart-icon">
                                        <form id="wishlist-form-<?php echo $product['product_id']; ?>" method="post" style="display:inline;" onsubmit="return toggleWishlist(event, <?php echo $product['product_id']; ?>)">
                                            <input type="hidden" name="action" value="<?php echo $isInWishlist ? 'remove_from_wishlist' : 'add_to_wishlist'; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                            <button type="submit" style="border:none; background:white; width:30px;height:30px; border-radius: 50%; padding:3px; margin-right: 3px;">
                                                <i id="wishlist-icon-<?php echo $product['product_id']; ?>" class="<?php echo $isInWishlist ? 'fas fa-heart' : 'far fa-heart'; ?>"></i>
                                            </button>
                                        </form>

                                        <form id="cart-form-<?php echo $product['product_id']; ?>" method="post" style="display:inline;" onsubmit="return toggleCart(event, <?php echo $product['product_id']; ?>)">
                                            <input type="hidden" name="action" value="<?php echo $isInCart ? 'remove_from_cart' : 'add_to_cart'; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                            <button type="submit" style="border:none; background:white; width:30px;height:30px; border-radius: 50%; padding:3px;">
                                                <svg id="cart-icon-<?php echo $product['product_id']; ?>" xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                                    <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                        <g id="Icon" transform="translate(0 1)">
                                                            <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                            <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                            <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </button>
                                        </form>
                                        <iframe name="cart-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                    </div>
                                </div>
                                <div class="product-item-info">
                                    <a href="product-details.php?id=<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></a>
                                    <span>JD<?php echo $product['price']; ?></span>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    </div>
                    <div class="slider-arrows">
                        <div class="prev-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                <path id="Icon_feather-chevron-left" data-name="Icon feather-chevron-left" d="M20.5,23l-7-7,7-7" transform="translate(-12.5 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="next-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                <path id="Icon_feather-chevron-right" data-name="Icon feather-chevron-right" d="M13.5,23l5.25-5.25.438-.437L20.5,16l-7-7" transform="translate(-12.086 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="features-morebutton text-center">
                            <a class="btn bt-glass" href="shop.php">View All Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Features Section End -->

        <!-- About Area Start -->
        <section class="about-area">
            <div class="container">
                <div class="about-area-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6 ">
                            <div class="about-area-content-img">
                                <img src="dist/images/feature/store.jpg" alt="img" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-area-content-text">
                                <h3>Why Shop with Olog</h3>
                                <p>Discover stylish outfits, enhance your wardrobe, and feel confident like stepping into the spotlight.

                                </p>
                                <div class="icon-area-content">
                                    <div class="icon-area">
                                        <i class="far fa-check-circle"></i>
                                        <span>Secure Payment Method.</span>
                                    </div>
                                    <div class="icon-area">
                                        <i class="far fa-check-circle"></i>
                                        <span>24/7 Customers Services.</span>
                                    </div>
                                    <div class="icon-area">
                                        <i class="far fa-check-circle"></i>
                                        <span>Timeless outfits</span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Area End -->

        <!-- Populer Product Strat -->
        <section class="populerproduct">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2>Popular Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <?php while ($popproduct = $popresult->fetch_assoc()) : ?>
                        <?php

                        $isInWishlist = isset($_SESSION['wishlist']) && in_array($popproduct['product_id'], $_SESSION['wishlist']);
                        $isInCart = isset($_SESSION['cart']) && in_array($popproduct['product_id'], $_SESSION['cart']);
                        ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="product-item">
                                <div class="product-item-image">
                                    <a href="product-details.php?id=<?php echo $popproduct['product_id']; ?>">
                                        <?php
                                        if (isset($popproduct['image']) && !empty($popproduct['image'])) {
                                            $imgData = base64_encode($popproduct['image']);
                                            $src = 'data:image/jpeg;base64,' . $imgData;
                                        } else {
                                            $src = '/dist/images/nike-shoe.jpg';
                                        }
                                        ?>
                                        <img style="width: 400px; height: 400px;object-fit: cover;" src="<?php echo $src; ?>" alt="<?php echo $popproduct['product_name']; ?>" class="img-fluid">
                                    </a>
                                    <div class="cart-icon">
                                        <form id="wishlist-form-<?php echo $popproduct['product_id']; ?>" method="post" style="display:inline;" onsubmit="return toggleWishlist(event, <?php echo $popproduct['product_id']; ?>)">
                                            <input type="hidden" name="action" value="<?php echo $isInWishlist ? 'remove_from_wishlist' : 'add_to_wishlist'; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $popproduct['product_id']; ?>">
                                            <button type="submit" style="border:none; background:white; width:30px;height:30px; border-radius: 50%; padding:3px; margin-right: 3px;">
                                                <i id="wishlist-icon-<?php echo $popproduct['product_id']; ?>" class="<?php echo $isInWishlist ? 'fas fa-heart' : 'far fa-heart'; ?>"></i>
                                            </button>
                                        </form>

                                        <form id="cart-form-<?php echo $popproduct['product_id']; ?>" method="post" style="display:inline;" onsubmit="return toggleCart(event, <?php echo $popproduct['product_id']; ?>)">
                                            <input type="hidden" name="action" value="<?php echo $isInCart ? 'remove_from_cart' : 'add_to_cart'; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $popproduct['product_id']; ?>">
                                            <button type="submit" style="border:none; background:white; width:30px;height:30px; border-radius: 50%; padding:3px;">
                                                <svg id="cart-icon-<?php echo $popproduct['product_id']; ?>" xmlns="http://www.w3.org/2000/svg" width="16.75" height="16.75" viewBox="0 0 16.75 16.75">
                                                    <g id="Your_Bag" data-name="Your Bag" transform="translate(0.75)">
                                                        <g id="Icon" transform="translate(0 1)">
                                                            <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                            <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                            <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </button>
                                        </form>
                                        <iframe name="cart-frame-<?php echo $popproduct['product_id']; ?>" style="display:none;"></iframe>
                                    </div>
                                </div>
                                <div class="product-item-info">
                                    <a href="product-details.php?id=<?php echo $popproduct['product_id']; ?>"><?php echo $popproduct['product_name']; ?></a>
                                    <span>$<?php echo $popproduct['price']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>
        </section>
        <!-- Populer Product End -->

        <!-- Categorys Section Start -->
        <section class="categorys">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="section-title">
                            <h2>Shop with top categorys</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="shop.php?gender=Clothing&product_type=T-Shirt"> <img src="dist/images/categorys/T-Shirt.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="shop.php?gender=Clothing&product_type=T-Shirt">
                                    <h6>T-Shirt</h6>
                                    <span><?php echo $productCount1; ?>Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="shop.php?gender=Footwear&product_type=Shoes"><img src="dist/images/categorys/Shoes.jpg" alt="images"> </a>
                            </div>
                            <div class="productcategory-text">
                                <a href="shop.php?gender=Footwear&product_type=Shoes">
                                    <h6>Shoes</h6>
                                    <span><?php echo $productCount2; ?> Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="shop.php?gender=Clothing&product_type=Hoodies"><img src="dist/images/categorys/Hoodies.png" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="shop.php?gender=Clothing&product_type=Hoodies">
                                    <h6>Hoodies</h6>
                                    <span><?php echo $productCount3; ?> Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="shop.php?gender=Clothing&product_type=Jeans"><img src="dist/images/categorys/Jeans.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="shop.php?gender=Clothing&product_type=Jeans">
                                    <h6>Jeans</h6>
                                    <span><?php echo $productCount4; ?> Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="shop.php?gender=Clothing&product_type=T-Shirt"><img src="dist/images/categorys/Casual.webp" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="shop.php?gender=Clothing&product_type=T-Shirt">
                                    <h6>Casual</h6>
                                    <span><?php echo $productCount5; ?> Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="shop.php?gender=Accessories&product_type=Accessories"><img src="dist/images/categorys/Pajamas.webp" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="shop.php?gender=Accessories&product_type=Accessories">
                                    <h6>Accessories</h6>
                                    <span><?php echo $productCount6; ?> Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="productcategory text-center">
                            <div class="productcategory-img">
                                <a href="shop.php?gender=Clothing&product_type=Shorts"><img src="dist/images/categorys/Shorts.jpg" alt="images"></a>
                            </div>
                            <div class="productcategory-text">
                                <a href="shop.php?gender=Clothing&product_type=Shorts">
                                    <h6>Shorts</h6>
                                    <span><?php echo $productCount7; ?> Products</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- Categorys Section End -->

        <!-- Features Section Start -->
        <section class="customersreview">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div style="margin-bottom: 0px;" class="section-title">
                            <h2>What Our Customers Say</h2>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 020px;" class="customersreview-wrapper">
                    <div class="customersreview-active">
                        <?php
                        if ($revresult->num_rows > 0) {
                            while ($row = $revresult->fetch_assoc()) {
                                $image = $row['image'];
                                echo '<div class="customersreview-item" style="display: flex; align-items: center; border: 1px solid #ccc; border-radius: 10px; width: 600px; margin: 20px 10PX; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">';
                                echo '<div style="flex:1;object-fit: cover; width: 200px; height: 250px; overflow: hidden; border-radius: 20%; margin-right: 20px;">';
                                echo "<img src='data:image/jpeg;base64," . base64_encode($image) . "' alt='Product Image' style='width: 100%; height: 100%; object-fit: cover;'>";
                                echo '</div>';
                                echo '<div style="flex:1;">';
                                echo '<p style="margin: 0;">' . $row["comment"] . '</p>';
                                echo '<div class="name" style="margin-top: 10px;">';
                                echo '<h6 style="margin: 0;">' . $row["username"] . '</h6>';
                                echo '</div></div></div>';
                            }
                        } else {
                            echo "0 results";
                        }
                        $conn->close();
                        ?>
                    </div>
                    <div class="slider-arrows">
                        <div class="prev-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                <path id="Icon_feather-chevron-left" data-name="Icon feather-chevron-left" d="M20.5,23l-7-7,7-7" transform="translate(-12.5 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="next-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                <path id="Icon_feather-chevron-right" data-name="Icon feather-chevron-right" d="M13.5,23l5.25-5.25.438-.437L20.5,16l-7-7" transform="translate(-12.086 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Features Section End -->
    </main>

    <!-- Footer -->

    <?php
    include 'footer.php';
    ?>

    <!-- Footer -->

    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script src="src/scss/vendors/plugin/js/slick.min.js"></script>
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


        // Call updateCartCount on page load to set the initial cart count
        // document.addEventListener('DOMContentLoaded', () => {
        //     updateCartCount();
        //     updateWishlistCount();
        // });
    </script>
</body>