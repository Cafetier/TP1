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

        // name regex which support multilanguage
        $this->NameRegex = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";
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
    public function UserExist($Email){
        if (empty($Email)) return;  // check if param empty
        // query and return query
        $user = $this->Query($this->db_conn, "SELECT * FROM User WHERE Email = ?", [$Email]);
        if(!empty($user)) return $user[0];
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
        // check if inputs are empty
        if (empty($FirstName || $LastName || $Email || $Password || $BirthDate || $Gender)) 
            throw new Error('Inputs must not be empty');

        // check if email using php filter_var()
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) throw new Error('Email is not valid');

        // check if names match name regex
        if (!preg_match($this->NameRegex, $FirstName) && !preg_match($this->NameRegex, $LastName))
            throw new Error('Name must not contain special letter');

        // check if gender is a number (for genderid)

        



        // check if email already exists in db
        $dbUser = $this->UserExist($Email);
        if (!empty($dbUser)) throw new Error('This email is already taken');

        // check if birth date > 1900 and more than the date of a 16 yo today
        $timeBirthDate = strtotime($BirthDate);
        if (strtotime("1900-01-01") < $timeBirthDate && $timeBirthDate < date('Y-m-d'))
            throw new Error('Your birth date is incorrect');

        // hash password
        $hashed_pwd = password_hash($Password, PASSWORD_DEFAULT);

        // create record in db
        try {
            $this->Query($this->db_conn, "INSERT INTO User 
            (LastName, FirstName, Email, Password, BirthDate, GENDERID)
            VALUES 
            (?, ?, ?, ?, ?, ?)", 
            [$LastName, $FirstName, $Email, $hashed_pwd, $BirthDate, $Gender]);
        } catch (Error $e) {
            if (__DEBUG__) echo $e;
        }
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

        // check if email using php filter_var()
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) throw new Error('Email is not valid');

        // check if the user exist in db
        $dbUser = $this->UserExist($Email);
        if (empty($dbUser)) throw new Error('This user does not exist');
        
        // check if hashed password is the same as db
        $pwDB = $dbUser['Password'];
        if (!password_verify($Password, $pwDB)) throw new Error('Password does not match');

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
     * Get a list of all genders
     * 
     * @return object a list of all genders
     * 
     */
    public function GetAllGenders(){
        // query and return query
        $genders = $this->Query($this->db_conn, "SELECT * FROM gender", []);
        return $genders;
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
        $sqlquery = 'UPDATE User SET LastName = ?, FirstName = ?, Email = ?, BirthDate = ?, GENDERID = ?';
        $param = [$LastName, $FirstName, $Email, $BirthDate, $Gender];
        // check if inputs are empty
        if (empty($FirstName || $LastName || $Email || $BirthDate || $Gender)) 
            throw new Error('Inputs must not be empty');

        // check if email using php filter_var()
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) throw new Error('Email is not valid');

        // check if names match name regex
        if (!preg_match($this->NameRegex, $FirstName) && !preg_match($this->NameRegex, $LastName))
            throw new Error('Name must not contain special letter');

        // check if birth date > 1900 and more than the date of a 16 yo today
        $timeBirthDate = strtotime($BirthDate);
        if (strtotime("1900-01-01") < $timeBirthDate && $timeBirthDate < date('Y-m-d'))
            throw new Error('Birth date incorrect');

        // if password not empty
        if (!empty($Password)){
            $sqlquery = $sqlquery.', Password = ?';  // append to query

            // hash password
            $hashed_pwd = password_hash($Password, PASSWORD_DEFAULT);

            // append to array
            array_push($param, $hashed_pwd);
        }

        // push email at the end
        array_push($param, $Email);

        // update record in db
        try {
            $this->Query($this->db_conn, $sqlquery." WHERE Email = ?", 
            $param);
        } catch (Error $e) {
            if (__DEBUG__) echo $e;
        }
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
}