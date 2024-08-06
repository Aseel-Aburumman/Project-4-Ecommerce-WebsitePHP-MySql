<?php

    include 'connection.php';
    
    $sql = "SELECT products.product_id, products.product_name FROM products";
    $result =  $conn->query($sql);
    $product = $result->fetch_assoc();
    
    // $product = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    
    
    $list_data = [];
    while ($product = $result->fetch_assoc()){
        $list_data[] = $product;
        // echo  json_encode($product);
    }


    
    echo json_encode($list_data);
    
