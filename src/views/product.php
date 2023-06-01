<?php 
$PageTitle = 'Product';
require "../templates/header.php";
require "../templates/nav.php";

// check if post request
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $pid = $_POST['PRODUCTID'] ?? null;
    $_GET['id'] = $_POST['PRODUCTID'] ?? null;

    // remove item from wishlist
    try{
        $wishlist->add($pid, $_SESSION['USERID']);
        $success = 'Item successfully added to wishlist !';
    }
    catch(Error $e){
        $error = $e->getMessage();
    }
}

// if there is no get and no id
$urlID = $_GET['id'] ?? null;
if (!ctype_digit($urlID)){
    header("Location: index.php");  //redirect to the main page
    exit();
}

// check if there is a product, returns the product info
$product_info = $product->getProduct($urlID);

// if id of product doest exist
if (empty($product_info)) echo 'There is no product';

print_r($product_info);

include_once "../templates/alert.php";
?>

<section class="container">
    <!-- back icon -->
    <a href="shop.php" class="back_btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M256 0C114.6 0 0 114.6 0 256c0 141.4 114.6 256 256 256s256-114.6 256-256C512 114.6 397.4 0 256 0zM310.6 345.4c12.5 12.5 12.5 32.75 0 45.25s-32.75 12.5-45.25 0l-112-112C147.1 272.4 144 264.2 144 256s3.125-16.38 9.375-22.62l112-112c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L221.3 256L310.6 345.4z"/>
        </svg>
    </a>

    <!-- add to wishlist btn -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
        <input type="text" name="PRODUCTID" value="<?php echo $product_info['PRODUCTID'] ?>" hidden>
        <button type="submit" class="remove_btn">Add Wishlist</button>
    </form>
</section>

<?php require_once('../templates/footer.php'); ?>