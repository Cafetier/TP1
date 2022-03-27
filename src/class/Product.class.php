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
        // check if there is an exact same
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
