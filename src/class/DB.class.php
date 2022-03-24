<?php

class Database{
    /**
     * Used to connect to database using PDO
     * 
     * @author          Dany Gauthier
     * @return object   Connection of the database
     */
    protected function Connect(){
        try {
            $conn = new PDO("mysql:host=".dbHost.";dbname=".dbDB, dbUsername, dbPW);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully"; 
            return $conn;
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Short hand for prepared statement
     * 
     * @param string $DBConn    Database connection
     * @param string $SQLQuery  SQL QUERY (Needs to be ? for value)
     * @param string $SQLVType  SQL value type (s = string, i = int, d = double, b = blob)
     * @param string $SQLValue  SQL VALUE (value of ?)
     * 
     * @author          Dany Gauthier
     * @return object   the result of the query
     * 
     */
    protected function Query($DBConn, $SQLQuery, $SQLVType, $SQLValue){
        // prepare the sql
        $sth = $DBConn->prepare($SQLQuery);
        $sth->bind_param($SQLVType, $SQLValue);  // bind the attributes

        // check if the code ran successfully
        if ($sth->execute()) {
            echo "New record created successfully";
            return $sth;
        } else {
            die("Error: " . $DBConn->error);
        }
    }
}