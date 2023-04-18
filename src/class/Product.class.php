<?php

/**
 * This class is used to control all product actions
 * @author Dany Gauthier
 */
class Product extends Database
{
    function __construct()
    {
        $this->db_conn = $this->Connect();
    }

    /**
     * Check if a product exist using the product id
     * @param int       $ProductID
     * @return object   The product informations if it exists
     */
    public function GetProduct($ProductID)
    {
        if (empty($ProductID)) return;
        // query and return query
        $product = $this->Query($this->db_conn, "
        SELECT
        p.PRODUCTID, p.pName, p.pDescription, p.Price, p.DateCreated,
        b.bName,
        t.tName,
        g.gName,
        JSON_ARRAYAGG(
            JSON_OBJECT(
                'Name',
                i.iName,
                'Alt',
                i.Alt,
                'Title',
                i.Title
            )
        ) AS Images,
        JSON_ARRAYAGG(c.cName) AS cName,
        JSON_ARRAYAGG(s.Size) AS Size
        -- w.USERID,
        -- ca.USERID
        
        FROM Product p
        -- brand
        LEFT JOIN brand b ON p.BRANDID=b.BRANDID
        -- type
        LEFT JOIN ptype t ON p.TYPEID=t.TYPEID
        -- gender
        LEFT JOIN gender g ON p.GENDERID=g.GENDERID
        -- imgs
        LEFT JOIN pimage_product ip ON ip.PRODUCTID=p.PRODUCTID
        LEFT JOIN pimage i ON i.IMAGEID=ip.IMAGEID
        -- colors
        LEFT JOIN color_product cp ON cp.PRODUCTID=p.PRODUCTID
        LEFT JOIN color c ON c.COLORID=cp.COLORID
        -- Sizes
        LEFT JOIN size_product sp ON sp.PRODUCTID=p.PRODUCTID
        LEFT JOIN size s ON s.SIZEID=sp.SIZEID
        -- cart
        -- JOIN cart ca ON ca.PRODUCTID=p.PRODUCTID
        -- wishlist
        -- JOIN wishlist w ON w.PRODUCTID=p.PRODUCTID
        
        WHERE p.PRODUCTID=?
        GROUP BY p.PRODUCTID", [$ProductID]);
        return $product[0];
    }

    /**
     * This gets all the brand from the bd
     * @return object all the brands from db
     */
    public function GetBrands()
    {
        return $this->Query($this->db_conn, "SELECT * FROM brand", []);
    }

    /**
     * This gets all the types in db
     * @return object all the types from db
     */
    public function GetTypes()
    {
        return $this->Query($this->db_conn, "SELECT * FROM ptype", []);
    }

    /**
     * This gets all the colors avalailable in db
     * @return object all the colors from db
     */
    public function GetColors()
    {
        return $this->Query(
            $this->db_conn,
            "SELECT c.COLORID, c.cName, HEX(c.Hex) as color_hex FROM color c", []
        );
    }

    /**
     * This gets all the sizes in db
     * @return object all the sizes from db
     */
    public function GetSizes()
    {
        return $this->Query($this->db_conn, "SELECT * FROM Size", []);
    }

    /**
     * Add a product to the db
     */
    public function AddProduct()
    {
    }

    /**
     * Get all products
     * Only $ProductOffset is NECESSARY, the rest is OPTIONAL (It is used as filters)
     * Example of filter : $Filter = [['Brand'] => 'Adidas'...]
     * @param int       $ProductOffset              Fetch 50 product from the offset point
     * @param object    $Filter                     Filter you want applied (all below)
     * @param string    ['Name']                 Search the name of the product ex : Superstar
     * @param array     ['Brand']                Brand of the product ex : [Adidas, Reebok]
     * @param string    ['Color']            The name of the color
     * @param double    ['Size']                 Size of the shoe (10.5, 8.0...)
     * @param string    ['Type']                 Type of shoe (Running, everyday...)
     * @param array     ['Price[min, max]']      Price of the shoe (ex : $Price[50.00, 70.00])
     * @param string    ['Order']                Price of the shoe (either : ASC or DESC)
     * 
     * @return object   All the products in order of new to old (date added)
     */
    public function GetAllProduct($ProductOffset, $Filter)
    {
        // check if ProductOffset is empty or is not a number
        if (!empty($ProductOffset) && !ctype_digit($ProductOffset))
            throw new Error('There must be a product offset');

        $param = [];

        // sql start
        $sqlquery = "
        SELECT DISTINCT
            p.PRODUCTID,
            p.pName,
            p.pDescription,
            p.Price,
            p.DateCreated,
            p.Listed,
            b.bName,
            t.tName,
            JSON_ARRAYAGG(
                JSON_OBJECT(
                    'Name',
                    i.iName,
                    'Alt',
                    i.Alt,
                    'Title',
                    i.Title
                )
            ) AS Images,
            JSON_ARRAYAGG(s.Size) AS Size,
            JSON_ARRAYAGG(c.cName) AS cName
        FROM
            Product p
            -- brand
        LEFT JOIN Brand b ON
            p.BRANDID = b.BRANDID
            -- type
        LEFT JOIN pType t ON
            p.TYPEID = t.TYPEID
            -- img
        LEFT JOIN pImage_Product ip ON
            p.PRODUCTID = ip.PRODUCTID
        LEFT JOIN pImage i ON
            i.IMAGEID = ip.IMAGEID
            -- color
        LEFT JOIN Color_Product cp ON
            cp.PRODUCTID = p.PRODUCTID
        LEFT JOIN Color c ON
            c.COLORID = cp.COLORID
            -- size
        LEFT JOIN Size_Product sp ON
            sp.PRODUCTID = p.PRODUCTID
        LEFT JOIN Size s ON
            s.SIZEID = sp.SIZEID
        WHERE
            p.Listed = 1 AND 0 < P.PRODUCTID <= 50 ";

        // NAME
        if (isset($Filter['Name'])) {
            // append to sql query where statement
            $sqlquery = $sqlquery . 'AND p.pName LIKE ? ';

            // append to array
            array_push($param, '%' . $Filter['Name'] . '%');
        }

        // if brand is an array and exists
        if (isset($Filter['Brand']) && is_array($Filter['Brand'])) {
            foreach ($Filter['Brand'] as $k => $v) {
                // append to sql query where statement
                // if first then add a AND instead of or
                $k === 0 ?
                    $sqlquery = $sqlquery . 'AND b.bName = ? ' :
                    $sqlquery = $sqlquery . 'OR b.bName = ? ';

                // append to param array
                array_push($param, $v);
            }
        }

        // if color exists
        if (isset($Filter['Color'])) {
            // append to sql query where statement
            $sqlquery = $sqlquery . 'AND c.cName = ? ';

            // append to param array
            array_push($param, $Filter['Color']);
        }

        // size
        if (isset($Filter['Size']) && ctype_digit($Filter['Size'])) {
            // append to sql query where statement
            $sqlquery = $sqlquery . 'AND s.Size = ? ';

            // append to param array
            array_push($param, $Filter['Size']);
        }

        // Type
        if (isset($Filter['Type'])) {
            // append to sql query where statement
            $sqlquery = $sqlquery . 'AND t.tName = ? ';

            // append to param array
            array_push($param, $Filter['Type']);
        }

        // Price
        if (isset($Filter['Price'])) {
            // append to sql query where statement
            $sqlquery = $sqlquery . 'AND p.Price > ? AND p.Price < ? ';

            // append to param array
            foreach ($Filter['Price'] as $v) array_push($param, $v);
        }

        // append group by
        $sqlquery = $sqlquery . 'GROUP BY p.PRODUCTID ';

        // WORKS Order
        if (isset($Filter['Order'])) {
            // append to sql query where statement
            $sqlquery = $sqlquery . 'ORDER BY p.DateCreated ' . $Filter['Order'];
            unset($Filter['Order']);  // unset order
        }

        // query and return query
        try {
            $products = $this->Query($this->db_conn, $sqlquery, $param);
            return $products;
        } catch (Error $e) {
            echo $e;
        }
    }

    /**
     * Remove a product from the database (it actually just unlist them)
     * @param int $ProductID    ID of the product
     */
    public function RemoveProduct($ProductID)
    {
        // check if empty param
        if (empty($ProductID)) throw new Error('Must provide a product id');

        // check if exist in db
        if (empty($this->GetProduct($ProductID)))
            throw new Error('This product does not exist in the database');

        // unlist the product if it isnt already
        try {
            $this->Query(
                $this->db_conn,
                "UPDATE Product SET Listed = 0
            WHERE Listed != 0 AND PRODUCTID = ?;",
                [$ProductID]
            );
        } catch (Error $e) {
            echo $e;
        }
    }

    /**
     * Update information of the product
     * @param int $ProductID    ID of the product
     */
    public function UpdateProduct($ProductID)
    {
    }
}
