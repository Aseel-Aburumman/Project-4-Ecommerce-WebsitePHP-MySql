<div class="cart-items">
    <div class="header">
        <div class="image">Image</div>
        <div class="name">Name</div>
        <div class="price">Prices</div>
        <div class="quantity">Quantity</div>
        <div class="total">Total</div>
    </div>
    <div class="body">
        <?php
        if (count($cartItems) > 0) {
            $cartIds = implode(',', $cartItems);
            $cartQuery = "SELECT * FROM products WHERE product_id IN ($cartIds)";
            $result = $conn->query($cartQuery);

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
                            <span><?php echo '$' . $product['price']; ?></span>
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
                echo "<p>Your cart is empty.</p>";
            }
        } else {
            echo "<p>Your cart is empty.</p>";
        }
        ?>
    </div>
</div>