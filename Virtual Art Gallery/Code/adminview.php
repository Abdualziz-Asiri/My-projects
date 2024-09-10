<?php
require_once 'dbh.inc.php';
session_start();

function deleteArtwork($pdo, $artworkId) {
    try {
        // Delete the artwork from the database
        $query = "DELETE FROM artwork WHERE artwork_id = :artwork_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":artwork_id", $artworkId);
        $stmt->execute();
    } catch (PDOException $e) {
        // Handle the exception appropriately
        throw new Exception("Database Error: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_artwork']) && isset($_POST['artwork_id'])) {
    $artworkId = $_POST['artwork_id'];
    deleteArtwork($pdo, $artworkId);
    header("Location: adminview.php?username=" . $_GET['username']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile</title>
    <!-- Include necessary CSS or JavaScript files here -->
</head>
<body>
    <?php require_once 'adminheade.php'; ?>
    <main>
        <div class="Admin-profile">
            <?php
            if (isset($_GET['username'])) {
                $username = $_GET['username'];

                try {
                    // Fetch user information
                    $userQuery = "SELECT nam, username FROM users WHERE username = :username";
                    $userStmt = $pdo->prepare($userQuery);
                    $userStmt->bindParam(":username", $username);
                    $userStmt->execute();
                    $user = $userStmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        echo "<h1>" . $user['nam'] . "'s Profile</h1>";
                        echo "<h2>Artworks</h2>";

                        // Fetch the artworks for the artist
                        $artworkQuery = "SELECT artwork_id, image_url FROM artwork
                                         WHERE user_id = (SELECT user_id FROM users WHERE username = :username)";
                        $artworkStmt = $pdo->prepare($artworkQuery);
                        $artworkStmt->bindParam(":username", $username);
                        $artworkStmt->execute();
                        $artworks = $artworkStmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($artworks as $artwork) {
                            // Display the image and delete button
                            echo '<div class="adminartwork-item">';
                            echo '<img src="' . $artwork['image_url'] . '" alt="">';
                            echo '<form action="adminview.php?username=' . $username . '" method="post">';
                            echo '<input type="hidden" name="artwork_id" value="' . $artwork['artwork_id'] . '">';
                            echo '<button type="submit" name="delete_artwork">Delete Artwork</button>';
                            echo '</form>';
                            echo '</div>';
                        }
                    } else {
                        echo "User not found.";
                    }
                } catch (PDOException $e) {
                    die("Error: " . $e->getMessage());
                }
            } else {
                echo "Invalid request.";
            }
            ?>
        </div>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>