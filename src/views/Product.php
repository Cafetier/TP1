<?php 
$PageTitle = 'Détails';
require "../template/header.php";
require "../template/nav.php";

$urlID = $_GET['id'];
// if there is no get and no id
if ($_SERVER["REQUEST_METHOD"] !== "GET" || !ctype_digit($_GET['id'])){
    header("Location: Index");  //redirect to the main page
    exit();
}

// check if there is a product, returns the product info
$product_info = $product->GetProduct($urlID);

// if id of product doest exist
if (empty($product_info)){
    echo 'There is no product';
}

print_r($product_info);

include_once "../template/alert.php";
?>

<section class="container"></section>

<?php require_once('../template/footer.php'); ?>