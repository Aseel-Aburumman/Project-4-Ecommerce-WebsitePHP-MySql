<?php
include "connection.php";

$check = '';

if (isset($_REQUEST['id'])) {

    if ($_REQUEST['id']) {
        $id_p = $_REQUEST['id'];
        $sql = "SELECT * FROM products WHERE product_id=$id_p";
        $check = "id=$id_p";
    }
} elseif (isset($_REQUEST['serch_product'])) {

    if ($_REQUEST['serch_product']) {
        $name_p = $_REQUEST['serch_product'];
        $check = "serch_product=$name_p";
        $sql = "SELECT * FROM products WHERE product_name='$name_p'";
    }
} else {
    header('location: shop.php');
}

$result =  $conn->query($sql);
$product = $result->fetch_assoc();




// go to line 593 - 629
if (isset($_REQUEST['submit_send_comminte'])) {

    if (isset($_REQUEST['username'])  && isset($_REQUEST['usercomminte'])) {

        $product_id = $product['product_id'];

        $comment_for_id = $product['product_id'];
        //  $username = $_REQUEST['username'];
        $username = 'regular_user';    //                                            is this Loging in ? or gest?
        $comminte = $_REQUEST['usercomminte'];

        $rating = 'null';    // Default Value


        if (isset($_REQUEST['rating'])) {
            if ($_REQUEST['rating'] > 0 && $_REQUEST['rating'] < 6) {
                $rating = $_REQUEST['rating'];
            }
        }

        if ($username && $comminte) {
            $sql_set_commint = "INSERT INTO reviews (reviews.product_id, reviews.user_id, reviews.rating, reviews.comment, reviews.review_date)
                 VALUES 
                 ($product_id,(SELECT users.user_id FROM users WHERE users.username='$username'), $rating,'$comminte', '2022-11-3');";
            $conn->query($sql_set_commint);
        }
        header("Location: product-details.php?id=$product_id");
    } else {
        header("Location: product-details.php?id=$product_id");
    }
}



if (isset($_REQUEST['product_name'])) {
    if ($_REQUEST['product_name']) {
        $name_p = $_REQUEST['product_name'];
        header("Location: product-details.php?product_name=$name_p");
    }
}


session_start();


