<?php
/**
 * 
 * This file jumpstart the app
 * Instance classes
 * create sessions
 * 
 * @author Dany Gauthier
 * 
 */

require_once 'constants.php';
require_once __ROOT__.'/src/class/DB.class.php';
require_once __ROOT__.'/src/class/User.class.php';
require_once __ROOT__.'/src/class/Product.class.php';

$user = new User(); // init database class
$product = new Product(); // init database class

session_start();  // start the session