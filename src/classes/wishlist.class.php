<?php

/**
 * This file handle all the wishlist interactions
 * @author Dany Gauthier
 */
class Wishlist extends Database
{
    function __construct()
    {
        $this->db_conn = $this->Connect();
    }

    /**
     * Add item to Wishlist
     */
    public function Add($ProductID, $UserID)
    {
        // check if inputs are not empty and are numbers
        if (empty($UserID || $ProductID) && !ctype_digit($UserID && $ProductID))
            throw new Error('This product does not exists');

        // query the db to remove the product
        try {
            $this->Query(
                $this->db_conn,
                'INSERT INTO Wishlist (PRODUCTID, USERID)
            VALUES (?, ?)',
                [$ProductID, $UserID]
            );
        } catch (Error $e) {
            return $e;
        }
    }

    /**
     * Remove item from Wishlist
     */
    public function Remove($ProductID, $UserID)
    {
        // check if inputs are not empty and are numbers
        if (empty($UserID || $ProductID) && !ctype_digit($UserID && $ProductID))
            throw new Error('You do not have this product');

        // query the db to remove the product
        try {
            $this->Query(
                $this->db_conn,
                'DELETE FROM Wishlist WHERE PRODUCTID = ? AND USERID = ?',
                [$ProductID, $UserID]
            );
        } catch (Error $e) {
            return $e;
        }
    }

    /**
     * Get items from Wishlist
     * @return object all the items in the Wishlist
     */
    public function GetAll($UserID)
    {
        // check if inputs are not empty and are numbers
        if (empty($UserID) && !ctype_digit($UserID))
            throw new Error('You are not connected');

        $sql_query = "SELECT
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
            $result = $this->Query($this->db_conn, $sql_query, [$UserID]);
            return $result;
        } catch (Error $e) {
            if (__DEBUG__) echo $e;
        }
    }
}