<?php

/**
 * 
 * This file handles all user interaction
 * Child class of Database (DB.class.php)
 * 
 * @author Dany Gauthier
 * 
 */

class User extends Database{
    function __construct()
    {
        // create a db connection using parent function
        $this->db_conn = $this->Connect();
    }

    /**
     * 
     * Used to check if a user exists
     * 
     * @param string    $Email      Email of the user
     * 
     * @return array    returns the user if he exists
     * 
     */
    private function UserExist($Email){
        if (empty($Email)) return;  // check if param empty
        // query and return query
        $user = $this->Query($this->db_conn, "SELECT * FROM User WHERE Email = ?", [$Email]);
        return $user;
    }

    /**
     * 
     * Add the user to the bd
     * 
     * @param string    $FirstName
     * @param string    $LastName
     * @param string    $Email
     * @param string    $Password
     * @param string    $BirthDate
     * @param string    $Gender
     * 
     */
    public function Register($FirstName, $LastName, $Email, $Password, $BirthDate, $Gender){
    }


    /**
     * 
     * Add the user to the bd
     * 
     * @param string    $Email
     * @param string    $Password
     * 
     */
    public function Login($Email, $Password){
        // check if inputs are not empty
        if (empty($Email || $Password)) throw new Error('Inputs must not be empty');

        // check if the user exist in db
        $dbUser = $this->UserExist($Email);
        if (empty($dbUser)) throw new Error('User does not exist');
        
        // check if hashed password is the same as db
        $pwDB = $dbUser['Password'];
        if (!password_verify($Password, $pwDB)) throw new Error('There was an error');

        $this->LogOut(); // destroy active session if there is
        session_start(); // start sessions handler
        // Set sessions attributes to user id
        $_SESSION['USERID'] = $dbUser['USERID'];
        $_SESSION['LastName'] = $dbUser['LastName'];
        $_SESSION['FirstName'] = $dbUser['FirstName'];
        $_SESSION['Email'] = $dbUser['Email'];
    }


    /**
     * 
     * Update information of the user
     * 
     * @param string    $FirstName
     * @param string    $LastName
     * @param string    $Email
     * @param string    $Password
     * @param string    $BirthDate
     * @param string    $Gender
     * 
     */
    public function UpdateInformations($FirstName, $LastName, $Email, $Password, $BirthDate, $Gender){
    }
    
    /**
     * 
     * Check if the user as a session id
     * 
     * @return bool
     * 
     */
    public function IsLoggedIn(){
        // check if there is a session
        if (isset($_SESSION['USERID'])) return true;

        // by default return false
        return false;
    }

    /**
     * 
     * Log out the user, 
     * destroy active session and unset them
     * 
     */
    public function LogOut(){
        // Destroy and unset active session
        session_unset();
        session_destroy();
    }

    public function AddProductWishlist(){

    }

    public function RemoveProductWishlist(){
        
    }

    public function AddProductCart(){

    }

    public function RemoveProductCart(){
        
    }
}