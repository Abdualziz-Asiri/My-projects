<?php

function deleteUser($pdo, $userId) {
    // SQL query to delete user
    $query = "DELETE FROM users WHERE user_id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();

    // Check if the user was successfully deleted
    if ($stmt->rowCount() > 0) {
        echo "User deleted successfully.";
    } else {
        echo "Failed to delete user.";
    }
}