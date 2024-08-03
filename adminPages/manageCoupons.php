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
                                        <img src="<?php echo $src; ?>" alt="<?php echo $product['product_name']; ?>" class="img-fluid">
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
                                    <span>$<?php echo $product['price']; ?></span>
                                </div>
                            </div>
                        <?php endwhile; ?>