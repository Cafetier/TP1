<?php 
$PageTitle = 'Index';
require "../template/header.php";
require "../template/nav.php";
?>

<section class="container">
    <h1>Index</h1>

    <?php
    try {
        print_r($product->GetAllProduct(50, ['Brand' => 'Adidas', 'Order' => 'DESC']));
        //print_r($product->GetAllProduct(50, []));
    } catch (Error $e) {
        echo $e;
    }
    ?>
</section>

<?php require_once('../template/footer.php'); ?>