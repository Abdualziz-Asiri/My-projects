<?php

require_once 'dbh.inc.php';

// Start the session


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $artworkId = $_POST['artwork_id'];
    
    // Retrieve the user_id based on the username (assuming username is available in the session)
    $username = $_SESSION['username'] ?? null;
    
    if ($username) {
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $userId = $user['user_id'];
            
            try {
                addToCart($artworkId, $userId);
                header("Location: shoppingcart.php"); // Redirect to shoppingcart.php
                exit();
            } catch (Exception $e) {
                echo "Failed to add item to cart: " . $e->getMessage();
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "Invalid session or username not found.";
    }
}

function addToCart($artworkId, $userId) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("INSERT INTO orders (artwork_id, user_id, created_at) VALUES (?, ?, NOW())");
        $stmt->bindValue(1, $artworkId);
        $stmt->bindValue(2, $userId);
        $stmt->execute();
        
        return true;
    } catch (PDOException $e) {
        throw new Exception("Failed to add item to cart: " . $e->getMessage());
    }
}

// Additional functions for managing the shopping cart can be added here