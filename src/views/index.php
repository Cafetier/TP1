<?php 
$PageTitle = 'Index';
require "../template/header.php";
require "../template/nav.php";
?>

<section class="container">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="../../public/img/promo/Promo_2for1.png" alt="Two for one promo 2022">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../../public/img/promo/Promo_200ormore.png" alt="200 or more get a free t-shirt 2022">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
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