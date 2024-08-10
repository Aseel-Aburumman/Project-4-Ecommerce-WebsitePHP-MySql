<?php
include "../connection.php";

$check = '';
if (!isset($_SESSION['user_name'])) {
    header("Location: ../account (1).php");
    exit();
}



$categories = [];
$product_types = [];

$sql_categories = "SELECT category_id, category_name FROM categories";
$result_categories = $conn->query($sql_categories);
if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}

$sql_product_types = "SELECT product_type_id, type_name FROM producttypes";
$result_product_types = $conn->query($sql_product_types);
if ($result_product_types->num_rows > 0) {
    while ($row = $result_product_types->fetch_assoc()) {
        $product_types[] = $row;
    }
}

if (isset($_GET['product_id'])) {


    if ($_GET['product_id']) {
        $id_p = $_GET['product_id'];
        $sql = "SELECT * FROM products WHERE product_id=$id_p";
        $check = "id=$id_p";
    }
} elseif (isset($_GET['serch_product'])) {

    if ($_GET['serch_product']) {
        $name_p = $_GET['serch_product'];
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







?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Olog - Home</title>
    <link rel="stylesheet" href="../dist/main.css">

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


    <main>

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
                                                $src = '../dist/images/categorys/Casual.webp';
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





    </main>



    <script src="../src/js/jquery.min.js"></script>
    <script src="../src/js/bootstrap.min.js"></script>
    <script src="../src/scss/vendors/plugin/js/slick.min.js"></script>
    <script src="../src/scss/vendors/plugin/js/jquery.exzoom.js"></script>
    <script src="../src/scss/vendors/plugin/js/jquery.nice-select.min.js"></script>
    <script src="../dist/main.js"></script>
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
            let api = await fetch(`../api_get.php/products.json`);
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

</body>