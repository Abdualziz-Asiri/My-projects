<?php
require_once "dbh.inc.php";

session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artworkTitle = $_POST['artwork_title'];
    $artworkType = $_POST['artwork_type'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $extensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $extensions)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {

            // Resize the uploaded image to a fixed size
            $fixedWidth = 800;
            $fixedHeight = 600;
            $source = imagecreatefromjpeg($target_file);
            $resized = imagecreatetruecolor($fixedWidth, $fixedHeight);
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $fixedWidth, $fixedHeight, imagesx($source), imagesy($source));
            imagejpeg($resized, $target_file, 100);
            // Rest of your code...
            header("Location: profile.php?error=success");   
            echo "File uploaded successfully.";

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

                    $pdo->beginTransaction();

                    try {
                        // Insert artwork details into the database
                        $sql = "INSERT INTO artwork (artwork_title, artwork_type, price, image_url, user_id) 
                                VALUES (:artwork_title, :artwork_type, :price, :image_url, :user_id)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            'artwork_title' => $artworkTitle,
                            'artwork_type' => $artworkType,
                            'price' => $price,
                            'image_url' => $target_file,
                            'user_id' => $userId
                        ]);

                        // Commit the transaction
                        $pdo->commit();

                        echo "Artwork uploaded successfully.";

                        // Redirect to profile.php
                        header("Location: profile.php");
                        exit;
                    } catch (PDOException $e) {
                        // Rollback the transaction on error
                        $pdo->rollback();
                        echo "Error uploading artwork: " . $e->getMessage();
                    }
                } else {
                    echo "User not found.";
                }
            } else {
                echo "Username is not available in the session.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
}