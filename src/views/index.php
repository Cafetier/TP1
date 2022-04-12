<?php 
$PageTitle = 'Index';
require "../template/header.php";
require "../template/nav.php";
?>

<section class="container">
    <h1>Index</h1>
</section>

<?php require_once('../template/footer.php'); ?>


<script>
    // fetch elem each 30s
    async function fetchProducts(){
        const response = await fetch('_getproducts.php')
        .then(r => r.json())
        .then(data => console.log(data));
        return response;
    }
    fetchProducts();
    setInterval(fetchProducts, 60000);
</script>