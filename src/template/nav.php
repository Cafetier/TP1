<!-- Nav -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav me-auto">
                <!-- Logo -->
                <li class="nav-item logo-nav">
                    <a class="nav-link" href="Index">
                        <img src="../../public/img/logo_full.svg" alt="Shoes Pro Shop Logo">
                    </a>
                </li>
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link active" href="Index">Accueil
                        <span class="visually-hidden">(current)</span>
                    </a>
                </li>
                <!-- Nouveaute -->
                <li class="nav-item">
                    <a class="nav-link" href="Shop">Magasiner</a>
                </li>
                <!-- More -->
                <li class="nav-item">
                    <a class="nav-link" href="About">À propos</a>
                </li>

                <?php if($user->IsLoggedIn()) : ?>
                    <!-- Account -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['Email'] ?> </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="Cart">Panier</a>
                            <a class="dropdown-item" href="Wishlist">Liste de souhait</a>
                            <a class="dropdown-item" href="Account">Modifier votre compte</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="?logout">Se déconnecter</a>
                        </div>
                    </li>
                <?php else : ?>
                    <!-- Login -->
                    <li class="nav-item">
                        <a class="nav-link" href="Login">Se connecter</a>
                    </li>

                    <!-- Register -->
                    <li class="nav-item">
                        <a class="nav-link" href="Register">S'inscrire</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>