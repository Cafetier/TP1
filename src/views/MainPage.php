<?php 
$PageTitle = 'Magasiner';
require "../template/header.php";
require "../template/nav.php";

include_once "../template/alert.php";
?>

<section class="container">
    
</section>

<?php require_once('../template/footer.php'); ?>


<script>
    async function fetchProducts(){
        const response = await fetch('_getproducts.php')
        .then(r => r.json())
        .then(data => console.log(data));
    }
    fetchProducts();
</script>