<?php

    include 'connection.php';

    $sql="SELECT * FROM products ORDER BY product_id";
    $result=  $conn->query($sql);

    // $product = $result->fetch_assoc();
    $product = mysqli_fetch_all($result, MYSQLI_ASSOC);

    
     echo  json_encode($product);

    
    // $list_data = [];
    // while ($product = $result->fetch_assoc()){
    //     $list_data[] = $product;
    // }


    // echo '<pre>';
    // echo json_encode($list_data);
    // echo '</pre>';
