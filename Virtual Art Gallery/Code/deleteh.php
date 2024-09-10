<?php
require_once "dbh.inc.php";
session_start();

// Check if the user is logged in and the artwork ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the username is available in the session
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Fetch the user ID based on the username from the users table
        $sql = "SELECT user_id FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userId = $user['user_id'];

            // Check if the artwork ID is provided
            if (isset($_POST['artwork_id'])) {
                $artworkId = $_POST['artwork_id'];

                // Delete the artwork from the database
                $sql = "DELETE FROM artwork WHERE artwork_id = :artwork_id AND user_id = :user_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['artwork_id' => $artworkId, 'user_id' => $userId]);

                // Optionally, you can also delete the corresponding image file from your server
                // Assuming the image file path is stored in the 'image_url' column of the artwork table
                $sql = "SELECT image_url FROM artwork WHERE artwork_id = :artwork_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['artwork_id' => $artworkId]);
                $artwork = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($artwork) {
                    $imagePath = $artwork['image_url'];
                    // Delete the image file from your server using unlink() function
                    unlink($imagePath);
                }

                // Redirect to profile.php
                header("Location: profile.php");
                exit();
            } else {
                echo "Artwork ID is missing.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "Username is not available in the session.";
    }
}
