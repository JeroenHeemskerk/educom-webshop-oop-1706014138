<?php
    
    function cartHeader() {
        $header = 'Shopping Cart';
        return $header;
    }

    function showCartContent($data) {
        if (isset($data['connectionErr'])) {
            echo "<p>".$data['connectionErr']."</p>".PHP_EOL;
        } else {
            $cartItems = $data['cartItems'];

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
                        showCartForm($product['id'], $cartItems[$product['id']]);
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
                    showOrderForm();
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

    function showCartForm($productId, $quantity) {
        showFormStart('cart');
        showHiddenField('productId', $productId);
        showHiddenField('action', 'removeFromCart');
        showHiddenField('quantity', '1');
        showFormEnd('-');

        echo $quantity;

        showFormStart('cart');
        showHiddenField('productId', $productId);
        showHiddenField('action', 'addToCart');
        showHiddenField('quantity', '1');
        showFormEnd('+');
    }

    function showOrderForm() {
        showFormStart('cart');
        showHiddenField('action','placeOrder');
        showFormEnd('Place Order');
    }

?>
