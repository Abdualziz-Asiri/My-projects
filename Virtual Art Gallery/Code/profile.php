<?php
define('TITLE', "Profile");
include 'profileh.inc.php';
include 'header.php';
?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
            </div>

            <div class="col-sm-8 text-center" id="user-section">
                <h2><?php echo $user['username']; ?></h2>
                <h6><?php echo $user['nam']; ?></h6>
                <h6><?php echo $user['email']; ?></h6>
                <h6><?php echo $user['addres']; ?></h6>
                <h6><?php echo $user['typ']; ?></h6>
                <p><?php echo $user['bio']; ?></p>

                <hr>
                <h3>Posted Artwork</h3>

                <?php
                if (count($artwork) === 0) {
                    echo '<p>No artwork posted yet.</p>';
                } else {
                    echo '<div class="art-container">';
                    echo '<table>';
                    echo '<tr>';
                    foreach ($artwork as $art) {
                        echo '<td>';
                        echo '<div class="artwork-container">';
                        echo '<img class="artwork-image" src="' . $art['image_url'] . '" alt="' . $art['artwork_title'] . '">';
                        echo '<h4>Artwork title: ' . $art['artwork_title'] . '</h4>';
                        echo '<p>Art explain: ' . $art['artwork_type'] . '</p>';
                        echo '<p>Price: ' . $art['price'] . 'SR</p>';
                        echo '<form class="dele" action="deleteh.php" method="POST">';
                        echo '<input type="hidden" name="artwork_id" value="' . $art['artwork_id'] . '">';
                        echo '<input type="submit" value="Delete Artwork">';
                        echo '</form>';
                        echo '</div>';
                        echo '</td>';
                    }
                    echo '</tr>';
                    echo '</table>';
                    echo '</div>';
                }
                ?>

                <hr>
                <h3>Upload Artwork</h3>

                <form action="uploadh.php" method="POST" enctype="multipart/form-data">
                    <label for="artwork_title">Artwork Title:</label>
                    <input type="text" name="artwork_title" required><br>
                    <label for="artwork_type">Artwork Type:</label>
                    <input type="text" name="artwork_type" required><br>
                    <label for="price">Price:</label>
                    <input type="number" name="price" required><br>
                    <label for="image">Image:</label>
                    <input type="file" name="image" required><br>
                    <button type="submit">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>