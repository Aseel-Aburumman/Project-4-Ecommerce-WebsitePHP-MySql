<?php
include 'connection.php';

// Delfault value
$gender = 'all';
$product_type = 'all';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_REQUEST['gender'])) {
        $gender = $_REQUEST['gender'];
    }
    if (isset($_REQUEST['product_type'])) {
        $product_type = $_REQUEST['product_type'];
    }
}




if (isset($_REQUEST['product_name'])) {
    if ($_REQUEST['product_name']) {
        $name_p = $_REQUEST['product_name'];
        echo $name_p;
        header("Location: product-details.php?product_name=$name_p");
    }
}


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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = array();
    }
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['cart_quantities'] = [];
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
            $_SESSION['cart_quantities'][$product_id] = 1;
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
    <title>Olog - Home</title>
    <link rel="stylesheet" href="dist/main.css">

    <style>
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
                            <a href="index.html"><img src="dist/images/logo/logo.png" alt="logo" /></a>
                        </div>
                        <ul class="main-menu d-flex align-items-center">
                            <li><a href="shop.php?gender=Clothing">Clothing</a></li>
                            <li><a href="shop.php?gender=Footwear">Footwear</a></li>
                            <li><a href="shop.php?gender=Accessories">Clothing</a></li>
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
                            <li><a href="sales.php">Sales</a></li>
                        </ul>

                        <form class="search-bar" action="product-details.php">
                            <input type="text" placeholder="Search for product..." oninput="performSearch(this)" id="searchInput" class="style_searching_input">

                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.414" height="20.414" viewBox="0 0 20.414 20.414">
                                    <g id="Search_Icon" data-name="Search Icon" transform="translate(1 1)">
                                        <ellipse id="Ellipse_1" data-name="Ellipse 1" cx="8.158" cy="8" rx="8.158" ry="8" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <line id="Line_4" data-name="Line 4" x1="3.569" y1="3.5" transform="translate(14.431 14.5)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </div>
                            <div id="suggestions"></div>
                            <!-- <input type="submit"> -->
                        </form>



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
                        <li><a href="shop.php?gender=Clothing">Clothing</a></li>
                        <li><a href="shop.php?gender=Footwear">Footwear</a></li>
                        <li><a href="shop.php?gender=Accessories">Clothing</a></li>
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
                        <li><a href="sales.php">Sales</a></li>
                    </div>
                    <div class="mobile-nav d-flex align-items-center justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="dist/images/logo/logo.png" alt="logo" /></a>
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

    <main>

        <!-- BreadCrumb Start-->
        <section class="breadcrumb-area mt-15">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Shop</li>
                            </ol>
                        </nav>
                        <h5>Shop</h5>
                    </div>
                </div>
            </div>
        </section>
        <!-- BreadCrumb Start-->

        <!-- Catagory Search Start -->

        <!-- <section class="search">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="search-wrapper">
                        <?php
                        // if(isset($_REQUEST['sub12'])){header('Location:shop.php');
                        // }

                        // 
                        ?>
                        <form class="search-wrapper-box" method="GET" action="">
                            <input type="text" placeholder="Search Heare." id="searchInput_down" oninput="performSearch(this)">
                            <button class="btn bg-primary" type="submit" value="shop.php?<?= "gender=$gender?product_type=$product_type" ?>" name="sub12">
                            SEARCH
                            </button>
                        </form>
                        <div id="suggestions_down"></div>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- Catagory Search End -->

        <!-- Catagory item start -->
        <!-- <section class="categoryitem">
            <div class="container">
                <div class="row justify-content-center">
                    
                    <div class="categoryitem-wrapper">
                        <form action="shop.php?fsdf&<?php echo "gender=$gender&product_type=$product_type" ?>" class="categoryitem-wrapper"> -->
        <!-- <form action=""></form> -->
        <!-- <div class="categoryitem-wrapper-itembox">
                                        <h6>Gender</h6>
                                        <select name="taskOption">
                                        <option data-display="All">All</option>
                                        <option value="1">Men</option>
                                        <option value="2">Women</option>
                                        <option value="4">Children</option>
                                    </select>  
                                </div>
        
                                <div class="categoryitem-wrapper-itembox">
                                    <h6>Category</h6>
                                    <select>
                                        <option data-display="All">All</option>
                                        <option value="1">T-Shirt</option>
                                        <option value="2">Shoes</option>
                                        <option value="3">Hoodies</option>
                                        <option value="4">Jeans</option>
                                        <option value="5">Casual</option>
                                        <option value="6">Pajamas</option>
                                        <option value="7">Shorts</option>
                                    </select>
                                </div> -->

        <!-- <div class="categoryitem-wrapper-price">
                                    <h6>Price</h6> -->
        <!-- <form class="price-item" action="shop.php?<?php echo "gender=$gender&product_type=$product_type" ?> > -->
        <!-- <input type="number" placeholder="$ Min">
                                    <span>|</span>
                                    <input type="number" placeholder="$ Max"> -->
        <!-- </form> -->
        <!-- </div>
                            
                            <input type="submit" value="SEND"> 
                            
                        </form>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- Catagory item End -->

        <!-- Populer Product Strat -->
        <section class="populerproduct bg-white p-0 shop-product">
            <div class="container">
                <div class="row">

                    <?php
                    if ($gender != 'all' && $product_type != 'all') {

                        $sql = "SELECT products.product_id, products.product_name, products.description, products.price, products.image,
                          products.category_id, products.product_type_id FROM products 
                          Join categories ON products.category_id = categories.category_id
                          Join producttypes ON products.product_type_id = producttypes.product_type_id
                                          
                          WHERE
                          products.category_id=(SELECT categories.category_id FROM categories WHERE categories.category_name='$gender') 
                          AND
                          products.product_type_id=(SELECT producttypes.product_type_id FROM producttypes WHERE producttypes.type_name='$product_type')
                                          
                          AND
                          discount>0
                          ORDER BY product_id;";
                    } elseif ($gender != 'all') {

                        $sql = "SELECT products.product_id, products.product_name, products.description, products.price, products.image,
                          products.category_id, products.product_type_id FROM products 
                          Join categories ON products.category_id = categories.category_id
                          Join producttypes ON products.product_type_id = producttypes.product_type_id
                          WHERE
                          products.category_id=(SELECT categories.category_id FROM categories WHERE categories.category_name='$gender') 
                          AND
                          discount>0
                          ORDER BY product_id;";
                    } elseif ($product_type != 'all') {

                        $sql = "SELECT products.product_id, products.product_name, products.description, products.price, products.image,
                          products.category_id, products.product_type_id
                          FROM products 
                          Join categories ON products.category_id = categories.category_id
                          Join producttypes ON products.product_type_id = producttypes.product_type_id
                          WHERE
                          products.product_type_id=(SELECT producttypes.product_type_id FROM producttypes WHERE producttypes.type_name='$product_type') 
                          AND
                          discount>0
                          ORDER BY product_id;";
                    } else {

                        $sql = "SELECT * FROM products  WHERE discount>0 ORDER BY product_id";
                    }

                    $result =  $conn->query($sql);
                    if ($result) :
                        // $list_data = [];
                        $GLOBALS['list_data'] = [];
                        $number_in_one_dev = 12;



                        $class_dev = 1;

                        $pageNumber = 1;

                        if (isset($_REQUEST['page'])) {
                            $pageNumber = $_REQUEST['page'];
                        }


                        while ($product = $result->fetch_assoc()) :;
                            if (!$number_in_one_dev) {
                                $class_dev += 1;
                                $number_in_one_dev = 12;
                            }
                            $number_in_one_dev--;

                            $list_data[] = $product;
                    ?>

                            <div class="col-md-4 col-sm-6 <?= "page$class_dev" ?>" style="display: <?= $class_dev != $pageNumber ? "none" : "block"; ?> !important;">
                                <div class="product-item">
                                    <div class="product-item-image">
                                        <a href="product-details.php?id=<?php echo $product['product_id']; ?>">

                                            <?php
                                            if (isset($product['image']) && !empty($product['image'])) {
                                                $imgData = base64_encode($product['image']);
                                                $src = 'data:image/jpeg;base64,' . $imgData;
                                                // $src = 'dist/images/product/' . $product['image'];
                                            } else {
                                                $src = 'dist/images/product/02.jpg';
                                            }
                                            ?>

                                            <img style="width: 400px; height: 400px;object-fit: cover;" src="<?= $src ?>" alt="<?php echo $product['product_name']; ?>" class="img-fluid">
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
                                        <span>$<?php echo $product['price']; ?></span> <del>$<?php echo $product['discount']; ?></del>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <!-- Populer Product End -->

        <!-- Pagination Start -->
        <section class="pagination">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="pagination-group">

                        <?php

                        // $numProd = 30;
                        $numProd = count($list_data);
                        $numPag = ($numProd - $numProd % 12) / 12;
                        $numProd % 12 ? ++$numPag : '';
                        if ($numPag > 1) :
                        ?>

                            <?php $pageNumber == 1 ? $pageNumber_minise = $pageNumber : $pageNumber_minise = $pageNumber - 1; ?>

                            <a href="shop.php?<?php echo "gender=$gender&product_type=$product_type&page=$pageNumber_minise"; ?>" class="p_prev"><svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                    <path id="Icon_feather-chevron-left" data-name="Icon feather-chevron-left" d="M20.5,23l-7-7,7-7" transform="translate(-12.5 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                </svg></a>
                            <?php for ($pag = 1; $pag <= $numPag; $pag++) :

                                $pag == $pageNumber ? $staute = 'active' : $staute = '';

                            ?>
                                <a href="shop.php?<?php echo "gender=$gender&product_type=$product_type"; ?>&page=<?= $pag ?>" class="cdp_i <?= $staute ?>">0<?= $pag ?></a>
                            <?php endfor; ?>

                            <!-- <a href="shop.php?<?php echo "gender=$gender&product_type=$product_type"; ?>&page=2" class="cdp_i">02</a>
                        <a href="" class="cdp_i">03</a> -->

                            <!-- <a href="shop.php?<?php echo "gender=$gender&product_type=$product_type"; ?>&page=4" class="cdp_i">...</a>
                        <a href="shop.php?<?php echo "gender=$gender&product_type=$product_type"; ?>&page=5" class="cdp_i">05</a> -->


                            <?php $pageNumber == $numPag ? $pageNumber_plus = $pageNumber : $pageNumber_plus = $pageNumber + 1; ?>
                            <a href="shop.php?<?php echo "gender=$gender&product_type=$product_type&page=$pageNumber_plus" ?>" class="p_next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.829" viewBox="0 0 9.414 16.829">
                                    <g id="Arrow" transform="translate(1.414 15.414) rotate(-90)">
                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l7,7,7-7" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Pagination End -->

    </main>

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
            <!-- <div class="row main-footer">
                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="main-footer-info">
                        <img src="dist/images/logo/white.png" alt="Logo" class="img-fluid">
                        <p>
                            We’re available by phone +962 782 615 549<br>
                            info@example.com<br>
                            Sunday till Friday 10 to 6 EST
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
            </div> -->
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

            let Json = await api.json();
            Json.forEach(element => {
                Object_yousef = {
                    name: element['product_name']
                }
                list_for_search.push(Object_yousef);
            });
        }
        yousef()



        function performSearch(ele) {
            var search_id = 'searchInput';
            var div_id = 'suggestions';

            if (ele.id == 'searchInput') {
                search_id = 'searchInput';
                div_id = 'suggestions';
            } else if (ele.id == 'searchInput_down') {
                search_id = 'searchInput_down';
                div_id = 'suggestions_down';
            }
            const query = document.getElementById(search_id).value.toLowerCase();
            const suggestionsDiv = document.getElementById(div_id);

            suggestionsDiv.innerHTML = '';


            if (query.length === 0) {
                return;
            }

            const filteredData = list_for_search.filter(item => item.name.toLowerCase().includes(query));

            if (filteredData.length > 0) {
                filteredData.forEach(item => {
                    //   const div = document.createElement('div');
                    const div = document.createElement('input');
                    div.type = 'submit';
                    div.name = 'serch_product';
                    //   div.textContent = item.name;
                    div.value = item.name;
                    div.className = 'suggestion-item';
                    //   div.onclick = () => selectSuggestion(item.name,search_id, div_id);
                    suggestionsDiv.appendChild(div);
                    check_my_div()
                });
            }
        }

        function selectSuggestion(suggestion = '', search_id = '', div_id = '') {
            if (suggestion && search_id && div_id) {

                document.getElementById(search_id).value = suggestion;
                document.getElementById(div_id).innerHTML = '';
                //   location.href = "product-details.php?fsdf" + suggestion;
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
        //       document.getElementById('suggestions_down').innerHTML = '';6
        // }
    </script>

    <script>
        function updateWishlistIcon(productId) {
            var icon = document.getElementById('wishlist-icon-' + productId);
            if (icon) {
                icon.classList.remove('far');
                icon.classList.add('fas');
            }
        }

        function updateCartIcon(productId) {
            var icon = document.getElementById('cart-icon-' + productId);
            if (icon) {
                icon.style.fill = 'red'; // Change the icon color or any other style change to indicate the item is added
            }
        }

        function toggleWishlist(event, productId) {
            event.preventDefault(); // Prevent the form from submitting normally
            const form = document.getElementById(`wishlist-form-${productId}`);
            const formData = new FormData(form);

            fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/index.php", { // Use the current page URL
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

            fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/index.php", { // Use the current page URL
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

        // Call updateCartCount on page load to set the initial cart count
        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
            updateWishlistCount();
        });
    </script>
</body>