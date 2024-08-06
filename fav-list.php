<?php
include 'connection.php';

session_start();

// Function to check if the user is signed in


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
                            <li class="list-inline-item"><a href="fav-list.php" class="active">My wishlist</a></li>
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
                        <div class="name">Details</div>
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
                                            <span><?php echo 'JD' . number_format($product['price'], 2); ?></span>
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



            </div>
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
</body>