$query = 'SELECT * FROM products WHERE product_id < 5';
$result = $conn->query($query);




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog - Home</title>
    <link rel="stylesheet" href="dist/main.css">

    <style>
        .rating {
            display: inline-block;
        }

        .rating input {
            display: none;
        }

        .rating label {
            float: right;
            cursor: pointer;
            color: #ccc;
            transition: color 0.3s;
        }

        .rating label:before {
            content: '\2605';
            font-size: 30px;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: #fef200;
            transition: color 0.3s;
        }













        #suggestions {
            position: absolute;
            top: 44px;
            width: 100%;
            z-index: 2000;
            border-radius: 0 0 10px 10px;
            /* border: 1px solid #989BA7; */
            /* border-top: none; */
            box-shadow: 0 4px 5px #0000001f;
            /* background-color: red; */
            background-color: white;

        }

        .suggestion-item {
            cursor: pointer;
            /* padding : 2px 0 2px 16px; */
            background-color: transparent;
            border-radius: 0 !important;
            border: none !important;

        }

        .suggestion-item:hover {
            background-color: #2b2b5b45;
        }

        .style_searching_input {
            border-radius: 10px 10px !important;
            border-bottom: none !important;
            border: none !important;
            box-shadow: 0 -2px 5px #0000001f;
        }

        .style_searching_input_with_results {
            border-bottom: none !important;

            border-radius: 10px 10px 0 0 !important;
            border-bottom: none !important;
            border: none !important;
            box-shadow: 0 -4px 5px #0000001f;
        }



        /* for rating */
        .star_off {
            color: #b6b6bd;
        }

        .star_on {
            color: gold;
        }

        mark {
            background: linear-gradient(-100deg, hsla(48, 92%, 75%, .3), hsla(48, 92%, 75%, .7) 95%, hsla(48, 92%, 75%, .1));
            border-radius: 1em 0;
            padding: .5rem;
        }
    </style>
    <!-- <link rel="stylesheet" href="assets/css/style_search.css"> -->
    <!-- <link rel="stylesheet" href="{{ get_public_template_url('style_search.css') }}"> -->

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
        <!--Breadcrumb Area Start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb">

                            <?php if (isUserSignedInbtn()) {
                                echo '<h3 style="font-size: 1.5rem;" class="breadcrumb-item"><a href="user-dashboard.php">Hi <mark id="usernameHighlight"></mark></a></h3>';
                            }
                            ?>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">Category</li>
                                <li class="breadcrumb-item" aria-current="page">Subcategory</li>
                                <li class="breadcrumb-item" aria-current="page">Product</li>
                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                        <h5>Detail</h5>
                    </div>
                </div>
            </div>
        </section>
        <!--Breadcrumb Area End -->

        <!-- Product Details Area Start -->
        <section class="product">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-5 col-12">
                        <div class="product-slider">
                            <div class="exzoom" id="exzoom">
                                <div class="exzoom_img_box">
                                    <ul class='exzoom_img_ul'>
                                        <!-- <li><img src="dist/images/product-deatils/1-big-mage.jpg" /></li> -->
                                        <li>
                                            <?php
                                            if (isset($product['image']) && !empty($product['image'])) {
                                                $imgData = base64_encode($product['image']);
                                                $src = 'data:image/jpeg;base64,' . $imgData;
                                            } else {
                                                $src = 'dist/images/categorys/Casual.webp';
                                            }
                                            ?>
                                            <img src="<?= $src ?>" />
                                        </li>
                                        <!-- <li><img src="dist/images/product/<?= $product['image'] ?>" /></li> -->
                                        <!-- <li><img src="dist/images/product/<?= $product['image'] ?>" /></li> -->
                                        <!-- <li><img src="dist/images/product-deatils/2-big-image.jpg" /></li>
                                        <li><img src="dist/images/product-deatils/3-big-image.jpg" /></li>
                                        <li><img src="dist/images/product-deatils/4-big-image.jpg" /></li> -->
                                        <li><img src="" alt=""></li>
                                    </ul>
                                </div>
                                <div class="exzoom_nav"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7 col-12">
                        <div class="product-pricelist">
                            <h2><?= $product['product_name'] ?></h2>
                            <div class="product-pricelist-ratting">
                                <div class="price">
                                    <span><?= $product['price'] ?></span>
                                </div>
                                <div class="star">
                                    <ul>
                                        <?php


                                        $product_id = $product['product_id'];
                                        $sql_rating = "SELECT ((SUM(rating)/(COUNT(rating)*5))*5) as r, COUNT(rating) as n FROM reviews WHERE product_id = $product_id";
                                        $result_rating = $conn->query($sql_rating);;

                                        $rating = mysqli_fetch_all($result_rating, MYSQLI_ASSOC);


                                        $list_stars_staut = ['star_off', 'star_off', 'star_off', 'star_off', 'star_off'];

                                        if ($rating[0]['r'] && $rating[0]['n']) {


                                            $calc_to_rating = '';
                                            if (round($rating[0]['r']) > $rating[0]['r']) {
                                                $calc_to_rating = ((round($rating[0]['r']) * 10000000) % ($rating[0]['r'] * 10000000)) / 10000000;
                                            } elseif (round($rating[0]['r']) < $rating[0]['r']) {
                                                $calc_to_rating = (($rating[0]['r'] * 10000000) % (round($rating[0]['r']) * 10000000)) / 10000000;
                                            }





                                            $h_r_r = handel_raing_rating($rating[0]['r']);

                                            $curent_rating = 0;
                                            if ($calc_to_rating && round($rating[0]['r']) < $rating[0]['r'] && $h_r_r != round($rating[0]['r'])) {
                                                $curent_rating = round($rating[0]['r'])  + 1;
                                            } else {
                                                $curent_rating = round($rating[0]['r']);
                                            }


                                            for ($i = 0; $i < $curent_rating; $i++) {
                                                $list_stars_staut[$i] = 'star_on';
                                            }
                                        }
                                        // echo $curent_rating;


                                        function handel_raing_rating($rat)
                                        {
                                            $list = explode('.', $rat);
                                            if ($list[1] == 0) {
                                                return $list[0];
                                            } else {
                                                return $list[0] . '.' . $list[1][0];
                                            }
                                        }

                                        ?>
                                        <li><i class="fas fa-star <?= $list_stars_staut[0] ?>"></i></li>
                                        <li><i class="fas fa-star <?= $list_stars_staut[1] ?>"></i></li>
                                        <li><i class="fas fa-star <?= $list_stars_staut[2] ?>"></i></li>
                                        <li><i class="fas fa-star <?= $list_stars_staut[3] ?>"></i></li>
                                        <li><i class="fas fa-star <?= $list_stars_staut[4] ?>"></i></li>
                                        <li><?= $h_r_r ?></li>
                                        <li class="point">(<?= $rating[0]['n'] ?> Rating)</li>
                                    </ul>
                                </div>
                            </div>
                            <p><?= $product['description'] ?></p>

                            <div class="product-pricelist-selector">

                                <!-- <div class="product-pricelist-selector-size">
                                    <h6>Sizes</h6>
                                    <div class="sizes" id="sizes">
                                        <li class="sizes-all">S</li>
                                        <li class="sizes-all active">M</li>
                                        <li class="sizes-all">L</li>
                                        <li class="sizes-all">XL</li>
                                        <li class="sizes-all">XXL</li>
                                    </div>
                                </div> -->

                                <!-- <div class="product-pricelist-selector-color">
                                    <h6>Colors</h6>
                                    <div class="colors" id="colors">
                                        <li class="colorall color-1 active"></li>
                                        <li class="colorall color-2"></li>
                                    </div>
                                </div> -->


                                <div>
                                    <!-- <div class="product-pricelist-selector-quantity">
                                        <h6>Quantity</h6>
                                        <div class="wan-spinner wan-spinner-4">
                                            <a href="javascript:void(0)" class="minus" onclick="quantity_minus(this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11.98" height="6.69" viewBox="0 0 11.98 6.69">
                                                    <path id="Arrow" d="M1474.286,26.4l5,5,5-5" transform="translate(-1473.296 -25.41)" fill="none" stroke="#989ba7" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                </svg>
                                            </a>
                                            <input type="text" value="1" min="1" id="quantity" name="quantity">
                                            <a href="javascript:void(0)" class="plus" onclick="quantity_plus()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11.98" height="6.69" viewBox="0 0 11.98 6.69">
                                                    <g id="Arrow" transform="translate(10.99 5.7) rotate(180)">
                                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l5,5,5-5" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                    </g>
                                                </svg>
                                            </a>
                                        </div>
                                    </div> -->

                                    <div style="display: flex;" class="product-pricelist-selector-button">
                                        <form id="cart-form" method="post" onsubmit="return toggleCart(event, <?php echo $product_id; ?>)">
                                            <input type="hidden" name="action" value="add_to_cart">
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <input type="hidden" name="quantity" id="cart-quantity" value="1">
                                            <button type="submit" class="btn cart-bg">
                                                Add to cart
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                                    <circle cx="9" cy="21" r="1"></circle>
                                                    <circle cx="20" cy="21" r="1"></circle>
                                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                                </svg>
                                            </button>
                                        </form>

                                        <form id="wishlist-form-<?php echo $product_id; ?>" method="post" onsubmit="return toggleWishlist(event, <?php echo $product_id; ?>)">
                                            <input type="hidden" name="action" value="add_to_wishlist">
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <button type="submit" class="btn bg-primary cart-hart">
                                                <svg id="wishlist-icon-<?php echo $product_id; ?>" xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20">
                                                    <g id="Repeat_Grid_1" data-name="Repeat Grid 1">
                                                        <g transform="translate(1 1)">
                                                            <path id="Heart-2" data-name="Heart" d="M20.007,4.59a5.148,5.148,0,0,0-7.444,0L11.548,5.636,10.534,4.59a5.149,5.149,0,0,0-7.444,0,5.555,5.555,0,0,0,0,7.681L4.1,13.317,11.548,21l7.444-7.681,1.014-1.047a5.553,5.553,0,0,0,0-7.681Z" transform="translate(-1.549 -2.998)" fill="#fff" stroke="#335aff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </button>
                                        </form>


                                    </div>
                                </div>

                                <div class="product-pricelist-selector-button-item">
                                    <div class="shipping">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="21.4" height="17.937" viewBox="0 0 21.4 17.937">
                                                <g id="Truck_Icon" data-name="Truck Icon" transform="translate(-0.8 -3.8)">
                                                    <path id="Path_14" data-name="Path 14" d="M1.5,4.5H15.112V16.3H1.5Z" fill="none" stroke="#335aff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                    <path id="Path_15" data-name="Path 15" d="M24,12h3.63l2.722,2.722V19.26H24Z" transform="translate(-8.852 -3)" fill="none" stroke="#335aff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                    <path id="Path_16" data-name="Path 16" d="M9.037,26.269A2.269,2.269,0,1,1,6.769,24a2.269,2.269,0,0,1,2.269,2.269Z" transform="translate(-1.185 -7.5)" fill="none" stroke="#335aff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                    <path id="Path_17" data-name="Path 17" d="M28.537,26.269A2.269,2.269,0,1,1,26.269,24,2.269,2.269,0,0,1,28.537,26.269Z" transform="translate(-8.852 -7.5)" fill="none" stroke="#335aff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                </g>
                                            </svg>

                                        </div>
                                        <p>Free Shipping Cast</p>
                                    </div>
                                    <div class="delivery">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewBox="0 0 17.5 17.5">
                                                <g id="Icon" transform="translate(-2.25 -2.25)">
                                                    <path id="Path_20" data-name="Path 20" d="M19,11a8,8,0,1,1-8-8A8,8,0,0,1,19,11Z" fill="none" stroke="#335aff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                    <path id="Path_21" data-name="Path 21" d="M18,9v4.8l3.2,1.6" transform="translate(-7 -2.8)" fill="none" stroke="#335aff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                                </g>
                                            </svg>
                                        </div>
                                        <p>3 Days Delivery Time</p>
                                    </div>
                                    <div class="cash">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16">
                                                <path id="Icon" d="M14.863,11.522c-2.23-.524-2.947-1.067-2.947-1.911,0-.969.992-1.644,2.652-1.644,1.749,0,2.4.756,2.456,1.867H19.2a3.655,3.655,0,0,0-3.153-3.387V4.5H13.095V6.42c-1.906.373-3.438,1.493-3.438,3.209,0,2.053,1.876,3.076,4.617,3.671,2.456.533,2.947,1.316,2.947,2.142,0,.613-.481,1.591-2.652,1.591-2.024,0-2.819-.818-2.927-1.867H9.48c.118,1.947,1.729,3.04,3.615,3.4V20.5h2.947V18.589c1.916-.329,3.438-1.333,3.438-3.156C19.48,12.909,17.093,12.047,14.863,11.522Z" transform="translate(-9.48 -4.5)" fill="#335aff" />
                                            </svg>
                                        </div>
                                        <p>Cash on Delivery</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Details Area End -->


        <!-- Commint Section Start -->
        <section style="display:flex; justify-content:center; width:100%;">
            <div class="account-setting" style="width: 83%;">
                <h6>Commint</h6>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">

                    <div class="rating">
                        <input value="5" name="rating" id="star5" type="radio">
                        <label for="star5"></label>
                        <input value="4" name="rating" id="star4" type="radio">
                        <label for="star4"></label>
                        <input value="3" name="rating" id="star3" type="radio">
                        <label for="star3"></label>
                        <input value="2" name="rating" id="star2" type="radio">
                        <label for="star2"></label>
                        <input value="1" name="rating" id="star1" type="radio">
                        <label for="star1"></label>
                    </div>

                    <input type="hidden" name="id" value="<?= $product_id ?>">
                    <div class="form__div">
                        <input type="text" class="form__input" placeholder="" name="username">
                        <label for="" class="form__label">Full Name</label>
                    </div>

                    <div class="form__div">
                        <input type="text" class="form__input" placeholder="" name="usercomminte">
                        <label for="" class="form__label">Your comminte</label>
                    </div>
                    <input type="submit" name="submit_send_comminte" class="btn bg-primary" value="Send">
                </form>
            </div>
        </section>
        <!-- Commint Section End -->


        <!-- Features Section Start -->
        <section class="features bg-lightwhite">
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

    </main>

    <!-- Footer -->
    <?php
    include 'footer.php';
    ?>
    <!-- Footer -->

    <script src="src/js/jquery.min.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script src="src/scss/vendors/plugin/js/slick.min.js"></script>
    <script src="src/scss/vendors/plugin/js/jquery.exzoom.js"></script>
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


    <script>
        // console.log('before');
        // console.log(myYousef);
        // myYousef.style.borderColor = 'green' ;
        // myYousef.style.visibility = 'hidden' ;
        // console.log('after');


        // function quantity_minus(myele) {

        //     let quantity_value_string = document.getElementById("quantity").value;
        //     let quantity_value = parseInt(quantity_value_string);

        //     if (quantity_value > 1) {
        //         quantity_value -= 1;
        //         document.getElementById("quantity").value = quantity_value;
        //     }


        //     if (quantity_value > 1) {
        //         document.querySelector(".minus #Arrow").style.stroke = '#1a2224';
        //     } else {
        //         document.querySelector(".minus #Arrow").style.stroke = '#989ba7';
        //     }
        // }

        // function quantity_plus() {
        //     let quantity_value_string = document.getElementById("quantity").value;
        //     let quantity_value = parseInt(quantity_value_string);



        //     if (true) {
        //         quantity_value += 1;
        //         document.getElementById("quantity").value = quantity_value;
        //     }

        //     if (quantity_value > 1) {
        //         document.querySelector(".minus #Arrow").style.stroke = '#1a2224';
        //     } else {
        //         document.querySelector(".minus #Arrow").style.stroke = '#989ba7';
        //     }
        // }
    </script>




    <script>
        function check_my_div() {

            myYousef = document.querySelector("#suggestions");
            if (myYousef.innerHTML == '') {
                // myYousef.style.borderColor = 'green';
                document.querySelector("#searchInput").className = 'style_searching_input';
                myYousef.style.visibility = 'hidden';
                // document.querySelector("#searchInput").classList.remove("mystyle") = 'style_searching_input';
            } else {
                document.querySelector("#searchInput").className = 'style_searching_input_with_results';
                myYousef.style.visibility = 'visible';
                // myYousef.style.borderColor = 'red ';
            }
        }
        check_my_div()






        let list_for_search = [];
        async function yousef() {
            let api = await fetch(`api_get.php/products.json`);
            // console.log(api);

            let Json = await api.json();
            console.log(Json);
            Json.forEach(element => {

                const name = element['product_name'].split(",")[0];

                Object_yousef = {
                    // name: name
                    name: element['product_name']
                }
                list_for_search.push(Object_yousef);
            });
        }
        yousef()



        function performSearch(ele) {

            var search_id = 'searchInput';
            var div_id = 'suggestions';


            const query = document.getElementById(search_id).value.toLowerCase();
            const suggestionsDiv = document.getElementById(div_id);

            suggestionsDiv.innerHTML = '';


            if (query.length === 0) {
                return;
            }

            const filteredData = list_for_search.filter(item => item.name.toLowerCase().includes(query));

            console.log(filteredData)

            if (filteredData.length > 0) {

                for (let i = 0; i < 8; i++) {

                    const div = document.createElement('input');
                    div.type = 'submit';
                    div.name = 'serch_product';

                    div.value = filteredData[i].name;
                    div.className = 'suggestion-item';

                    suggestionsDiv.appendChild(div);
                    check_my_div()
                }
            }
        }

        function selectSuggestion(suggestion = '', search_id = '', div_id = '') {
            if (suggestion && search_id && div_id) {

                document.getElementById(search_id).value = suggestion;
                document.getElementById(div_id).innerHTML = '';
            }
        }


        // عشان لما تطلع من الاينبوت يحذف الخيارات

        // document.getElementById('searchInput').addEventListener('focusout', onfocusout);


        // if(document.getElementById('searchInput_down')){
        //     document.getElementById('searchInput_down').addEventListener('blur', onfocusout_down);
        // }

        //function onfocusout(){
        //    document.querySelector('.suggestion-item1').addEventListener('mouseover', function hi(){
        //        console.log("hi");
        //    } );
        //    
        //
        //    document.getElementById('suggestions').innerHTML = '';
        //    check_my_div()
        //}
        // function onfocusout_down(){
        //       document.getElementById('suggestions_down').innerHTML = '';
        // }
        function quantity_minus(myele) {
            let quantity_value_string = document.getElementById("quantity").value;
            let quantity_value = parseInt(quantity_value_string);

            if (quantity_value > 1) {
                quantity_value -= 1;
                document.getElementById("quantity").value = quantity_value;
            }

            if (quantity_value > 1) {
                document.querySelector(".minus #Arrow").style.stroke = '#1a2224';
            } else {
                document.querySelector(".minus #Arrow").style.stroke = '#989ba7';
            }
        }

        function quantity_plus() {
            let quantity_value_string = document.getElementById("quantity").value;
            let quantity_value = parseInt(quantity_value_string);

            quantity_value += 1;
            document.getElementById("quantity").value = quantity_value;

            if (quantity_value > 1) {
                document.querySelector(".minus #Arrow").style.stroke = '#1a2224';
            } else {
                document.querySelector(".minus #Arrow").style.stroke = '#989ba7';
            }
        }
    </script>

    <!-- <script src="src/js/searching.js"></script> -->

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