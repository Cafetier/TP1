<?php 
$PageTitle = 'Votre compte';
require "../template/header.php";
require "../template/nav.php";

// if not logged redirect to register
if(!$user->IsLoggedIn()){
    header("Location: Register");  //redirect to the main page
    exit();
}
?>

<section class="container">
    <h1>Votre compte</h1>
</section>

<?php require_once('../template/footer.php'); ?>