<?php 
$PageTitle = 'Magasiner';
require "../template/header.php";
require "../template/nav.php";

// fetch products
$product->GetAllProduct(50, ['Order' => 'DESC']);

// fetch all categories of filters and store in array



include_once "../template/alert.php";
?>

<section class="container" id="shop_page">
    <!-- Filters -->
    <div>
        <h3>Filters</h3>
        <hr>
    </div>

    <!-- Items -->
    <div class="grid-3">
        <div>
            <!-- Img carousel -->
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../../public/products/" alt="">
                    </div>
                    <!-- <div class="carousel-item">
                        <img class="d-block w-100" src="../../public/img/promo/Promo_200ormore.png" alt="200 or more get a free t-shirt 2022">
                    </div> -->
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
            <!-- Name -->
            <!-- Price -->
            <!-- Colors -->
            <!-- Sizes -->
        </div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
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