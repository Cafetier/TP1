<?php

/**
 * 
 * This file handle all the cart interactions
 * 
 * @author Dany Gauthier
 * 
 */

class Cart extends Database{
    function __construct()
    {
        // create a db connection using parent function
        $this->db_conn = $this->Connect();
    }

    /**
     * 
     * Add item to cart
     * 
     */
    public function Add($ProductID, $UserID){
        // check if inputs are not empty and are numbers
        if (empty($UserID || $ProductID) && ctype_digit($UserID && $ProductID))
            throw new Error('Param must not be empty and must be numbers');

        // query the db to remove the product
        try {
            $this->Query($this->db_conn, 
            'INSERT INTO cart c (c.PRODUCTID, c.USERID)
            VALUES (?, ?)', 
            [$ProductID, $UserID]);
        } catch (Error $e) {
            return $e;
        }
    }

    /**
     * 
     * Remove item from cart
     * 
     */
    public function Remove($ProductID, $UserID){
        // check if inputs are not empty and are numbers
        if (empty($UserID || $ProductID) && ctype_digit($UserID && $ProductID))
            throw new Error('Param must not be empty and must be numbers');

        // query the db to remove the product
        try {
            $this->Query($this->db_conn, 
            'DELETE FROM cart c WHERE c.PRODUCTID = ? AND c.USERID = ?', 
            [$ProductID, $UserID]);
        } catch (Error $e) {
            return $e;
        }
    }

    /**
     * 
     * Get items from cart
     * 
     * @return object all the items in the cart
     * 
     */
    public function GetAll($UserID){
        // check if inputs are not empty and are numbers
        if (empty($UserID) && ctype_digit($UserID))
            throw new Error('id must not be empty and must be a number');

        $sql_query = "SELECT
        u.USERID,
        c.DateAdded,
        p.PRODUCTID,
        p.ProductName,
        p.ProductDescription,
        p.Price,
        p.DateCreated,
        t.TypeName,
        b.BrandName,
        s.Size,
        JSON_ARRAYAGG(i.ImageName) AS ImageName
        FROM cart c
            -- products
        LEFT JOIN product p ON c.PRODUCTID = p.PRODUCTID
            -- user
        LEFT JOIN USER u ON c.USERID = u.USERID
            -- type
        LEFT JOIN ptype t ON t.TYPEID = p.TYPEID
            -- brand
        LEFT JOIN brand b ON b.BRANDID = p.BRANDID
            -- sizes
        LEFT JOIN psize_product sp ON sp.PRODUCTID = p.PRODUCTID
        LEFT JOIN psize s ON s.SIZEID = sp.SIZEID
            -- images
        LEFT JOIN pimage_product ip ON ip.PRODUCTID = p.PRODUCTID
        LEFT JOIN pimage i ON i.IMAGEID = ip.IMAGEID
        WHERE u.USERID = ?
        GROUP BY s.Size";

        // query the cart of the user
        try {
            $result = $this->Query($this->db_conn, $sql_query, [$UserID]);
            return $result;
        } catch (Error $e) {
            if (__DEBUG__) echo $e;
        }
    }
}