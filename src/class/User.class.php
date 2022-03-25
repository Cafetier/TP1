<?php

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
     * @author          Dany Gauthier
     * @return array    returns the user if he exists
     * 
     */
    private function UserExist($Email){
        if (empty($Email)) return;  // check if param empty
        // query and return query
        $user = $this->Query($this->db_conn, "SELECT Email FROM User WHERE Email = ?", [$Email]);
        return $user[0];
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
     * @author          Dany Gauthier
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
     * @author          Dany Gauthier
     * 
     */
    public function Login($Email, $Password){
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
     * @author          Dany Gauthier
     * 
     */
    public function UpdateInformations($FirstName, $LastName, $Email, $Password, $BirthDate, $Gender){
    }
    
    /**
     * 
     * Check if the user as a session id, if he is logged in
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
     * Log out the user, destroy active session and unset them
     * 
     */
    public function LogOut(){
        // Destroy and unset active session
        session_unset();
        session_destroy();
    }
}