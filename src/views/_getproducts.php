<?php
/**
 * 
 * This page is used as an async call for products
 */
require_once '../Start.php';

// if there is a logout get, then log the user out
if(isset($_GET['logout']) && $_SERVER["REQUEST_METHOD"] === "GET"){
    $user->LogOut();
    unset($_GET['logout']);  //unset the logout
    header("Location: Index");  //redirect to the main page
    exit();
}

try {
    echo json_encode($product->GetAllProduct(50, ['Order' => 'DESC']));
} catch (Error $e) {
    echo $e;
}