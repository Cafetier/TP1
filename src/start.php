<?php
/**
 * This file jumpstart the app
 * - Instance classes
 * - create sessions
 * @author Dany Gauthier
 */
require_once 'constants.php';
require_once __ROOT__.'/src/class/DB.class.php';
require_once __ROOT__.'/src/class/User.class.php';
require_once __ROOT__.'/src/class/Product.class.php';
require_once __ROOT__.'/src/class/Cart.class.php';
require_once __ROOT__.'/src/class/Wishlist.class.php';

// init classes
$db = new Database();
$user = new User();
$product = new Product();
$cart = new Cart();
$wishlist = new Wishlist();

session_start();  // start the session