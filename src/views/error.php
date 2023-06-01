<?php

// if there is no error in url redirect to main page,
// dont want any lone wanderer to find this page
// without any good reason
if (!isset($_GET['error'])){
    //redirect to the main page
    header("Location: index.php");
    exit();
}
$e = $_GET['error'];

$PageTitle = $e;
require "../templates/header.php";
require "../templates/nav.php";

include_once "../templates/alert.php";
?>
<section class="container">
    <a href="index.php">Go Back To Homepage</a>
    <h1><?php echo $e; ?> Error</h1>
</section>

<?php require_once('../templates/footer.php'); ?>