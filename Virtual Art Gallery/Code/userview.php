<!-- userview.php-->
<!DOCTYPE html>
<html>
<head>
    <title>Artist Profile</title>
    <?php
    session_start();
    require_once 'dbh.inc.php';
    require_once 'shoppingcarth.inc.php';
    ?>

</head>
<body>
    <?php include 'header.php'; ?>
    
    <main>
        <div class="Artist-profile">
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
                                         WHERE user_id = (SELECT user_id FROM users WHERE username = :username);";
                        $artworkStmt = $pdo->prepare($artworkQuery);
                        $artworkStmt->bindParam(":username", $username);
                        $artworkStmt->execute();
                        $artworks = $artworkStmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($artworks as $artwork) {
                            // Display the image and add to cart button
                            echo '<div class="artwork-item">';
                            echo '<img src="' . $artwork['image_url'] . '" alt="">';
                            echo '<form action="index.php" method="post">';
                            echo '<input type="hidden" name="artwork_id" value="' . $artwork['artwork_id'] . '">';
                            echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
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
    
    <?php include 'footer.php'; ?>
</body>
</html>