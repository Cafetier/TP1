<nav id="nav" class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav me-auto">
                <!-- Logo -->
                <li class="nav-item logo-nav">
                    <a class="nav-link" href="index.php">
                        <img src="../../public/img/logo_full.svg" alt="Shoes Pro Shop Logo">
                    </a>
                </li>
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home
                        <!-- <a class="nav-link active" href="Index">Home -->
                        <!-- <span class="visually-hidden">(current)</span> -->
                    </a>
                </li>
                <!-- Nouveaute -->
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <!-- More -->
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>

                <?php if ($user->isLoggedIn()) : ?>
                    <!-- Account -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['Email'] ?> </a>
                        <div class="dropdown-menu">
                            <?php //<a class="dropdown-item" href="Cart">Cart</a>
                            ?>
                            <a class="dropdown-item" href="wishlist.php">Wishlist</a>
                            <a class="dropdown-item" href="account.php">Modify Account</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="?logout">Logout</a>
                        </div>
                    </li>
                <?php else : ?>
                    <!-- Login -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>

                    <!-- Register -->
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>