<?php

/**
 * This file handle all the cart interactions
 * @author Dany Gauthier
 */
class Cart extends Database
{
    function __construct()
    {
        $this->dbConn = $this->connect();
    }

    /**
     * Add item to cart
     */
    public function add($productID, $userID)
    {
        // check if inputs are not empty and are numbers
        if (
            empty($userID) ||
            empty($productID) ||
            !ctype_digit($userID) ||
            !ctype_digit($productID)
        )
            throw new InvalidArgumentException(
                'Invalid parameters: must not be empty and must be numbers'
            );

        // query the db to remove the product
        try {
            $this->Query(
                $this->dbConn,
                'INSERT INTO cart c (c.PRODUCTID, c.USERID)
            VALUES (?, ?)',
                [$productID, $userID]
            );
        } catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Remove item from cart
     */
    public function remove($productID, $userID)
    {
        // check if inputs are not empty and are numbers
        if (
            empty($userID) ||
            empty($productID) ||
            !ctype_digit($userID) ||
            !ctype_digit($productID)
        )
            throw new InvalidArgumentException(
                'Invalid parameters: must not be empty and must be numbers'
            );

        // query the db to remove the product
        try {
            $this->Query(
                $this->dbConn,
                'DELETE FROM cart WHERE PRODUCTID = ? AND USERID = ?',
                [$productID, $userID]
            );
        } catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Get items from cart
     * @return object all the items in the cart
     */
    public function getAll($userID)
    {
        // check if inputs are not empty and are numbers
        if (empty($userID) || !ctype_digit($userID))
            throw new InvalidArgumentException(
                'Invalid parameter: ID must not be empty and must be a number'
            );

        $sqlQuery = "SELECT
        u.USERID,
        p.PRODUCTID,
        w.CARTID, w.DateAdded,
        p.pName, p.pDescription, p.Price,
        s.Size,
        c.cName, HEX(c.Hex) as color_hex,
        b.bName, 
        t.tName,
        JSON_ARRAYAGG(
            JSON_OBJECT(
                'Name', i.iName,
                'Alt', i.Alt,
                'Title', i.Title
            )
        ) AS Images
        
        FROM cart w
        
        -- sizes
        LEFT JOIN size s ON s.SIZEID=w.SIZEID
        -- product
        LEFT JOIN product p ON w.PRODUCTID=w.PRODUCTID
        -- color
        LEFT JOIN color c ON c.COLORID=w.COLORID
        -- user
        LEFT JOIN user u ON w.USERID=u.USERID
        -- brand
        LEFT JOIN brand b ON p.BRANDID=b.BRANDID
        -- type
        LEFT JOIN ptype t ON t.TYPEID=p.TYPEID
        -- images
        LEFT JOIN pimage_product ip ON ip.PRODUCTID=p.PRODUCTID
        LEFT JOIN pimage i ON i.IMAGEID=ip.IMAGEID

        WHERE u.USERID=?
        
        GROUP BY w.CARTID
        ORDER BY w.DateAdded DESC";

        // query the cart of the user
        try {
            $result = $this->query($this->dbConn, $sqlQuery, [$userID]);
            return $result;
        } catch (PDOException $e) {
            if (__DEBUG__) echo $e;
        }
    }
}
