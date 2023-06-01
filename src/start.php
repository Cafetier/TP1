<?php
/**
 * This file jumpstart the app
 * - Instance classes
 * - create sessions
 * @author Dany Gauthier
 */
require_once 'constants.php';
require_once __ROOT__.'/src/classes/db.class.php';
require_once __ROOT__.'/src/classes/user.class.php';
require_once __ROOT__.'/src/classes/product.class.php';
require_once __ROOT__.'/src/classes/cart.class.php';
require_once __ROOT__.'/src/classes/wishlist.class.php';

// init classes
$db = new Database();
$user = new User();
$product = new Product();
$cart = new Cart();
$wishlist = new Wishlist();

session_start();  // start the session