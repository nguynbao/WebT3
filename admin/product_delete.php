<?php
session_start();
if(isset($_SESSION['admin'])){
    
include "class/product_class.php";
$product = new product();
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $delete_product = $product->delete_product($product_id);
    if ($delete_product) {
        header('Location: list_product.php');
    } else {
        echo "Failed to delete the product.";
    }
}
}else{
    echo 'Erorr: 404!';
}
?>
