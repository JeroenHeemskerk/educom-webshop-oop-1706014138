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
        if (empty($products)) {
            return false;
        }

        $sql = "INSERT INTO orders (user_id)
                VALUES (:userId)";

        $params = array(':userId'=>$userId);
        $orderId = $this->crud->createRow($sql, $params);

        //SQL query for adding order items
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, sale_price)
                VALUES ";

        //call createRow for each item
        $params = array();
        for($i=0; $i<count($products);$i++) {
            $ending = $i==count($products)-1 ? ';' : ',';
            $sql = $sql."(:order_id_$i, :product_id_$i, :quantity_$i, :sale_price_$i)$ending";

            $quantity = $cartItems[$products[$i]->id];
            $salePrice = $quantity * $products[$i]->price;

            $params[":order_id_$i"] = $orderId;
            $params[":product_id_$i"] = $products[$i]->id;
            $params[":quantity_$i"] = $quantity;
            $params[":sale_price_$i"] = $salePrice;
        }
        $this->crud->createRow($sql, $params);

        return true;
    }

    public function readProductsById($ids) {
        $sql = "SELECT * FROM products
                WHERE id IN (:ids)";

        $params = array('ids'=>$ids);
        
        return $this->crud->readMultipleRows($sql, $params);
    }

    public function readAllProducts() {
        $sql = 'SELECT *
                FROM products';
        $params = [];
        return $this->crud->readMultipleRows($sql, $params);
    }

    public function readTopFiveProducts() {
        $sql = 'SELECT id, name, product_description, price, img_filename, quantity
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
