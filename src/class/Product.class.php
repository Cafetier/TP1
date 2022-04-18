<?php

/**
 * 
 * CRUD Product
 * 
 * This class is used to control all product actions
 * 
 * @author Dany Gauthier
 * 
 */

class Product extends Database
{
    function __construct()
    {
        // create a db connection using parent function
        $this->db_conn = $this->Connect();
    }

    /**
     * 
     * Check if a product exist using the product id
     * 
     * @param int       $ProductID
     * 
     * @return object   The product informations if it exists
     * 
     */
    public function GetProduct($ProductID){
        if (empty($ProductID)) return;  // check if param empty
        // query and return query
        $product = $this->Query($this->db_conn, "SELECT * FROM Product WHERE PRODUCTID = ?", [$ProductID]);
        return $product[0];
    }

    /**
     * 
     * This gets all the brand from the bd
     * 
     * @return object all the brands from db
     * 
     */
    public function GetBrands(){
        // query and return query
        $brands = $this->Query($this->db_conn, "SELECT * FROM brand", []);
        return $brands;
    }

    /**
     * 
     * This gets all the types in db
     * 
     * @return object all the types from db
     * 
     */
    public function GetTypes(){
        // query and return query
        $types = $this->Query($this->db_conn, "SELECT * FROM ptype", []);
        return $types;
    }

    /**
     * 
     * This gets all the colors avalailable in db
     * 
     * @return object all the colors from db
     * 
     */
    public function GetColors(){
        // query and return query
        $brands = $this->Query($this->db_conn, "SELECT * FROM color", []);
        return $brands;
    }

    /**
     * 
     * This gets all the sizes in db
     * 
     * @return object all the sizes from db
     * 
     */
    public function GetSizes(){
        // query and return query
        $brands = $this->Query($this->db_conn, "SELECT * FROM psize", []);
        return $brands;
    }

    /**
     * 
     * Add a product to the db
     * 
     * 
     */
    public function AddProduct(){
        
    }

    /**
     * 
     * Get all products
     * 
     * Only $nbProduct is NECESSARY, the rest is OPTIONAL (It is used as filters)
     * Example of filter : $Filter = [['Brand'] => 'Adidas'...]
     * 
     * @param int       $nbProduct                  Number of product you want returning (batch of 50, 20, 10...)
     * @param object    $Filter                     Filter you want applied (all below)
        * @param string    ['Brand']                Brand of the product (Adidas, reebok...)
        * @param string    ['ColorName']            The name of the color
        * @param double    ['Size']                 Size of the shoe (10.5, 8.0...)
        * @param string    ['Type']                 Type of shoe (Running, everyday...)
        * @param array     ['Price[min, max]']      Price of the shoe (ex : $Price[50.00, 70.00])
        * @param string    ['Order']                Price of the shoe (either : ASC or DESC)
     * 
     * @return object   All the products in order of new to old (date added)
     * 
     */
    public function GetAllProduct($nbProduct, $Filter){
        // check if nbProduct is empty
        if (empty($nbProduct)) throw new Error('There must be a number of product');

        // sql start
        $sqlquery = 'SELECT p.PRODUCTID,p.ProductName,p.ProductDescription,p.Price,
        p.DateCreated, p.Listed, b.BrandName, t.TypeName, i.ImageName, s.Size, c.ColorName 
        FROM Product p 
        LEFT JOIN Brand b ON p.BRANDID = b.BRANDID 
        LEFT JOIN pType t ON p.TYPEID = t.TYPEID 
        LEFT JOIN pImage_Product ip ON p.PRODUCTID=ip.PRODUCTID 
        LEFT JOIN pImage i ON i.IMAGEID=ip.IMAGEID 
        LEFT JOIN Color_Product cp ON cp.PRODUCTID=p.PRODUCTID 
        LEFT JOIN Color c ON c.COLORID=cp.COLORID 
        LEFT JOIN pSize_Product sp ON sp.PRODUCTID=p.PRODUCTID 
        LEFT JOIN pSize s ON s.SIZEID=sp.SIZEID 
        WHERE p.Listed = 1 ';

        // if there is brand
        if(isset($Filter['Brand']))
            $sqlquery = $sqlquery.'AND b.BrandName = ? ';

        // color
        if(isset($Filter['ColorName']))
            $sqlquery = $sqlquery.'AND c.ColorName = ? ';

        // size
        if(isset($Filter['Size']) && ctype_digit($Filter['Size']))
            $sqlquery = $sqlquery.'AND ? > s.Size < ? ';

        // Type
        if(isset($Filter['Type']))
            $sqlquery = $sqlquery.'AND t.TypeName = ? ';

        // Price
        if(isset($Filter['Price']));

        // order
        /**
         * 
         * THATS FCKNG DANGEROUS MUST CHANGE THAT TO AVOID SQL INJECTION
         */
        if(isset($Filter['Order']))
            $sqlquery = $sqlquery.'ORDER BY p.DateCreated '.$Filter['Order'];
            unset($Filter['Order']);  // unset order

        // query and return query
        try{
            $products = $this->Query($this->db_conn, $sqlquery, array_values($Filter));
        }
        catch (Error $e){
            echo $e;
        }

        return $products;
    }

    /**
     * 
     * Remove a product from the database (it actually just unlist them)
     * 
     * @param int $ProductID    ID of the product
     * 
     */
    public function RemoveProduct($ProductID){
        // check if empty param
        if (empty($ProductID)) throw new Error('Must provide a product id');

        // check if exist in db
        if (empty($this->GetProduct($ProductID))) 
            throw new Error('This product does not exist in the database');

        // unlist the product if it isnt already
        try {
            $this->Query($this->db_conn, 
            "UPDATE Product SET Listed = 0
            WHERE Listed != 0 AND PRODUCTID = ?;", 
            [$ProductID]);
            echo 'Deleted this product';
        } catch (Error $e) {
            echo $e;
        }
    }

    /**
     * 
     * Update information of the product
     * 
     * @param int $ProductID    ID of the product
     * 
     */
    public function UpdateProduct($ProductID){

    }
}
