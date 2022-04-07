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
        * @param string    ['ColorHex']             Hex color of the product (#fff...)
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
        if (empty($nbProduct)) throw new Error('There must be a number of Product to return');

        // sql start
        $sqlquery = 'SELECT * FROM Product WHERE Listed = 1 ';

        // if there is brand
        if(isset($Filter['Brand']))
            $sqlquery = $sqlquery.'AND Product.BRANDID IN(SELECT Brand.BRANDID FROM Brand WHERE Brand.BrandName = ?) ';

        // color
        if(isset($Filter['ColorHex']));

        // size
        if(isset($Filter['Size']) && ctype_digit($Filter['Size']));

        // Type
        if(isset($Filter['Type']));

        // Price
        if(isset($Filter['Price']));

        // order
        if(isset($Filter['Order'])) 
            $sqlquery = $sqlquery.'ORDER BY Product.DateCreated '.$Filter['Order'].' ';
            print_r($sqlquery);
            unset($Filter['Order']);  // remove the key in array filter to not treat it as prepared value


        // query and return query
        $products = $this->Query($this->db_conn, $sqlquery, array_values($Filter));

        // --- Old query ---
        // SELECT * FROM Product 
        // WHERE Product.BRANDID IN(SELECT Brand.BRANDID FROM Brand WHERE Brand.BrandName = ?)
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
        if (empty($ProductID)) throw new Error('ID must not be empty');

        // check if exist in db
        if (empty($this->GetProduct($ProductID))) 
            throw new Error('This product doesnt exist in database');

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
