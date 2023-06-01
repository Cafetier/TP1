<?php

/**
 * This file handles all user interaction
 * Child class of Database (DB.class.php)
 * @author Dany Gauthier
 */
class User extends Database
{
    function __construct()
    {
        $this->dbConn = $this->connect();
        // name regex which support multilanguage
        $this->nameRegex = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";
    }

    /**
     * Used to check if a user exists
     * @param string    $email      Email of the user
     * 
     * @return array    returns the user if he exists
     */
    public function userExist($email)
    {
        if (empty($email)) return;  // check if param empty
        // query and return query
        $user = $this->query(
            $this->dbConn,
            "SELECT * FROM User WHERE Email = ?",
            [$email]
        );
        if (!empty($user)) return $user[0];
    }

    /**
     * Add the user to the bd
     * @param string    $FirstName
     * @param string    $LastName
     * @param string    $email
     * @param string    $Password
     * @param string    $BirthDate
     * @param string    $Gender
     */
    public function register($firstName, $lastName, $email, $password, $birthDate, $gender)
    {
        // check if inputs are empty
        if (empty($firstName || $lastName || $email || $password || $birthDate || $gender))
            throw new Error('Inputs must not be empty');

        // check if email using php filter_var()
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Error('Email is not valid');

        // check if names match name regex
        if (!preg_match($this->nameRegex, $firstName) || !preg_match($this->nameRegex, $lastName))
            throw new Error('Name must not contain special letter');

        // check if gender is a number (for genderid)
        if (!ctype_digit($gender)) throw new Error('Gender must be a number');

        // check if email already exists in db
        $dbUser = $this->userExist($email);
        if (!empty($dbUser)) throw new Error('This email is already taken');

        // check if birth date more than 1900
        $timeBirthDate = strtotime($birthDate) ?? '';
        if (strtotime("1900-01-01") > $timeBirthDate)
            throw new Error('Your birth date is incorrect');

        // check if at least 16 yo
        if ($timeBirthDate > strtotime((date('Y') - 16) . "-" . date('m-d')))
            throw new Error('You must be at least 16 years old to use this website');

        // hash password
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

        // create record in db
        try {
            $this->query(
                $this->dbConn,
                "INSERT INTO User 
            (LastName, FirstName, Email, Password, BirthDate, GENDERID)
            VALUES 
            (?, ?, ?, ?, ?, ?)",
                [$lastName, $firstName, $email, $hashedPwd, $birthDate, $gender]
            );
        } catch (Error) {
            throw new Error('There was an error');
        }
    }


    /**
     * Add the user to the bd
     * @param string    $email
     * @param string    $Password
     */
    public function login($email, $password)
    {
        // check if inputs are not empty
        if (empty($email || $password))
            throw new Error('Inputs must not be empty');

        // check if email using php filter_var()
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new Error('Email is not valid');

        // check if the user exist in db
        $dbUser = $this->userExist($email);
        if (empty($dbUser))
            throw new Error('This user does not exist');

        // check if hashed password is the same as db
        $pwDB = $dbUser['Password'];
        if (!password_verify($password, $pwDB))
            throw new Error('Password does not match');

        // update LastLogin
        $genders = $this->query(
            $this->dbConn,
            "UPDATE User SET LastLogin = NOW() WHERE USERID=?",
            [$dbUser['USERID']]
        );

        $this->logOut(); // destroy active session if there is
        session_start(); // start sessions handler

        // Set sessions attributes to user id
        $_SESSION['USERID'] = $dbUser['USERID'];
        $_SESSION['LastName'] = $dbUser['LastName'];
        $_SESSION['FirstName'] = $dbUser['FirstName'];
        $_SESSION['Email'] = $dbUser['Email'];
    }

    /**
     * Get a list of all genders
     * @return object a list of all genders
     */
    public function GetAllGenders()
    {
        return $this->query($this->dbConn, "SELECT * FROM Gender ORDER BY GENDERID", []);
    }

    /**
     * Update information of the user
     * @param string    $FirstName
     * @param string    $LastName
     * @param string    $email
     * @param string    $Password
     * @param string    $BirthDate
     * @param string    $Gender
     */
    public function updateInformations($firstName, $lastName, $email, $password, $birthDate, $gender)
    {
        $sqlquery = 'UPDATE User SET LastName = ?, FirstName = ?, Email = ?, BirthDate = ?, GENDERID = ?';
        $param = [$lastName, $firstName, $email, $birthDate, $gender];
        // check if inputs are empty
        if (empty($firstName || $lastName || $email || $birthDate || $gender))
            throw new Error('Inputs must not be empty');

        // check if email using php filter_var()
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new Error('Email is not valid');

        // check if names match name regex
        if (!preg_match($this->nameRegex, $firstName) && !preg_match($this->nameRegex, $lastName))
            throw new Error('Name must not contain special letter');

        // check if birth date > 1900 and more than the date of a 16 yo today
        $timeBirthDate = strtotime($birthDate);
        if (strtotime("1900-01-01") < $timeBirthDate && $timeBirthDate < date('Y-m-d'))
            throw new Error('Birth date incorrect');

        // if password not empty
        if (!empty($password)) {
            $sqlquery = $sqlquery . ', Password = ?';  // append to query

            // hash password
            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

            // append to array
            array_push($param, $hashedPwd);
        }

        // push email at the end
        array_push($param, $email);

        // update record in db
        try {
            $this->query(
                $this->dbConn,
                $sqlquery . " WHERE Email = ?",
                $param
            );
        } catch (Error $e) {
            if (__DEBUG__) echo $e;
        }
    }

    /**
     * Check if the user as a session id
     * @return bool
     */
    public function isLoggedIn()
    {
        isset($_SESSION['USERID']);
    }

    /**
     * Log out the user, 
     * destroy active session and unset them
     */
    public function logOut()
    {
        session_unset();
        session_destroy();
    }
}
