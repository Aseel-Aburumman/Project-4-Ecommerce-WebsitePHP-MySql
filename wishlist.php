<?php
include 'connection.php';

session_start();

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

        .product-pricelist-selector-button .cart-bg {
            color: white;
            background-color: #335AFF;
            padding: 20px 19px;
            /* margin-right: 28px; */
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
                            <li class="list-inline-item"><a href="user-dashboard.php">Account
                                    settings</a></li>
                            <li class="list-inline-item"><a href="deliver-info.php">Billing information</a></li>
                            <li class="list-inline-item"><a href="wishlist.php" class="active">My wishlist</a></li>
                            <li class="list-inline-item"><a href="cart.php">My cart</a></li>
                            <li class="list-inline-item"><a href="order.php">Order</a></li>
                            <li class="list-inline-item"><a href="/Project-4-Ecommerce-WebsitePHP-MySql/api/logout.php" class="mr-0">Log-out</a></li>
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
                        <div class="name">Detail</div>
                        <div class="price"> </div>

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
                                            <div>
                                                <p><?php echo $product['description']; ?></p>

                                            </div>

                                        </div>
                                        <div class="price">
                                            <span><?php echo '$' . number_format($product['price'], 2); ?></span>
                                        </div>
                                        <div class="rating">
                                            <i class="fas fa-star"></i> 5.0
                                        </div>

                                        <div class="info">
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
                                            <div class="thingstothinkabout size">
                                                <div class="product-pricelist-selector-size">
                                                    <h6>Sizes</h6>
                                                    <div class="sizes" id="sizes">
                                                        <li class="sizes-all active">M</li>
                                                    </div>
                                                </div>
                                                <div class="product-pricelist-selector-color">
                                                    <h6 class="thingstothinkabout">Colors</h6>
                                                    <div class="thingstothinkabout colors" id="colors">
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
                <!-- <div class="cart-items">
                    <div class="header">
                        <div class="image">
                            Image
                        </div>
                        <div class="name">
                            Name
                        </div>
                        <div class="price">
                            Prices
                        </div>
                        <div class="rating">
                            Rating
                        </div>
                        <div class="info">
                            Info
                        </div>
                    </div>
                    <div class="body">
                        <div class="item">
                            <div class="image">
                                <img src="dist/images/nike-shoe.jpg">
                            </div>
                            <div class="name">
                                <div class="name-text">
                                    <p> Skechers Men's Classic Fit-Delson-Camden Sneaker</p>
                                </div>
                                <div class="button">
                                    <div class="product-pricelist-selector-button">
                                        <a class="btn cart-bg " href="#">Add to cart
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                                <g id="Your_Bag" data-name="Your Bag" transform="translate(1)">
                                                    <g id="Icon" transform="translate(0 1)">
                                                        <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                        <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                        <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                    <a class="del" href="#">Remove</a>
                                </div>
                            </div>
                            <div class="price">
                                <span>$254.99</span> <del>$499.99</del>
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
                                        <h6>quantity</h6>
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
                        <div class="item">
                            <div class="image">
                                <img src="dist/images/nike-shoe.jpg">
                            </div>
                            <div class="name">
                                <div class="name-text">
                                    <p> Skechers Men's Classic Fit-Delson-Camden Sneaker</p>
                                </div>
                                <div class="button">
                                    <div class="product-pricelist-selector-button">
                                        <a class="btn cart-bg " href="#">Add to cart
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                                <g id="Your_Bag" data-name="Your Bag" transform="translate(1)">
                                                    <g id="Icon" transform="translate(0 1)">
                                                        <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                        <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                        <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                    <a class="del" href="#">Remove</a>
                                </div>
                            </div>
                            <div class="price">
                                <span>$254.99</span> <del>$499.99</del>
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
                                        <h6>quantity</h6>
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
                        <div class="item">
                            <div class="image">
                                <img src="dist/images/nike-shoe.jpg">
                            </div>
                            <div class="name">
                                <div class="name-text">
                                    <p> Skechers Men's Classic Fit-Delson-Camden Sneaker</p>
                                </div>
                                <div class="button">
                                    <div class="product-pricelist-selector-button">
                                        <a class="btn cart-bg " href="#">Add to cart
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                                <g id="Your_Bag" data-name="Your Bag" transform="translate(1)">
                                                    <g id="Icon" transform="translate(0 1)">
                                                        <ellipse id="Ellipse_2" data-name="Ellipse 2" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(4.773 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                        <ellipse id="Ellipse_3" data-name="Ellipse 3" cx="0.682" cy="0.714" rx="0.682" ry="0.714" transform="translate(12.273 13.571)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                        <path id="Path_3" data-name="Path 3" d="M1,1H3.727l1.827,9.564a1.38,1.38,0,0,0,1.364,1.15h6.627a1.38,1.38,0,0,0,1.364-1.15L16,4.571H4.409" transform="translate(-1 -1)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                    <a class="del" href="#">Remove</a>
                                </div>
                            </div>
                            <div class="price">
                                <span>$254.99</span> <del>$499.99</del>
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
                                        <h6>quantity</h6>
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
                    </div>
                </div> -->
                <!-- Wishlist Item End -->
            </div>
        </div>
    </section>
    <!-- Wishlist Area End -->

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