<?php

/**
 * This class is used to control all product actions
 * @author Dany Gauthier
 */
class Product extends Database
{
    function __construct()
    {
        $this->dbConn = $this->connect();
    }

    /**
     * Check if a product exist using the product id
     * @param int       $productID
     * @return object   The product informations if it exists
     */
    public function getProduct($productID)
    {
        if (empty($productID))
            return;

        // query and return query
        $product = $this->query($this->dbConn, "
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
        GROUP BY p.PRODUCTID", [$productID]);
        return $product ? $product[0] : null;
    }

    /**
     * This gets all the brand from the bd
     * @return object all the brands from db
     */
    public function getBrands()
    {
        return $this->query(
            $this->dbConn,
            "SELECT * FROM Brand",
            []
        );
    }

    /**
     * This gets all the types in db
     * @return object all the types from db
     */
    public function getTypes()
    {
        return $this->query(
            $this->dbConn,
            "SELECT * FROM pType",
            []
        );
    }

    /**
     * This gets all the colors avalailable in db
     * @return object all the colors from db
     */
    public function getColors()
    {
        return $this->query(
            $this->dbConn,
            "SELECT c.COLORID, c.cName, HEX(c.Hex) as color_hex FROM Color c",
            []
        );
    }

    /**
     * This gets all the sizes in db
     * @return object all the sizes from db
     */
    public function getSizes()
    {
        return $this->query(
            $this->dbConn,
            "SELECT * FROM Size",
            []
        );
    }

    /**
     * Add a product to the db
     */
    public function addProduct()
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
    public function getAllProduct($productOffset, $filter)
    {
        // check if ProductOffset is empty or is not a number
        if (!empty($productOffset) && !ctype_digit($productOffset))
            throw new Error('There must be a product offset');

        $param = [];

        // sql start
        $sql = "
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
            p.Listed = 1 AND 0 < p.PRODUCTID <= 50 ";

        // NAME
        if (isset($filter['Name'])) {
            // append to sql query where statement
            $sql = $sql . 'AND p.pName LIKE ? ';

            // append to array
            array_push($param, '%' . $filter['Name'] . '%');
        }

        // if brand is an array and exists
        if (isset($filter['Brand']) && is_array($filter['Brand'])) {
            foreach ($filter['Brand'] as $k => $v) {
                // append to sql query where statement
                // if first then add a AND instead of or
                $k === 0 ?
                    $sql = $sql . 'AND b.bName = ? ' :
                    $sql = $sql . 'OR b.bName = ? ';

                // append to param array
                array_push($param, $v);
            }
        }

        // if color exists
        if (isset($filter['Color'])) {
            // append to sql query where statement
            $sql = $sql . 'AND c.cName = ? ';

            // append to param array
            array_push($param, $filter['Color']);
        }

        // size
        if (isset($filter['Size']) && ctype_digit($filter['Size'])) {
            // append to sql query where statement
            $sql = $sql . 'AND s.Size = ? ';

            // append to param array
            array_push($param, $filter['Size']);
        }

        // Type
        if (isset($filter['Type'])) {
            // append to sql query where statement
            $sql = $sql . 'AND t.tName = ? ';

            // append to param array
            array_push($param, $filter['Type']);
        }

        // Price
        if (isset($filter['Price'])) {
            // append to sql query where statement
            $sql = $sql . 'AND p.Price > ? AND p.Price < ? ';

            // append to param array
            foreach ($filter['Price'] as $v) array_push($param, $v);
        }

        // append group by
        $sql = $sql . 'GROUP BY p.PRODUCTID ';

        // WORKS Order
        if (isset($filter['Order'])) {
            // append to sql query where statement
            $sql = $sql . 'ORDER BY p.DateCreated ' . $filter['Order'];
            unset($filter['Order']);  // unset order
        }

        // query and return query
        try {
            $products = $this->query($this->dbConn, $sql, $param);
            return $products;
        } catch (Error $e) {
            echo $e;
        }
    }

    /**
     * Remove a product from the database (it actually just unlist them)
     * @param int $productID    ID of the product
     */
    public function removeProduct($productID)
    {
        // check if empty param
        if (empty($productID))
            throw new Error('Must provide a product id');

        // check if exist in db
        if (empty($this->getProduct($productID)))
            throw new Error('This product does not exist in the database');

        // unlist the product if it isnt already
        try {
            $this->query(
                $this->dbConn,
                "UPDATE Product SET Listed = 0
            WHERE Listed != 0 AND PRODUCTID = ?;",
                [$productID]
            );
        } catch (Error $e) {
            echo $e;
        }
    }

    /**
     * Update information of the product
     * @param int $productID    ID of the product
     */
    public function updateProduct($productID)
    {
    }
}
