<?php require_once '../Start.php'; ?>

<?php
    // if there is a logout get, then log the user out
    if(isset($_GET['logout']) && $_SERVER["REQUEST_METHOD"] === "GET"){
        $user->LogOut();
        unset($_GET['logout']);  //unset the logout
        header("Location: Index.php");  //redirect to the main page
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../public/css/style.css">
        <title><?php echo $PageTitle; ?></title>
    </head>
    <body class="preloader">
        <!-- Nav -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor03">
                    <ul class="navbar-nav me-auto">
                        <!-- Home -->
                        <li class="nav-item">
                            <a class="nav-link active" href="Index.php">Accueil
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        <!-- More -->
                        <li class="nav-item">
                            <a class="nav-link" href="About.php">À propos</a>
                        </li>

                        <?php if($user->IsLoggedIn()) : ?>
                            <!-- Account -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Mon compte</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="Account.php">Modifier votre compte</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="?logout">Se déconnecter</a>
                                </div>
                            </li>
                        <?php else : ?>
                            <!-- Login -->
                            <li class="nav-item">
                                <a class="nav-link" href="Login.php">Se connecter</a>
                            </li>

                            <!-- Register -->
                            <li class="nav-item">
                                <a class="nav-link" href="Register.php">S'inscrire</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>