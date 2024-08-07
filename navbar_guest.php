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

// Function to check if the user is signed in
function isUserSignedIn()
{
    return isset($_SESSION['user_id']);
}
// اكاونت من عبسي

$userPageUrl = isUserSignedIn() ? 'user-dashboard.php' : 'account (1).php';
$userPageUrlFavList = isUserSignedIn() ? 'wishlist.php' : 'fav-list.php';
$userPageUrlCart = isUserSignedIn() ? 'cart.php' : 'fav-list.php';
$userPageUrlcheckout = isUserSignedIn() ? 'billing-information.php' : 'account (1).php';

$query = 'SELECT * FROM products WHERE product_id < 5';
$result = $conn->query($query);

$popquery = 'SELECT * FROM products WHERE product_id > 5 AND product_id < 12';
$popresult = $conn->query($popquery);


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
        .header-bottom .search-bar {
            margin-left: 16px;
            min-width: 298px;
        }

        .signInBtn {
            width: 120px;
            padding-left: 20px;
            padding-top: 10px;
            height: 40px;
            padding-right: 20px;
        }

        #suggestions {
            position: absolute;
            top: 44px;
            width: 100%;
            z-index: 2000;
            border-radius: 0 0 10px 10px;
            border: none;
            border-top: none;
            box-shadow: 0 4px 5px #0000001f;
            /* background-color: red;  */
            background-color: white;

        }

        .suggestion-item {
            cursor: pointer;
            padding: 2px 0 2px 16px;
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
                            <a href="index.php"><img src="dist/images/logo/logo.png" alt="logo" /></a>
                        </div>
                        <ul class="main-menu d-flex align-items-center">
                            <li><a href="shop.php?gender=Clothing">Clothing</a></li>
                            <li><a href="shop.php?gender=Footwear">Footwear</a></li>
                            <li><a href="shop.php?gender=Accessories">Accessories</a></li>
                            <li><a href="shop.php">Shop</a></li>
                            <li>
                                <a href="javascript:void(0)">Category
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                        <g id="Arrow" transform="translate(0.99 0.99)">
                                            <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                        </g>
                                    </svg> -->
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=T-Shirt"; ?>">T-Shirt</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shoes"; ?>">Shoes</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Hoodies"; ?>">Hoodies</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Jeans"; ?>">Jeans</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Casual"; ?>">Casual</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Accessories"; ?>">Accessories</a></li>
                                    <li><a href="shop.php?<?php echo "gender=$gender&product_type=Shorts"; ?>">Shorts</a></li>
                                </ul>
                            </li>
                            <li><a href="sales.php">Sales</a></li>
                        </ul>

                        <!-- <div class="search-bar"> -->
                        <form class="search-bar" action="product-details.php">

                            <!-- <input type="text" placeholder="Search for product..." id="searchInput" class="style_searching_input" onchange="performSearch(this)"> -->
                            <!-- <input type="text" onchange="hi123()"> -->
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
                            <!-- </div> -->
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
                                    <button type="submit" class="btn bg-secondary border text-capitalize signInBtn">
                                        <a href="<?php echo $userPageUrl; ?>">Sign Up
                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20">
                                            <g id="Account" transform="translate(1 1)">
                                                <path id="Path_86" data-name="Path 86" d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2" transform="translate(-4 -3)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(4)" fill="#fff" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </g>
                                        </svg> -->
                                        </a>
                                    </button>
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
                                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="9.98" height="5.69" viewBox="0 0 9.98 5.69">
                                    <g id="Arrow" transform="translate(0.99 0.99)">
                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l4,4,4-4" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                    </g>
                                </svg> -->
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

    <!--  السيرش الي فوق هاي مو جاهزة من يوسف  -->
    <!-- <script src="searching.js"></script> -->

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
            if (!form) {
                console.error(`Form with ID 'wishlist-form-${productId}' not found.`);
                return false;
            }
            const formData = new FormData(form);

            fetch("http://localhost/Project-4-Ecommerce-WebsitePHP-MySql/index.php", { // Use the current page URL
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Toggle the heart icon
                    const icon = document.getElementById(`wishlist-icon-${productId}`);
                    if (!icon) {
                        console.error(`Icon with ID 'wishlist-icon-${productId}' not found.`);
                        return;
                    }
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
                .catch(error => {
                    console.error('Error:', error);
                });

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





        // let list_for_search = [];

        // async function fetchData() {
        //     // try {
        //     let response = await fetch(`api_get.php/products.json`);
        //     let data = await response.json();
        //     list_for_search = data.map(element => ({
        //         name: element['product_name']
        //     }));
        //     // } catch (error) {
        //     //     console.error('Error fetching data:', error);
        //     // }
        // }
        // fetchData();

        // function check_my_div() {
        //     let myYousef = document.querySelector("#suggestions");
        //     if (myYousef.innerHTML === '') {
        //         document.querySelector("#searchInput").className = 'style_searching_input';
        //         myYousef.style.visibility = 'hidden';
        //     } else {
        //         document.querySelector("#searchInput").className = 'style_searching_input_with_results';
        //         myYousef.style.visibility = 'visible';
        //     }
        // }

        // function performSearch(ele) {
        //     console.log('jfdlksfjsld');
        //     const search_id = 'searchInput';
        //     const div_id = 'suggestions';
        //     const query = ele.value.toLowerCase();
        //     const suggestionsDiv = document.getElementById(div_id);
        //     suggestionsDiv.innerHTML = '';

        //     if (query.length === 0) {
        //         check_my_div();
        //         return;
        //     }

        //     const filteredData = list_for_search.filter(item => item.name.toLowerCase().includes(query));

        //     if (filteredData.length > 0) {
        //         filteredData.forEach(item => {
        //             const div = document.createElement('input');
        //             div.type = 'submit';
        //             div.name = 'serch_product';
        //             div.value = item.name;
        //             div.className = 'suggestion-item';
        //             // div.onclick = () => selectSuggestion(item.name, search_id, div_id);
        //             suggestionsDiv.appendChild(div);
        //         });
        //     }
        //     check_my_div();
        // }

        // function selectSuggestion(suggestion = '', search_id = '', div_id = '') {
        //     if (suggestion && search_id && div_id) {
        //         document.getElementById(search_id).value = suggestion;
        //         document.getElementById(div_id).innerHTML = '';
        //     }
        // }



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
    </script>
</body>

</html>