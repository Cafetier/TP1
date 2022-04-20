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
/**
 * 
 * This needs to move into Product->GetAllProduct
 * 
 * 
 */
$filters = [];
foreach ($_GET as $k => $v) {
    if (empty($v)) continue;
    switch ($k) {
        case 'Brand':
            // convert to array if it is not already
            if (!is_array($v)) break;
            $filters['Brand'] = $v;
            break;
            
        case 'Color':
            $filters['ColorName'] = $v;
            break;

        case 'Name':
            $filters['Name'] = $v;
            break;

        case 'Size':
            $filters['Size'] = $v;
            break;

        case 'Type':
            $filters['Type'] = $v;
            break;

        case 'Price':
            // check if not array and not contains only 2 numbers
            if (!is_array($v) || !ctype_digit($v[0]) || !ctype_digit($v[1])) break;
            $filters['Price'] = $v;
            break;

        case 'Order':
            if ($v === 'DESC' || $v === 'ASC') $filters['Order'] = $v;
            break;
    }
}

// fetch products
try{
    $products = $product->GetAllProduct(0, $filters);
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
            <!-- Rechercher -->
            <div class="filter-title"><h5>Rechercher</h5></div>
            <div class="form-floating">
                <input type="text" class="form-control" id="SearchInput" name="Name" placeholder="Rechercher" value="<?php echo $_GET['Name'] ?? '' ?>">
                <label for="SearchInput">Rechercher</label>
            </div>
            <!-- Brand -->
            <div class="filter-title"><h5>Brand</h5></div>
            <div class="grid-2">
                <?php foreach ($categories['Brands'] as $k => $v): ?>
                    <label class="form-check-label" for="<?php echo $v['BrandName'] ?>">
                        <!-- Input -->
                        <input class="form-check-input" type="checkbox" 
                        name="Brand[]" 
                        value="<?php echo $v['BrandName'] ?>" id="<?php echo $v['BrandName'] ?>"

                        <?php if(is_array($_GET['Brand'] ?? '') && in_array($v['BrandName'], $_GET['Brand'] ?? [])) echo 'checked' ?>
                        >

                        <!-- Text -->
                        <?php echo $v['BrandName'] ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <!-- Types -->
            <div class="filter-title"><h5>Types</h5></div>
            <?php foreach ($categories['Types'] as $k => $v): ?>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="Type" value="<?php echo $v['TypeName'] ?>"
                        <?php if(($_GET['Type'] ?? '') === $v['TypeName']) echo 'checked' ?>
                        >
                        <?php echo $v['TypeName'] ?>
                    </label>
                </div>
            <?php endforeach; ?>

            <!-- Colors -->
            <div class="filter-title"><h5>Colors</h5></div>
            <select class="form-select" name="Color">
                <option value="" hidden>Color</option>
                <?php foreach ($categories['Colors'] as $k => $v): ?>
                    <option value="<?php echo $v['ColorName'] ?>" <?php if($_GET['Color'] === $v['ColorName']) echo 'selected' ?>>
                        <?php echo $v['ColorName'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Sizes -->
            <div class="filter-title"><h5>Sizes</h5><h6>9.5</h6></div>
            <div id="sizes_div">
                <div>
                    <span>5</span>
                    <span>13</span>
                </div>
                <input type="range" class="form-range" 
                min="5" max="13" step="0.5" name="Size" 
                value="<?php echo !empty($_GET['Size'])? $_GET['Size'] : '' ?>">
            </div>

            <!-- Price -->
            <div class="filter-title"><h5>Price</h5></div>
            <!-- min -->
            <div class="form-floating ">
                <input type="number" class="form-control" id="floatingInput" name="Price[]" placeholder="Min" value="<?php echo $_GET['Price'][1] ?? '' ?>">
                <label for="floatingInput">Min</label>
            </div>
            <!-- max -->
            <div class="form-floating">
                <input type="number" name="Price[]" class="form-control" id="floatingPassword" placeholder="Max" value="<?php echo $_GET['Price'][0] ?? '' ?>">
                <label for="floatingPassword">Max</label>
            </div>

            <!-- Submit && reset -->
            <div>
                <!-- Submit btn -->
                <div class="row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary col ">Update</button>
                    </div>
                </div>
                <!-- Reset btn -->
                <div class="row">
                    <div class="col text-center">
                        <button type="reset" class="btn btn-primary col ">Reset</button>
                    </div>
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
        <!-- <?php //if (array_filter($products)): ?>
            Pagination
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
        <?php //endif;?> -->
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

    // change price text on input
    const size_txt = document.querySelector(".filter-title > h6");
    const size_input = document.querySelector("#sizes_div > input[type=range]");
    size_txt.textContent = size_input.value;
    size_input.oninput = e =>{
        const t = e.target;
        size_txt.textContent = t.value;
    };
</script>