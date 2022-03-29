<?php

// if there is no error in url redirect to main page,
// dont want any lone wanderer to find this page
// without any good reason
if (!isset($_GET['error'])){
    //redirect to the main page
    header("Location: Index");
    exit();
}
$e = $_GET['error'];

$PageTitle = $e.' Error';
require "../template/header.php";
?>

<a href="Index">Retourner l'accueil</a>

<h1><?php echo $e; ?> Error</h1>

<?php require_once('../template/footer.php'); ?>