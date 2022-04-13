<?php 
$PageTitle = 'Wishlist';
require "../template/header.php";
require "../template/nav.php";

// if not logged redirect to register
if(!$user->IsLoggedIn()){
    header("Location: Register");  //redirect to the main page
    exit();
}

// get all wishlisted items linked to the account in the session
$wishlist_items = $cart->GetAll($_SESSION['USERID']);
?>
<section class="container">
    <h1>Wishlist</h1>
    <?php print_r($wishlist_items)?>
</section>

<?php require_once('../template/footer.php'); ?>