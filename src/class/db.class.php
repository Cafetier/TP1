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
    protected function Query($dbConn, $sqlQuery, $sqlValues)
    {
        // print the query if debug is true
        if (__DEBUG__) echo ($sqlQuery . '<br><br>');

        // count the number of ? (prepared var) in query
        if (substr_count($sqlQuery, '?') !== count($sqlValues))
            throw new Error('Number of parameters does not match number of values');

        try {
            $stmt = $dbConn->prepare($sqlQuery);
            $stmt->execute($sqlValues);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            __DEBUG__ ? 
                exit($e->getMessage()):
                throw $e;
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
