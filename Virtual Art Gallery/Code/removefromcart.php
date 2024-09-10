<?php
require_once 'dbh.inc.php';

function removeFromCart($orderId) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $stmt->bindValue(':order_id', $orderId);
        $stmt->execute();
        
        return true;
    } catch (PDOException $e) {
        throw new Exception("Failed to remove item from cart: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    
    try {
        removeFromCart($orderId);
        header("Location: shoppingcart.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}