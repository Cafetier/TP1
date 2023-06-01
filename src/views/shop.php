<?php 
$PageTitle = 'Shop';
require "../templates/header.php";
require "../templates/nav.php";

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
            $filters['Color'] = $v;
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

// check if post request
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $pid = $_POST['PRODUCTID'] ?? null;

    // remove item from wishlist
    try{
        $wishlist->Add($pid, $_SESSION['USERID']);
        $success = 'Item successfully added to wishlist !';
    }
    catch(Error $e){
        $error = $e->getMessage();
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
include_once "../templates/alert.php";
?>

<section class="container" id="shop_page">
    <!-- Filters -->
    <div id="filter_side">
        <h3>Filters</h3>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="get">
            <!-- Rechercher -->
            <div>
                <div class="filter-title">
                    <h5>Search</h5>
                    <div>
                        <input type="checkbox" class="form-check-input" 
                        <?php echo !empty($_GET['Name'])? 'checked': '' ?>>
                    </div>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" id="SearchInput" name="Name" placeholder="Search" value="<?php echo $_GET['Name'] ?? '' ?>">
                    <label for="SearchInput">Search</label>
                </div>
            </div>
            <!-- Brand -->
            <div>
                <div class="filter-title">
                    <h5>Brand</h5>
                    <div>
                        <input type="checkbox" class="form-check-input"
                        <?php echo !empty($_GET['Brand'])? 'checked': '' ?>>
                    </div>
                </div>
                <div class="grid-2">
                    <?php foreach ($categories['Brands'] as $k => $v): ?>
                        <label class="form-check-label" for="<?php echo $v['bName'] ?>">
                            <!-- Input -->
                            <input class="form-check-input" type="checkbox" 
                            name="Brand[]" 
                            value="<?php echo $v['bName'] ?>" id="<?php echo $v['bName'] ?>"

                            <?php if(is_array($_GET['Brand'] ?? '') && in_array($v['bName'], $_GET['Brand'] ?? [])) echo 'checked' ?>
                            >

                            <!-- Text -->
                            <span><?php echo $v['bName'] ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Types -->
            <div>
                <div class="filter-title">
                    <h5>Types</h5>
                    <div>
                        <input type="checkbox" class="form-check-input"
                        <?php echo !empty($_GET['Type'])? 'checked': '' ?>>
                    </div>
                </div>
                <?php foreach ($categories['Types'] as $k => $v): ?>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="Type" value="<?php echo $v['tName'] ?>"
                            <?php if(($_GET['Type'] ?? '') === $v['tName']) echo 'checked' ?>
                            >
                            <span><?php echo $v['tName'] ?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Colors -->
            <div>
                <div class="filter-title">
                    <h5>Colors</h5>
                    <div>
                        <input type="checkbox" class="form-check-input"
                        <?php echo !empty($_GET['Color'])? 'checked': '' ?>>
                    </div>
                </div>
                <select class="form-select" name="Color">
                    <option value="" hidden>Color</option>
                    <?php foreach ($categories['Colors'] as $k => $v): ?>
                        <option value="<?php echo $v['cName'] ?>" <?php if(($_GET['Color'] ?? '') === $v['cName']) echo 'selected' ?>>
                            <?php echo $v['cName'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Sizes -->
            <div>
                <div class="filter-title">
                    <h5>Sizes</h5>
                    <h6>9.5</h6>
                    <div>
                        <input type="checkbox" class="form-check-input"
                        <?php echo !empty($_GET['Size'])? 'checked': '' ?>>
                    </div>
                </div>
                <div id="sizes_div">
                    <div>
                        <span>5</span>
                        <span>13</span>
                    </div>
                    <input type="range" class="form-range" 
                    min="5" max="13" step="0.5" name="Size" 
                    value="<?php echo !empty($_GET['Size'])? $_GET['Size'] : '' ?>">
                </div>
            </div>

            <!-- Price -->
            <div>
                <div class="filter-title">
                    <h5>Price</h5>
                    <div>
                        <input type="checkbox" class="form-check-input"
                        <?php echo !empty($_GET['Price'])? 'checked': '' ?>>
                    </div>
                </div>
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
            </div>

            <!-- Submit && reset -->
            <div>
                <!-- Submit btn -->
                <div class="row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary col">Update</button>
                    </div>
                </div>
                <!-- Reset btn -->
                <div class="row">
                    <div class="col text-center">
                        <button type="reset" class="btn btn-primary col" id="filter_reset">Reset</button>
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
                <!-- <a href="Product?id=<?php echo $v['PRODUCTID'] ?>" class="product-card"> -->
                <a href="#" class="product-card">
                    <?php 
                    $pimg =         json_decode($v['Images'], true);
                    //$ColorName =    array_unique(json_decode($v['cName'], true));
                    ?>
                    <!-- caroussel -->
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <!-- imgs -->
                            <?php foreach ($pimg as $kk => $vv) : ?>
                            <div class="carousel-item <?php if ($kk === 0) echo 'active' ?>">
                                <img src="../../public/img/products/<?php echo $vv['Name'] ?? '' ?>" 
                                alt="<?php echo $vv['Alt'] ?? '' ?>"
                                title="<?php echo $vv['Title'] ?? '' ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- back -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <!-- forth -->
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <!-- Name -->
                    <h4><?php echo $v['pName'] ?></h4>
                    <!-- Brand -->
                    <h6><?php echo $v['bName'] ?></h6>
                    <!-- Price -->
                    <p><?php echo $v['Price'] ?></p>
                    <!-- add btn -->
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                        <input type="text" name="PRODUCTID" value="<?php echo $v['PRODUCTID'] ?>" hidden>
                        <button type="submit" class="remove_btn">Add Wishlist</button>
                    </form>
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

<?php require_once('../templates/footer.php'); ?>


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