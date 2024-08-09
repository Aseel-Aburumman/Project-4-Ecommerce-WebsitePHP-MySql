<!-- نسخة يوسف -->

<?php

include 'connection.php';
session_start();

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

        mark {
            background: linear-gradient(-100deg, hsla(48, 92%, 75%, .3), hsla(48, 92%, 75%, .7) 95%, hsla(48, 92%, 75%, .1));
            border-radius: 1em 0;
            padding: .5rem;
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

    <main>

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
                                <li class="breadcrumb-item active" aria-current="page">Shop</li>

                                <?php if (1 == 2) : ?>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo '' ?></li>
                                <?php endif ?>

                                <?php if (1 == 4) : ?>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo '' ?></li>
                                <?php endif ?>

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
                        <div class="categoryitem-wrapper-itembox">
                            <h6>Categories</h6>
                            <select name="taskOption">
                                <option data-display="All">All</option>
                                <option value="1">Clothing</option>
                                <option value="2">Footwear</option>
                                <option value="4">Accessories</option>
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
                        </div>

                        <div class="categoryitem-wrapper-price">
                            <h6>Price</h6>
                            <form class="price-item">
                                <input type="number" placeholder="$ Min">
                                <span>|</span>
                                <input type="number" placeholder="$ Max">
                            </form>
                        </div>

                        <input type="submit" value="SEND"> 

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
                    // if(isset($_REQUEST['page'])){
                    //     if($_REQUEST['page']){

                    //         $curent_number = $_REQUEST['page'] -1;

                    //         $from = 1+($curent_number * 8);
                    //         $to = 12+($curent_number * 8);
                    //     }
                    // }else{
                    //     $from = 1;
                    //     $to = 12;   
                    // }

                    if ($gender != 'all' && $product_type != 'all') {

                        $sql = "SELECT products.product_id, products.product_name, products.description, products.price, products.image,
                          products.category_id, products.product_type_id FROM products 
                          Join categories ON products.category_id = categories.category_id
                          Join producttypes ON products.product_type_id = producttypes.product_type_id
                                          
                          WHERE
                          products.category_id=(SELECT categories.category_id FROM categories WHERE categories.category_name='$gender') 
                          AND
                          products.product_type_id=(SELECT producttypes.product_type_id FROM producttypes WHERE producttypes.type_name='$product_type')
                          
                          ORDER BY product_id;";
                    } elseif ($gender != 'all') {
                        $sql = "SELECT products.product_id, products.product_name, products.description, products.price, products.image,
                          products.category_id, products.product_type_id FROM products 
                          Join categories ON products.category_id = categories.category_id
                          Join producttypes ON products.product_type_id = producttypes.product_type_id
                          WHERE
                          products.category_id=(SELECT categories.category_id FROM categories WHERE categories.category_name='$gender')
                          ORDER BY product_id;";


                        // $sql = "SELECT products.product_id, products.product_name, products.description, products.price, products.image,
                        //         products.category_id, products.product_type_id FROM products 
                        //         Join categories ON products.category_id = categories.category_id
                        //         Join producttypes ON products.product_type_id = producttypes.product_type_id

                        //         HAVING 
                        //         products.product_id 
                        //         BETWEEN


                        //         	(SELECT fm.product_id  FROM 
                        //             (SELECT * FROM products WHERE products.category_id=(SELECT categories.category_id FROM categories WHERE categories.category_name='$gender') ORDER BY product_id LIMIT $from) fm 
                        //         	HAVING fm.product_id = (SELECT MAX(f.product_id) FROM (SELECT * FROM products WHERE products.category_id=(SELECT categories.category_id FROM categories WHERE categories.category_name='$gender') ORDER BY product_id LIMIT $from) f))

                        //         	AND

                        //         	(SELECT fm.product_id  FROM (SELECT * FROM products WHERE products.category_id=(SELECT categories.category_id FROM categories WHERE categories.category_name='$gender') ORDER BY product_id LIMIT $to) fm 
                        //         	HAVING fm.product_id = (SELECT MAX(f.product_id) FROM (SELECT * FROM products WHERE products.category_id=(SELECT categories.category_id FROM categories WHERE categories.category_name='$gender') ORDER BY product_id LIMIT $to) f))




                        //         AND
                        //         products.category_id=(SELECT categories.category_id FROM categories WHERE categories.category_name='$gender')";






                    } elseif ($product_type != 'all') {

                        $sql = "SELECT products.product_id, products.product_name, products.description, products.price, products.image,
                          products.category_id, products.product_type_id
                          FROM products 
                          Join categories ON products.category_id = categories.category_id
                          Join producttypes ON products.product_type_id = producttypes.product_type_id
                          WHERE
                          products.product_type_id=(SELECT producttypes.product_type_id FROM producttypes WHERE producttypes.type_name='$product_type') 
                          
                          ORDER BY product_id;";
                    } else {


                        // $sql = "SELECT * FROM products 
                        //         WHERE products.product_id 

                        //         BETWEEN

                        //         (SELECT fm.product_id  FROM (SELECT * FROM products ORDER BY product_id LIMIT $from) fm 
                        //         HAVING fm.product_id = (SELECT MAX(f.product_id) FROM (SELECT * FROM products ORDER BY product_id LIMIT $from) f))

                        //         AND

                        //         (SELECT fm.product_id  FROM (SELECT * FROM products ORDER BY product_id LIMIT $to) fm 
                        //         HAVING fm.product_id = (SELECT MAX(f.product_id) FROM (SELECT * FROM products ORDER BY product_id LIMIT $to) f))
                        //         ";
                        $sql = "SELECT * FROM products ORDER BY product_id";
                    }
                    $result =  $conn->query($sql);
                    $GLOBALS['list_data'] = [];
                    $number_in_one_dev = 12;
                    // ماكس الصفحة 


                    $class_dev = 1;
                    // كلاسات الصفحة والبروداكت بهاي الرقم 

                    $pageNumber = 1;
                    if (isset($_REQUEST['page'])) {
                        $pageNumber = $_REQUEST['page'];
                    }

                    // نقطتين 
                    while ($product = $result->fetch_assoc()) :;
                        if (!$number_in_one_dev) {
                            $class_dev += 1;

                            $number_in_one_dev = 12;
                        }
                        // var_dump($product);
                        $number_in_one_dev--;

                        $list_data[] = $product['product_name'];
                        // var_dump($list_data);
                    ?>
                        <!-- بدل echo مساواة كافية -->
                        <div class="col-md-4 col-sm-6 <?= "page$class_dev" ?>" style="display: <?= $class_dev != $pageNumber ? "none" : "block"; ?> !important;">
                            <!-- <div class="col-md-4 col-sm-6 <?= "page" ?>"> -->
                            <?php
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
                                    <span>JD<?php echo $product['price']; ?></span>
                                    <!-- الديساكونت من يوسف  -->
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                    <!-- هون تسكيرة الوايل الي فوق  -->
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
                        // عملت كومنت وفعلت الي تحتها 
                        //  $sql = "SELECT COUNT(product_id) as c FROM products";
                        //  $result =  $conn->query($sql);
                        //  $count = $result->fetch_assoc();

                        //  $GLOBALS['list_data'] = [];
                        //  echo count($list_data);

                        // $numProd = $count['c'];
                        $numProd = count($list_data);
                        // معادلة لحساب عدد الصفحات التوتال 
                        // (15-15/12)/12
                        $numPag = ($numProd - $numProd % 12) / 12;
                        $numProd % 12 ? ++$numPag : '';
                        // باقي الي ضل , 3
                        if ($numPag > 1) :
                        ?>
                            <!-- تبعت الاسهم للصفحات -->
                            <?php $pageNumber == 1 ? $pageNumber_minise = $pageNumber : $pageNumber_minise = $pageNumber - 1; ?>
                            <!-- هاي الاصغر (القبل) -->
                            <a href="shop.php?<?php echo "gender=$gender&product_type=$product_type&page=$pageNumber_minise"; ?>" class="p_prev"><svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.828" viewBox="0 0 9.414 16.828">
                                    <path id="Icon_feather-chevron-left" data-name="Icon feather-chevron-left" d="M20.5,23l-7-7,7-7" transform="translate(-12.5 -7.586)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                </svg></a>
                            <?php for ($pag = 1; $pag <= $numPag; $pag++) :
                                // طباعة عدد الصفحات كلها
                                $pag == $pageNumber ? $staute = 'active' : $staute = '';

                            ?>
                                <a href="shop.php?<?php echo "gender=$gender&product_type=$product_type"; ?>&page=<?= $pag ?>" class="cdp_i <?= $staute ?>">0<?= $pag ?></a>
                            <?php endfor; ?>

                            <!--  ما تتفعل اذا عدد الصفحات خلص هاي الاكبر (البعد) -->

                            <?php $pageNumber == $numPag ? $pageNumber_plus = $pageNumber : $pageNumber_plus = $pageNumber + 1; ?>
                            <a href="shop.php?<?php echo "gender=$gender&product_type=$product_type&page=$pageNumber_plus" ?>" class="p_next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="9.414" height="16.829" viewBox="0 0 9.414 16.829">
                                    <g id="Arrow" transform="translate(1.414 15.414) rotate(-90)">
                                        <path id="Arrow-2" data-name="Arrow" d="M1474.286,26.4l7,7,7-7" transform="translate(-1474.286 -26.4)" fill="none" stroke="#1a2224" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </a>
                        <?php endif ?>
                        <!-- تسكيرة الif الي بسطر 528 -->
                    </div>
                </div>
            </div>
        </section>
        <!-- Pagination End -->

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
            const formData = new FormData(form);

            fetch("http://localhost/ecommercebreifdb/index.php", { // Use the current page URL
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

            fetch("http://localhost/ecommercebreifdb/index.php", { // Use the current page URL
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
            fetch("http://localhost/ecommercebreifdb/api/get_cart_count.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').innerText = data.count;
                })
                .catch(error => console.error('Error:', error));
        }

        function updateWishlistCount() {
            fetch("http://localhost/ecommercebreifdb/api/get_wishlist_count.php")
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