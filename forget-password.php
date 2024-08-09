<?php
include 'connection.php';

$Ceekemailerr = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Ceekemail = $_POST['Ceekemail'];

    if ($Ceekemail == '') {
        $Ceekemailerr = "Please enter an email";
    } else {

        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $Ceekemail);
        $stmt->execute();
        $stmt->store_result();


        if ($stmt->num_rows > 0) {

            header("Location: reset-password.php?email=" . urlencode($Ceekemail));
            $resetPassword = false;
        } else {
            $Ceekemailerr = "Email  Not Found";
        }


        $stmt->close();
    }
}


$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog - Forget Password</title>
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

    <main>
        <!-- Forget Password Start -->
        <section class="forget-password">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="account-sign-in">
                            <h5 class="text-center modi-sm">Forget Password</h5>
                            <form action="#" method="POST">
                                <div class="form__div">
                                    <input type="email" class="form__input" placeholder=" " name="Ceekemail">
                                    <label for="" class="form__label">Email</label>

                                </div>
                                <span style="color:red"> <?php echo $Ceekemailerr; ?></span>
                                <button href="reset-passwor.html" class="btn bg-primary">Reset Password</button>
                            </form>

                            <div class="ask-signup text-center">
                                <a href="#" class="mr-1" style="color:#989BA7;">Don't have account?</a>
                                <a href="account.html">Sign up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Forget Password End -->
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
    </script>
</body>

</html>