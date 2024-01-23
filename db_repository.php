 <?php
//================ functions ================

function getUserByEmail($email) {
    try {
        $conn = open_connection();

        $email = mysqli_real_escape_string($conn, $email);
        
        $sql = "SELECT * FROM users WHERE email = '$email'";
        
        $result = $conn->query($sql);

        if (!$result) {
            throw new Exception("GetUserByEmail failed: q: $sql, err: ".$conn->error);
        }
            
        if ($result->num_rows > 0) {
            $row = $result -> fetch_assoc();
            return $row;
        } else {
            return NULL;
        }
    }
    finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function storeUser($email, $name, $password) {
    try {
        $conn = open_connection();

        $email = mysqli_real_escape_string($conn, $email);
        $name = mysqli_real_escape_string($conn, $name);
        $password = mysqli_real_escape_string($conn, $password);
            
        $sql = "INSERT INTO users (email, name, password)
        VALUES ('$email', '$name', '$password')";

        $result = $conn->query($sql);

        if (!$result) {
            throw new Exception("StoreUser failed: q: $sql, err: ".$conn->error);
        }

        return $result;
    }
    finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getProductsByID($ids) {
    try {
        $conn = open_connection();
        
        $sql = "SELECT * FROM products WHERE id IN (";
        for($i=0; $i<count($ids);$i++) {
            $ending = $i==count($ids)-1 ? ')' : ',';
            $sql = $sql.$ids[$i].$ending;
        }
        
        $result = $conn->query($sql);

        if (!$result) {
            throw new Exception("GetProductsByID failed: q: $sql, err: ".$conn->error);
        }
        
        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result -> fetch_assoc()) {
                array_push($products, $row);
            }
            return $products;
        } else {
            return NULL;
        }
    }
    finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function createOrder($userId, $cartItems) {
    try {
        $conn = open_connection();
        //query for adding order
        $sql = "INSERT INTO orders (user_id) VALUES ($userId)";
    
        $result = $conn->query($sql);

        if (!$result) {
            throw new Exception("Order creation failed: q: $sql, err: ".$conn->error);
        }

        $orderId = mysqli_insert_id($conn);
    
        $productIds = array_keys($cartItems);
        if (empty($productIds)) {
            return NULL;
        }
        $products = getProductsByID($productIds); //currently opens another connection
    
        if ($products == NULL) {
            return NULL;
        }
    
        //SQL query for adding order items
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, sale_price) VALUES ";
        //add each item to the query
        for($i=0; $i<count($products);$i++) {
            $quantity = $cartItems[$products[$i]['id']];
            $sale_price = $quantity * $products[$i]['price'];
            $ending = $i==count($cartItems)-1 ? ';' : ',';
            $sql = $sql. "($orderId, ".$products[$i]['id'].", ".$quantity.", ".$sale_price.")".$ending;
        }
    
        $result = $conn->query($sql);

        if (!$result) {
            throw new Exception("Adding Order items failed: q: $sql, err: ".$conn->error);
        }
        
        return $result;
    }
    finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getAllProducts() {
    try {
        $conn = open_connection();

        $sql = 'SELECT * FROM products';

        $result = $conn->query($sql);
        
        if (!$result) {
            throw new Exception("GetAllProducts failed: q: $sql, err: ".$conn->error);
        }

        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result -> fetch_assoc()) {
                array_push($products, $row);
            }
            return $products;
        } else {
            return NULL;
        }
    }
    finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getTopFive() {
    try {
        $conn = open_connection();

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

        $result = $conn->query($sql);
        
        if (!$result) {
            throw new Exception("GetTopFive failed: q: $sql, err: ".$conn->error);
        }

        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result -> fetch_assoc()) {
                array_push($products, $row);
            }
            return $products;
        } else {
            return NULL;
        }
    }
    finally {
        if (isset($conn)) {
            $conn->close();
        }
    }
}


function open_connection() {
    $servername = "localhost";
    $username = "thomas_webshop_user";
    $password = "didIturNoffThesToveBefoReil3fttHism0rniNg";
    $dbname = "thomas_webshop";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Cannot connect to DB - " . $conn->connect_error);
    }
    return $conn;
}

?> 