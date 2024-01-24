<?php

require_once('ProductDoc.php');

class CartDoc extends ProductDoc {
    protected function showContent() {
        if (isset($this->data['connectionErr'])) {
            echo "<p>".$this->data['connectionErr']."</p>".PHP_EOL;
        } else {
            $cartItems = $this->data['cartItems'];

            $productIds = array_keys($cartItems);
            if (empty($productIds)) {
                echo "<br><h3 class='centered'>Uw winkelwagen is leeg, voeg iets toe op de webshop</h3>";
            } else {
                try {
                    $products = getProducts($productIds);
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
                        $this->showCartForm($product['id'], $cartItems[$product['id']]);
                        echo '    </td>' . PHP_EOL;
    
                        $price = $product['price']*$cartItems[$product['id']];
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
                    $genericErr = "Er is een technische storing opgetreden, registratie is niet mogelijk. Probeer het later opnieuw.";
                    echo "<p>$genericErr</p>".PHP_EOL;
                    LogError("Authentication Failed: ".$ex->getMessage());
                }
            }
        }
    }
}

?>