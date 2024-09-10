<!-- adindex.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Virtual Art Gallery</title>
    <?php
    session_start();
    include 'adminheade.php'; 
    require_once 'dbh.inc.php';
    require_once 'shoppingcarth.inc.php';

    if (isset($_POST['add_to_cart'])) {
        if (isset($_SESSION['user_id'])) {
            $artworkId = $_POST['artwork_id'];
            $userId = $_SESSION['user_id'];

            try {
                addToCart($artworkId, $userId);
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid session or user not logged in.";
        }
    }
    ?>
</head>
<body>
    
    <main>
        <div class="Home-content">
            <h1>Welcome to Virtual Art Gallery</h1>
            <p>
                Explore a diverse collection of artwork from talented emerging artists. Immerse yourself in virtual exhibitions and discover the beauty of art.
            </p>
        </div>

        <div class="Artist-list">
            <h2>Featured Artists</h2>

            <?php
            try {
                // Fetch artists who have artwork available
                $query = "SELECT DISTINCT u.nam, u.username FROM users AS u
                          JOIN artwork AS a ON u.user_id = a.user_id;";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $username = $user['username'];

                    // Fetch the artwork for the artist
                    $artworkQuery = "SELECT artwork_id, image_url FROM artwork
                                     WHERE user_id = (SELECT user_id FROM users WHERE username = :username)
                                     LIMIT 3;";
                    $artworkStmt = $pdo->prepare($artworkQuery);
                    $artworkStmt->bindParam(":username", $username);
                    $artworkStmt->execute();
                    $artworks = $artworkStmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($artworks)) {
                        echo "<div class='Artist-item'>";
                        echo "<h3><a href='userview.php?username=" . $username . "'>" . $user['nam'] . "</a></h3>";

                        foreach ($artworks as $artwork) {
                            // Display the image and add to cart button
                            echo '<div class="artwork-item">';
                            echo '<img src="' . $artwork['image_url'] . '" alt="">';
                            echo '<form action="adindex.php" method="post">';
                            echo '<input type="hidden" name="artwork_id" value="' . $artwork['artwork_id'] . '">';
                            echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
                            echo '</form>';
                            echo '</div>';
                        }

                        echo "</div>";
                    }
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
            ?>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
</body>
</html>