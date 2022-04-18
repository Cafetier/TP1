<?php 
$PageTitle = 'Magasiner';
require "../template/header.php";
require "../template/nav.php";

// fetch all categories of filters and store in array
$categories = [];
$categories['Brands'] = $product->GetBrands();
$categories['Types'] = $product->GetTypes();
$categories['Colors'] = $product->GetColors();
$categories['Sizes'] = $product->GetSizes();

// check if there is GET values and append to filters
$filters = [];
foreach ($_GET as $k => $v) {
    if (empty($v)) continue;
    switch ($k) {
        case 'brand':
            $filters['Brand'] = $v;
            break;
            
        case 'colorname':
            $filters['ColorName'] = $v;
            break;

        case 'size':
            $filters['Size'] = $v;
            break;

        case 'type':
            $filters['Type'] = $v;
            break;

        case 'price':
            $filters['Price'] = $v;
            break;

        case 'order':
            $filters['Order'] = $v;
            break;
    }
}


// fetch products
try{
    $products = $product->GetAllProduct(0, $filters);
    print_r($products);
}
catch(Error $e){
    $error = $e->getMessage();
}



include_once "../template/alert.php";
?>

<section class="container" id="shop_page">
    <!-- Filters -->
    <div>
        <h3>Filters</h3>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <!-- Brand -->
            <h5>Brand</h5>
            <div class="grid-2">
                <?php foreach ($categories['Brands'] as $k => $v): ?>
                    <div>
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                        <?php echo $v['BrandName'] ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Types -->
            <h5>Types</h5>
            <div>
                <?php foreach ($categories['Types'] as $k => $v): ?>
                    <div class="form-check">
                        <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="option1">
                            <?php echo $v['TypeName'] ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <div class="form-check">
                    <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="option1">
                    None
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="option1">
                        Option one is this and that—be sure to include why it's great
                    </label>
                </div>
            </div>

            <!-- Colors -->
            <h5>Colors</h5>
            <div>
                <?php print_r($categories['Colors']);?>
                <select class="form-select">
                    <option hidden selected>Color</option>
                    <?php foreach ($categories['Colors'] as $k => $v): ?>
                        <option value="<?php echo $v['color_hex'] ?>"><?php echo $v['ColorName'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Sizes -->
            <h5>Sizes</h5>
            <div>
                <input type="range" class="form-range">
            </div>

            <!-- Submit btn -->
            <div class="row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary col ">Update</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Items -->
    <div class="grid-3">
        <?php foreach ($products as $k => $v): ?>
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
                <h4><?php echo $v['ProductName'] ?></h4>
                <!-- Price -->
                <p><?php echo $v['Price'] ?></p>
                <!-- Colors -->
                <span><?php echo $v['ColorName'] ?></span>
                <!-- Sizes -->
                <span><?php echo $v['Size'] ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once('../template/footer.php'); ?>


<!-- <script>
    async function fetchProducts(){
        const response = await fetch('_getproducts.php')
        .then(r => r.json())
        .then(data => console.log(data));
    }
    fetchProducts();
</script> -->