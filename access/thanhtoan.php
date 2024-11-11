<?php
session_start();
include("../admin/config.php");
$id - $_SEESION['id'];
$code_cart = rand(0, 99999);
$insert_cart = "INSERT INTO tbl_cart(id, code_cart, cart_status) VALUE('" . $id . "','" . $code_order . "',1)";
$cart_query = mysqli_query($insert_cart);
if($insert_cart){
    foreach($_SEESION['cart'] as $key => $value ){
        $id
    }
}