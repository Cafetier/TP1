<?php 
$PageTitle = 'Wishlist';
require "../template/header.php";
require "../template/nav.php";

// if not logged redirect to register
if(!$user->IsLoggedIn()){
    header("Location: Register");  //redirect to the main page
    exit();
}

// check if post request
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $pid = $_POST['PRODUCTID'] ?? null;

    // remove item from wishlist
    try{
        $wishlist->Remove($pid, $_SESSION['USERID']);
        $success = 'Item successfully deleted !';
    }
    catch(Error $e){
        $error = $e->getMessage();
    }
}

// get all wishlisted items linked to the account in the session
$wishlist_items = $wishlist->GetAll($_SESSION['USERID']) ?? [];

include_once "../template/alert.php";
?>
<section class="container">
    <h1>Wishlist</h1>
    <?php if (!array_filter($wishlist_items)): ?>
        <span>There is no items in your wishlist ! You can check out what's new <a href="Shop?Order=DESC">here</a> !</span>
    <?php endif;?>
    <!-- Cart items -->
    <div class="grid-4">
        <?php foreach($wishlist_items as $k=>$v): ?>
            <!-- <a href="Product?id=<?php echo $v['PRODUCTID']?>" class="product-card"> -->
            <a href="#" class="product-card">
                <?php $pimg = json_decode($v['Images'], true) ?>
                <!-- caroussel -->
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- imgs -->
                        <?php foreach ($pimg as $kk => $vv) : ?>
                        <div class="carousel-item <?php if ($kk === 0) echo 'active' ?>">
                            <img src="../../public/products/<?php echo $vv['Name'] ?? '' ?>" 
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
                <h5><?php echo $v['pName'] ?></h5>
                <!-- Brand -->
                <h6><?php echo $v['bName'] ?></h6>
                <!-- Price -->
                <p><?php echo $v['Price'] ?></p>
                <hr>
                <!-- date added -->
                <span>Added : <?php echo $v['DateAdded'] ?></span> 
                <!-- Remove btn -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                    <input type="text" name="PRODUCTID" value="<?php echo $v['PRODUCTID'] ?>" hidden>
                    <button type="submit" class="remove_btn">Remove</button>
                </form>

            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once('../template/footer.php'); ?>