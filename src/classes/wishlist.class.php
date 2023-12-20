<?php

/**
 * This file handle all the wishlist interactions
 * @author Dany Gauthier
 */
class Wishlist extends Database
{
    function __construct()
    {
        $this->dbConn = $this->connect();
    }

    /**
     * Add item to Wishlist
     */
    public function add($productID, $userID)
    {
        // check if inputs are not empty and are numbers
        if (
            empty($userID || $productID) &&
            !ctype_digit($userID && $productID)
        )
            throw new Error('This product does not exists');

        // query the db to remove the product
        try {
            $this->Query(
                $this->dbConn,
                'INSERT INTO Wishlist (PRODUCTID, USERID)
            VALUES (?, ?)',
                [$productID, $userID]
            );
        } catch (Error $e) {
            return $e;
        }
    }

    /**
     * Remove item from Wishlist
     */
    public function remove($productID, $userID)
    {
        // check if inputs are not empty and are numbers
        if (
            empty($userID || $productID) &&
            !ctype_digit($userID && $productID)
        )
            throw new Error('You do not have this product');

        // query the db to remove the product
        try {
            $this->Query(
                $this->dbConn,
                'DELETE FROM Wishlist WHERE PRODUCTID = ? AND USERID = ?',
                [$productID, $userID]
            );
        } catch (Error $e) {
            return $e;
        }
    }

    /**
     * Get items from Wishlist
     * @return object all the items in the Wishlist
     */
    public function getAll($userID)
    {
        // check if inputs are not empty and are numbers
        if (empty($userID) && !ctype_digit($userID))
            throw new Error('You are not connected');

        $sql = "SELECT
        u.USERID,
        p.PRODUCTID,
        w.WISHLISTID, w.DateAdded,
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
        
        FROM Wishlist w
        
        -- sizes
        LEFT JOIN size s ON s.SIZEID=w.SIZEID
        -- product
        LEFT JOIN product p ON w.PRODUCTID=p.PRODUCTID
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
        
        GROUP BY p.PRODUCTID
        ORDER BY w.DateAdded DESC";
        // query the cart of the user
        try {
            $result = $this->Query($this->dbConn, $sql, [$userID]);
            return $result;
        } catch (Error $e) {
            if (__DEBUG__) echo $e;
        }
    }
}
