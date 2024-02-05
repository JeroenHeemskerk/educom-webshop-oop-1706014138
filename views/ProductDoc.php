<?php

require_once('FormDoc.php');

abstract class ProductDoc extends FormDoc {
    protected function showHeadContent() {
        echo '        <link rel="stylesheet" href="css/stylesheet.css">' . PHP_EOL;
        echo '        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>' . PHP_EOL;
        $this->showJS('rating.js');
    }

    public function showJS($filepath) {
        echo '        <script src="'.$filepath.'"></script>' . PHP_EOL;
    }

    protected function showProductList($products, $page) {
        echo '<table class="product-table">' . PHP_EOL;
        echo '<thead><tr>' . PHP_EOL;
        echo '    <th>ID</th>' . PHP_EOL;
        echo '    <th>Name</th>' . PHP_EOL;
        if ($this->model->isUserLoggedIn()) {
            echo '    <th></th>' . PHP_EOL; //column for buttons to add items to cart
        }
        echo '    <th>Price</th>' . PHP_EOL;
        echo '    <th>Image</th>' . PHP_EOL;
        echo '</tr></thead><tbody>' . PHP_EOL;
        foreach ($products as $product) {
            echo '<tr>' . PHP_EOL;
            echo "    <td>".$product->id."</td>" . PHP_EOL;
            echo "    <td><a class='webshop_link' href='index.php?page=detail&productId=".$product->id."'>".$product->name."</a></td>" . PHP_EOL;
            if ($this->model->isUserLoggedIn()) {
                echo '    <td>';
                $this->showAddToCartForm($page, $product->id);
                echo '    </td>' . PHP_EOL;
            }
            echo "    <td>$".$product->price."</td>" . PHP_EOL;
            echo "    <td><img class='webshop_img' src='Images/".$product->img_filename."'></td>" . PHP_EOL;
            echo '</tr>' . PHP_EOL;
        }
        echo '</tbody></table>'. PHP_EOL;
    }

    //form used in webshop and detail pages for users to add items to cart
    protected function showAddToCartForm($page, $productId) {
        $this->showFormStart($page);

        $this->showHiddenField('productId', $productId);
        $this->showHiddenField('action', 'addToCart');
        echo '    <input type="number" class="webshop_input" name="quantity" value="0" min="0" max="9999">';

        $this->showFormEnd('Add To Cart');
    }

    //form used in the shopping cart page
    protected function showCartForm($productId, $quantity) {
        $this->showFormStart('cart');
        $this->showHiddenField('productId', $productId);
        $this->showHiddenField('action', 'removeFromCart');
        $this->showHiddenField('quantity', '1');
        $this->showFormEnd('-');

        echo $quantity;

        $this->showFormStart('cart');
        $this->showHiddenField('productId', $productId);
        $this->showHiddenField('action', 'addToCart');
        $this->showHiddenField('quantity', '1');
        $this->showFormEnd('+');
    }

    //form to place an order
    protected function showOrderForm() {
        $this->showFormStart('cart');
        $this->showHiddenField('action','placeOrder');
        $this->showFormEnd('Place Order');
    }
}

?>