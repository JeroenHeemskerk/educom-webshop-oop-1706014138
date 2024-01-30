<?php

class ShopCrud {
    private $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function createOrder($userId, $cartItems) {
        $productIds = array_keys($cartItems);
        //if no items in cart return false to indicate order creation unsuccessful
        if (empty($productIds)) {
            return false;
        }
        $products = $this->readProductsById($productIds);
    
        //if no products found in DB return false to indicate order creation unsuccessful
        if ($products == NULL) {
            return false;
        }

        $sql = "INSERT INTO orders (user_id) VALUES (:userId)";
        $params = array(':userId'=>$userId);
        $orderId = $this->crud->createRow($sql, $params);

        //SQL query for adding order items
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, sale_price)
                VALUES (:order_id, :product_id, :quantity, :sale_price)";
        //call createRow for each item
        for($i=0; $i<count($products);$i++) {
            $quantity = $cartItems[$products[$i]['id']];
            $salePrice = $quantity * $products[$i]['price'];
            $params = array(':order_id'=>$orderId, ':product_id'=>$products[$i]['id'],
                            ':quantity'=>$quantity, ':sale_price'=>$salePrice);

            $this->crud->createRow($sql, $params);
        }
        return true;
    }

    public function readProductsById($ids) {
        $sql = "SELECT * FROM products WHERE id IN (";
        for($i=0; $i<count($ids);$i++) {
            $ending = $i==count($ids)-1 ? ')' : ',';
            $sql = $sql.":id_$i".$ending;
        }
        $params = array();
        foreach($ids as $key=>$value) {
            $params[":id_$key"] = $value;
        }
        
        return $this->crud->readMultipleRows($sql, $params);
    }

    public function readAllProducts() {
        $sql = 'SELECT * FROM products';
        $params = [];
        return $this->crud->readMultipleRows($sql, $params);
    }

    public function readTopFiveProducts() {
        $sql = 
        'SELECT id, name, product_description, price, img_filename, quantity
        FROM products x
        LEFT JOIN (SELECT product_id, SUM(quantity) quantity
            FROM `orders` o
            JOIN (
                SELECT id, order_id, product_id, quantity
                FROM order_items) oi
            ON o.id = oi.order_id
            WHERE date >= ADDDATE(NOW(), INTERVAL -7 DAY)
            GROUP BY product_id) y
        ON x.id = y.product_id
        ORDER BY quantity DESC
        LIMIT 5';

        $params = [];

        return $this->crud->readMultipleRows($sql, $params);
    }
}

?>
