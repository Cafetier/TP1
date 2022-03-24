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

session_start();  // start the session