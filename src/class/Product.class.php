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
    private function ProductExist($ProductID){
        if (empty($ProductID)) return;  // check if param empty
        // query and return query
        $product = $this->Query($this->db_conn, "SELECT * FROM Product WHERE PRODUCTID = ?", [$ProductID]);
        return $product;
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
     * 
     * @return object   All the products in order of new to old (date added)
     * 
     */
    public function GetAllProduct($nbProduct, $Filter){
        // check if nbProduct is empty
        if (empty($nbProduct)) throw new Error('There must be a number of Product to return');
        
        // query and return query
        $products = $this->Query($this->db_conn, 'SELECT * FROM Product', []);

        // --- Old query ---
        // SELECT * FROM Product 
        // WHERE Product.BRANDID IN(SELECT Brand.BRANDID FROM Brand WHERE Brand.BrandName = ?)
        return $products;
    }

    /**
     * 
     * Get all products
     * 
     * @param int $ProductID    Product id of the wanted product
     * 
     */
    public function GetProduct($ProductID){
        
    }

    /**
     * 
     * Remove a product from the database
     * 
     * @param int $ProductID    ID of the product
     * 
     */
    public function RemoveProduct($ProductID){

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
