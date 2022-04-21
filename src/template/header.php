<?php require_once '../Start.php'; ?>

<?php
    // if there is a logout get, then log the user out
    if(isset($_GET['logout']) && $_SERVER["REQUEST_METHOD"] === "GET"){
        $user->LogOut();
        unset($_GET['logout']);  //unset the logout
        header("Location: Index");  //redirect to the main page
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="x-ua-compatible" content="IE=Edge" />
        <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
        <link rel="stylesheet" href="../../public/css/style.css">
        <link rel="icon" type="image/x-icon" href="../../public/img/favicon.png">
        <title>SPS - <?php echo $PageTitle ?? '' ?></title>
    </head>
    <body class="preloader">