<?php 
$PageTitle = 'Index';
require "../template/header.php";
?>

<h1>Index</h1>

<?php
try {
    print_r($product->GetAllProduct(50, []));
} catch (Error $e) {
    echo $e;
}
?>

<?php require_once('../template/footer.php'); ?>