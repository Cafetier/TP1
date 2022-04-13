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
?>
<section class="container">
    <h1>Cart</h1>
    <?php print_r($cart_items)?>
</section>

<?php require_once('../template/footer.php'); ?>