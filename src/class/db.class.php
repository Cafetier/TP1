<?php

/**
 * Database file used to manage connection of the database
 * This is a parent classs
 * @author Dany Gauthier
 */
class Database
{
    /**
     * Used to connect to database using PDO
     * @return object   Connection of the database
     */
    protected function Connect()
    {
        try {
            $conn = new PDO("mysql:host=" . dbHost . ";dbname=" . dbDB, dbUsername, dbPW);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            // give more info if debug is true
            if (__DEBUG__) exit("Connection failed: " . $e->getMessage());
            exit("There was an error");
        }
    }

    /**
     * Short hand for prepared statement
     * @param string    $DBConn    Database connection
     * @param string    $SQLQuery  SQL QUERY (Needs to be ? for value)
     * @param array     $SQLValue  SQL VALUE (value of ?)
     * 
     * @return object   the result of the query
     */
    protected function Query($DBConn, $SQLQuery, $SQLValue)
    {
        // print the query if debug is true
        if (__DEBUG__) echo ($SQLQuery . '<br><br>');

        // count the number of ? (prepared var) in query
        if (substr_count($SQLQuery, '?') !== count($SQLValue))
            throw new Error('Number of param does not match number of value');

        // prepare the sql
        $sth = $DBConn->prepare($SQLQuery);
        // check if the code ran successfully
        if ($sth->execute($SQLValue)) {
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // doesnt give error if error in query if debug is false
            if (__DEBUG__) exit($DBConn->error);
        }
    }


    /**
     * Check if string is json 
     * @param string $string    the string you want to test
     * @return object the decoded json or nothing
     */
    public function isJson($string)
    {
        $json_data = json_decode($string, true);
        if ($json_data !== null) return $json_data;
    }
}
