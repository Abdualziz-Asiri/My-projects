<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Virtual Art Gallery</title>
    <?php
    session_start();
    require_once 'dbh.inc.php';
    include_once 'shoppingcarth.inc.php';
    
    // Check if the add to cart form is submitted
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
    <?php include 'header.php'; ?>
    
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
                echo "<h3 class='user'><a class='username' href='userview.php?username=" . $username . "'>" . $user['nam'] . "</a></h3>";

                foreach ($artworks as $artwork) {
                    // Display the image and add to cart button
                    echo '<div class="artwork-container">';
                    echo '<form class="dele" action="index.php" method="post">';
                    echo '<input type="hidden" name="artwork_id" value="' . $artwork['artwork_id'] . '">';
                    // Use the image as a submit button
                    echo '<button type="submit" name="add_to_cart" class="add-to-cart-button" style="background: none; border: none; padding: 0;">';
                    echo '<img  class="artwork-image" src="' . $artwork['image_url'] . '" alt="" style="max-width: 100%; height: auto;">';
                    echo '</button>';
                    echo '</form>';
                    echo '</div>';
                }
echo "<br /><br />"; "</div>";
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