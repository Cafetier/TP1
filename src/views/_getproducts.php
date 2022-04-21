<?php
/**
 * 
 * This page is used as an async call for products
 * 
 * Deprecated async
 * 
 * 
 * 
 */
require_once '../Start.php';

try {
    echo json_encode($product->GetAllProduct(50, ['Order' => 'DESC']));
} catch (Error $e) {
    echo $e;
}