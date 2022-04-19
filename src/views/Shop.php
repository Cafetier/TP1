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
        case 'Brand':
            $filters['Brand'] = $v;
            break;
            
        case 'Colorname':
            $filters['ColorName'] = $v;
            break;

        case 'Size':
            $filters['Size'] = $v;
            break;

        case 'Type':
            $filters['Type'] = $v;
            break;

        case 'Price':
            $filters['Price'] = $v;
            break;

        case 'Order':
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

// alert overlay
include_once "../template/alert.php";
?>

<section class="container" id="shop_page">
    <!-- Filters -->
    <div id="filter_side">
        <h3>Filters</h3>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="get">
            <!-- Brand -->
            <h5>Brand</h5>
            <div class="grid-2">
                <?php foreach ($categories['Brands'] as $k => $v): ?>
                    <label class="form-check-label" for="<?php echo $v['BrandName'] ?>">
                        <!-- Input -->
                        <input class="form-check-input" type="checkbox" 
                        name="Brand" 
                        value="<?php echo $v['BrandName'] ?>" id="<?php echo $v['BrandName'] ?>"

                        <?php if(($_GET['Brand'] ?? null) === $v['BrandName']) echo 'checked' ?>

                        >

                        <!-- Text -->
                        <?php echo $v['BrandName'] ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <!-- Types -->
            <h5>Types</h5>
            <?php foreach ($categories['Types'] as $k => $v): ?>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="Type" value="<?php echo $v['TypeName'] ?>">
                        <?php echo $v['TypeName'] ?>
                    </label>
                </div>
            <?php endforeach; ?>

            <!-- Colors -->
            <h5>Colors</h5>
            <select class="form-select" name="ColorName">
                <option value="" hidden selected>Color</option>
                <?php foreach ($categories['Colors'] as $k => $v): ?>
                    <option value="<?php echo $v['ColorName'] ?>"><?php echo $v['ColorName'] ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Sizes -->
            <h5>Sizes</h5>
            <div>
                <input type="range" class="form-range" min="5" max="13" step="0.5" name="Size">
            </div>

            <!-- Price -->
            <h5>Price</h5>
            <div>
            </div>


            <!-- Submit btn -->
            <div class="row">
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary col ">Update</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Items && pagination -->
    <div>
        <!-- Items -->
        <div class="grid-3">
            <?php if (!array_filter($products)): ?>
                There is no product to show
            <?php endif;?>

            <?php foreach ($products as $k => $v): ?>
                <a href="Product?id=<?php echo $v['PRODUCTID'] ?>">
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
                    <!-- Brand -->
                    <h6><?php echo $v['BrandName'] ?></h6>
                    <!-- Price -->
                    <p><?php echo $v['Price'] ?></p>
                    <!-- Colors -->
                    <span><?php echo $v['ColorName'] ?></span>
                    <!-- Sizes -->
                    <span><?php echo $v['Size'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        <?php if (array_filter($products)): ?>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <ul class="pagination pagination-lg">
                    <li class="page-item disabled">
                    <a class="page-link" href="#">&laquo;</a>
                    </li>
                    <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                    <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                    <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                    <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item">
                    <a class="page-link" href="#">5</a>
                    </li>
                    <li class="page-item">
                    <a class="page-link" href="#">&raquo;</a>
                    </li>
                </ul>
            </div>
        <?php endif;?>
    </div>
</section>

<?php require_once('../template/footer.php'); ?>


<script>
    // async function fetchProducts(){
    //     const response = await fetch('_getproducts.php')
    //     .then(r => r.json())
    //     .then(data => console.log(data));
    // }
    // fetchProducts();

    // change price format

    // show sizes number
</script>