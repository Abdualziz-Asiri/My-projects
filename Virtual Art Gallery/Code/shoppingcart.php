<!-- shoppingcart.php -->
<?php
    session_start();
    include_once 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
    
    <title>Virtual Art Gallery - Shopping Cart</title>

</head>
<body>
    <main>
        <h2>Your Shopping Cart</h2>
        <div class="cart-items">
            <?php
           
            require_once 'shoppingcarth.inc.php';
            
            if (!isset($_SESSION['username']) && !isset($_SESSION['admin_username'])) {
                echo "<p>You must be logged in to view your cart.</p>";
            } else {
                try {
                    $username = isset($_SESSION['username']) ? $_SESSION['username'] : $_SESSION['admin_username'];
                    
                    $stmt = $pdo->prepare("SELECT o.order_id, a.image_url,a.artwork_title, a.price FROM orders AS o
                                            JOIN artwork AS a ON a.artwork_id = o.artwork_id
                                            JOIN users AS u ON u.user_id = o.user_id
                                            WHERE u.username = ?");
                    $stmt->execute([$username]);
                    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if ($cartItems) {
                        foreach ($cartItems as $item) {
                            echo "<div class='cart-item'>";
                            echo "<img src='" . $item['image_url'] . "' alt='Item Image'>";
                            echo "<h3>" . $item['artwork_title'] . "</h3>";
                            echo "<p>Price: SR" . $item['price'] . "</p>";
                            echo "<form class='dele' action='removefromcart.php' method='POST'>";
                            echo "<input type='hidden' name='order_id' value='" . $item['order_id'] . "'>";
                            echo "<input type='submit' value='Remove from Cart'>";
                            echo "</form>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Your cart is empty.</p>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
            ?>
        </div>
    </main>
</body>
</html>