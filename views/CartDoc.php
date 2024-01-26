<?php

require_once('ProductDoc.php');

class CartDoc extends ProductDoc {
    protected function showHeader() {
        echo '    <h1>Shopping Cart</h1>' . PHP_EOL;
    }

    protected function showContent() {
        if (!empty($this->model->connectionErr)) {
            echo "<p>".$this->model->connectionErr."</p>".PHP_EOL;
        } else {
            $productIds = array_keys($this->model->cartItems);
            if (empty($productIds)) {
                echo "<br><h3 class='centered'>Uw winkelwagen is leeg, voeg iets toe op de webshop</h3>";
            } else {
                try {
                    $products = $this->model->getProducts($productIds);
                    $totalPrice = 0;
    
                    echo '<table>' . PHP_EOL;
                    echo '<tr>' . PHP_EOL;
                    echo '    <th>ID</th>' . PHP_EOL;
                    echo '    <th>Name</th>' . PHP_EOL;
                    echo '    <th>Quantity</th>' . PHP_EOL;
                    echo '    <th>Price</th>' . PHP_EOL;
                    echo '    <th>Image</th>' . PHP_EOL;
                    echo '</tr>' . PHP_EOL;
    
                    foreach ($products as $product) {
                        echo '<tr>' . PHP_EOL;
                        echo "    <td>".$product['id']."</td>" . PHP_EOL;
                        echo "    <td><a class='webshop_link' href='index.php?page=detail&productId=".$product['id']."'>".$product['name']."</a></td>" . PHP_EOL;
                        
                        //show quantity and buttons to change values
                        echo '    <td>';
                        $this->showCartForm($product['id'], $this->model->cartItems[$product['id']]);
                        echo '    </td>' . PHP_EOL;
    
                        $price = $product['price']*$this->model->cartItems[$product['id']];
                        $totalPrice += $price;
                        echo "    <td>$".number_format($price, 2)."</td>" . PHP_EOL;
                        echo "    <td><img class='webshop_img' src='Images/".$product['img_filename']."'></td>" . PHP_EOL;
                        echo '</tr>' . PHP_EOL;
                    }
    
                    echo '<tr>' . PHP_EOL;
                    echo '    <td></td>' . PHP_EOL;
                    echo '    <td>Total Price:</td>' . PHP_EOL;
                    echo '    <td></td>' . PHP_EOL;
                    echo "    <td>$".number_format($totalPrice, 2)."</td>" . PHP_EOL;
    
                    //show button to place order
                    echo '    <td>';
                    $this->showOrderForm();
                    echo '    </td>' . PHP_EOL;
    
                    echo '</tr>' . PHP_EOL;
                    echo '</table>'. PHP_EOL;
                }
                catch (Exception $ex) {
                    $this->model->connectionErr = "Er is een technische storing opgetreden, er kan geen verbinding met de database gemaakt worden. Probeer het later opnieuw.";
                    echo "<p>".$this->model->connectionErr."</p>".PHP_EOL;
                    LogError("Authentication Failed: ".$ex->getMessage());
                }
            }
        }
    }
}

?>