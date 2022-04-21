<?php 
$PageTitle = 'Cart';
require "../template/header.php";
require "../template/nav.php";

// if not logged redirect to register
if(!$user->IsLoggedIn()){
    header("Location: Register");  //redirect to the main page
    exit();
}

// get all wishlisted items linked to the account in the session
$cart_items = $cart->GetAll($_SESSION['USERID']);

include_once "../template/alert.php";
?>

<section class="container">
    <h1>Cart</h1>
    <?php if (!array_filter($cart_items)): ?>
        <span>There is no items in your cart ! You can shop by going <a href="Shop">here</a> !</span>
    <?php endif;?>
    <!-- Cart items -->
    <div class="grid-4">
        <?php foreach($cart_items as $k=>$v): ?>
            <a href="Product?id=<?php echo $v['PRODUCTID']?>" class="product-card">
                <?php $pimg = json_decode($v['ImageName'], true) ?>
                <!-- caroussel -->
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- imgs -->
                        <?php foreach ($pimg as $kk => $vv) : ?>
                        <div class="carousel-item <?php if ($kk === 0) echo 'active' ?>">
                            <img src="../../public/products/<?php echo $vv ?>" alt="The image of the product">
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
                <h5><?php echo $v['ProductName'] ?></h5>
                <!-- Brand -->
                <h6><?php echo $v['BrandName'] ?></h6>
                <!-- Price -->
                <p><?php echo $v['Price'] ?></p>
                <!-- Size -->
                <span>Size <?php echo $v['Size'] ?></span><br>
                <hr>
                <!-- date added -->
                <span>Added : <?php echo $v['DateAdded'] ?></span> 
                <!-- Remove icon -->
                <i class="remove-btn"></i>

                        </a>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once('../template/footer.php'); ?>