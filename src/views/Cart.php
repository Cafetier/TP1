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
    <?php print_r($cart_items)?>
    <?php if (!array_filter($cart_items)): ?>
        <span>There is no items in your cart ! You can shop by going <a href="Shop">here</a> !</span>
    <?php endif;?>
    <!-- Cart items -->
    <div class="grid-4">
        <?php foreach($cart_items as $k=>$v): ?>
            <div>
                <!-- images -->
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
                <?php echo $v['ProductName'] ?>
                <!-- Price -->
                <p><?php echo $v['Price'] ?></p>
                <!-- date added -->
                <span><?php echo $v['DateAdded'] ?></span>
                <!-- Size -->
                <span><?php echo $v['Size'] ?></span>
                <!-- Remove icon -->
                <i class="remove-btn"></i>

            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once('../template/footer.php'); ?>