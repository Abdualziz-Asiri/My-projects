<!--header.php-->
<!DOCTYPE html>
<html>
<head>
    <title>Virtual Art Gallery</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
   
    <a href="shoppingcart.php">View Cart</a>
    <button id="menuButton"></button>    
    <nav class="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="About.php">About</a></li>
            <?php
            include_once 'dbh.inc.php';

            if (!isset($_SESSION["username"])) {
                echo '<li><a href="login.php">Login</a></li>';
                echo '<li><a href="signin.php">Register</a></li>';
            } else {
                 {
                    $userType = getUserType($pdo, $_SESSION["username"]); // Get the user type

                    if ($userType === "Artist") {
                        echo '<li><a href="profile.php">' . $_SESSION["username"] . '</a></li>';
                    } elseif ($userType === "Art_enthusiast") {
                        echo '<li><a href="profile.ent.php">' . $_SESSION["username"] . '</a></li>';
                    } else {
                        // Handle unrecognized user type (optional)
                        echo '<li><a href="#">' . $_SESSION["username"] . '</a></li>';
                    }
                }
                echo '<li><a href="logout.php">Logout</a></li>';
            }
            ?>
            <li><a href="http://localhost:5173/">Virtual Exhibition</a></li>
        </ul>
    </nav>
</header>

<script src="jscodes.js"></script>
</body>
</html>