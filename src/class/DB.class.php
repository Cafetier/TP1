<?php

/**
 * 
 * Database file used to manage connection of the database
 * This is a parent classs
 * 
 * @author Dany Gauthier
 * 
 */

class Database{
    /**
     * 
     * Used to connect to database using PDO
     * 
     * @return object   Connection of the database
     */
    protected function Connect(){
        try {
            $conn = new PDO("mysql:host=".dbHost.";dbname=".dbDB, dbUsername, dbPW);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            // give more info if debug is true
            if (__DEBUG__) exit("Connection failed: " . $e->getMessage());
            exit("There was an error");
        }
    }

    /**
     * 
     * Short hand for prepared statement
     * 
     * @param string    $DBConn    Database connection
     * @param string    $SQLQuery  SQL QUERY (Needs to be ? for value)
     * @param array     $SQLValue  SQL VALUE (value of ?)
     * 
     * @return object   the result of the query
     * 
     */
    protected function Query($DBConn, $SQLQuery, $SQLValue){
        // prepare the sql
        $sth = $DBConn->prepare($SQLQuery);
        // check if the code ran successfully
        if ($sth->execute($SQLValue)) {
            return $sth->fetch(PDO::FETCH_ASSOC);
        } else {
            exit($DBConn->error);
        }
    }
}