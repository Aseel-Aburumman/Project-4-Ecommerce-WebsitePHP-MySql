<?php
include 'connection.php';

session_start();


$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$coupon = isset($_SESSION['coupon']) ? $_SESSION['coupon'] : null;

// Handle quantity update via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $productId = $_POST['product_id'];

    if ($action == 'update_quantity') {
        $quantity = $_POST['quantity'];

        if (isset($_SESSION['cart_quantities'][$productId])) {
            $_SESSION['cart_quantities'][$productId] = $quantity;
        } else {
            $_SESSION['cart'][] = $productId;
            $_SESSION['cart_quantities'][$productId] = $quantity;
        }
    } elseif ($action == 'remove_from_cart') {
        if (($key = array_search($productId, $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            unset($_SESSION['cart_quantities'][$productId]);
        }
    }

    // Return a JSON response
    echo json_encode(['success' => true]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog -Cart</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                    <h5>Cart</h5>
                </div>
            </div>
        </div>
    </section>
    <!-- BreadCrumb Start-->

    <!-- Cart Area Start -->
    <section class="cart-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Dashboard-Nav  Start-->
                    <div class="dashboard-nav">
                        <ul class="list-inline">

                            <li class="list-inline-item"><a href="fav-list.php">My wishlist</a></li>
                            <li class="list-inline-item"><a href="cart-Guest.php" class="active">My cart</a></li>
                        </ul>
                    </div>
                    <!-- Dashboard-Nav  End-->
                </div>
            </div>
            <div class="rows">
                <div class="cart-items">
                    <div class="header">
                        <div class="image">
                            Image
                        </div>
                        <div class="name">
                            Details
                        </div>
                        <div style="text-align: center;" class="price">
                            Quantity
                        </div>
                        <div style="visibility:hidden;" class="rating">

                        </div>
                        <div class="info">
                            Total
                        </div>
                    </div>
                    <div class="body">
                        <?php
                        if (count($cartItems) > 0) {
                            $cartIds = implode(',', $cartItems);
                            $cartQuery = "SELECT * FROM products WHERE product_id IN ($cartIds)";
                            $result = $conn->query($cartQuery);

                            if ($result && $result->num_rows > 0) {
                                while ($product = $result->fetch_assoc()) {
                                    $product_id = $product['product_id'];
                                    $quantity = isset($_SESSION['cart_quantities'][$product_id]) ? $_SESSION['cart_quantities'][$product_id] : 1;
                                    $unitPrice = $product['price'];
                                    $totalPrice = $unitPrice * $quantity;
                        ?>
                                    <div class="item" data-product-id="<?php echo $product_id; ?>">
                                        <div class="image">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo $product['product_name']; ?>">
                                        </div>
                                        <div class="name">
                                            <div class="name-text">
                                                <p><?php echo $product['product_name']; ?></p>
                                            </div>
                                            <!-- <div class="button">
                                                <div class="product-pricelist-selector-button">
                                                    <form method="post" action="cartAction.php" target="cart-frame-<?php echo $product['product_id']; ?>" style="display:inline;">
                                                        <input type="hidden" name="action" value="add_to_cart">
                                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                        <button type="submit" class="btn cart-bg">CHECKOUT NOW
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
                                                    <form method="post" style="display:inline;" onsubmit="return removeFromCart(event, <?php echo $product['product_id']; ?>)">
                                                        <input type="hidden" name="action" value="remove_from_cart">
                                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                        <button type="submit" class="del">Remove</button>
                                                    </form>
                                                    <iframe name="wishlist-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="price">
                                            <span class="unit-price"><?php echo 'JD' . number_format($unitPrice, 2); ?></span>
                                        </div>

                                        <div class="quantity">
                                            <div class="product-pricelist-selector-quantity">
                                                <h6>Quantity</h6>
                                                <div class="wan-spinner wan-spinner-4">
                                                    <a href="javascript:void(0)" class="minus" onclick="updateQuantity(<?php echo $product_id; ?>, -1)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11.98" height="6.69" viewBox="0 0 11.98 6.69">
                                                            <path id="Arrow" d="M1474.286,26.4l5,5,5-5" transform="translate(-1473.296 -25.41)" fill="none" stroke="#989ba7" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                        </svg>
                                                    </a>
                                                    <input type="number" value="<?php echo $quantity; ?>" min="1" class="quantity-input" onchange="updateQuantity(<?php echo $product_id; ?>, 0, this.value)">
                                                    <a href="javascript:void(0)" class="plus" onclick="updateQuantity(<?php echo $product_id; ?>, 1)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11.98" height="6.69" viewBox="0 0 11.98 6.69">
                                                            <g id="Arrow" transform="translate(10.99 5.7) rotate(180)">
                                                                <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l5,5,5-5" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" />
                                                            </g>
                                                        </svg>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="info">
                                            <div class="size">
                                                <div class="product-pricelist-selector-size">
                                                    <h6 class="thingstothinkabout">Sizes</h6>
                                                    <div class="thingstothinkabout sizes" id="sizes">
                                                        <li class="sizes-all active">M</li>
                                                    </div>
                                                </div>
                                                <div class="product-pricelist-selector-color ">
                                                    <h6 class="thingstothinkabout">Colors</h6>
                                                    <div class="colors thingstothinkabout" id="colors">
                                                        <li class="thingstothinkabout colorall color-1 active"></li>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="total">
                                            <span class="total-price"><?php echo 'JD' . $totalPrice; ?></span>
                                            <iframe name="cart-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                            <form method="post" style="display:inline;" onsubmit="return removeFromCart(event, <?php echo $product['product_id']; ?>)">
                                                <input type="hidden" name="action" value="remove_from_cart">
                                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                <button type="submit" class="del">Remove</button>
                                            </form>
                                            <iframe name="wishlist-frame-<?php echo $product['product_id']; ?>" style="display:none;"></iframe>
                                        </div>

                                    </div>
                        <?php
                                }
                            } else {
                                echo "<p>Your cart is empty.</p>";
                            }
                        } else {
                            echo "<p>Your cart is empty.</p>";
                        }
                        ?>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="apply-coupon">
                        <h6>Apply Coupon</h6>
                        <form id="coupon-form" method="post" action="applyCoupon.php">
                            <div class="form__div">
                                <input type="text" class="form__input" name="coupon_code" placeholder=" ">
                                <label for="" class="form__label">Coupon Code</label>
                            </div>
                            <button class="btn bg-primary" type="submit">apply COUPON</button>
                        </form>
                        <div id="coupon-message"></div>
                    </div>
                    <!-- <div class="apply-coupon">
                        <h6>Apply Coupon</h6>
                        <form action="#">
                            <div class="form__div">
                                <input type="text" class="form__input" placeholder=" ">
                                <label for="" class="form__label">Coupon Code</label>
                            </div>
                            <button class="btn bg-primary" type="submit">apply COUPON</button>
                        </form>
                    </div> -->
                </div>
                <div class="col-lg-6">
                    <div class="card-price">
                        <h6>Check Summary</h6>
                        <div class="card-price-list d-flex justify-content-between align-items-center">
                            <div class="item">
                                <p id="item-count">0 items</p>
                            </div>
                            <div class="price">
                                <p id="item-total-price">$0.00</p>
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
                        <form action="#">
                            <a href="<?php echo $userPageUrlcheckout; ?>" class="btn bg-primary" type="submit" style="width: 100%;">Checkout Now</a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Cart Area End -->

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
</body>