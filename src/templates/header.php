<?php
require_once '../start.php';
// if there is a logout get, then log the user out
if (isset($_GET['logout']) && $_SERVER["REQUEST_METHOD"] === "GET") {
    $user->logOut();
    unset($_GET['logout']);  //unset the logout
    header("Location: index.php");  //redirect to the main page
    exit();
}