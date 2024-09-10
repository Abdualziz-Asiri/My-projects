<!--adminheade.php-->
<!DOCTYPE html>
<html>
<head>
    <title>Virtual Art Gallery</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
    <button id="menuButton"></button>    
    <nav class="menu">
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="adabout.php">About</a></li>
            <?php
            include_once 'dbh.inc.php';
            include_once 'loginh.inc.php';
            if (isset($_SESSION["admin_username"])) {
                echo '<li><a href="logout.php">Logout</a></li>';
            } else {
                echo '<li><a href="Login.php">Login</a></li>';
                // Add any other menu items or logic you require for non-admin users
            }
            ?>
            <li><a href="http://localhost:5173/">Virtual Exhibition</a></li>
        </ul>
    </nav>
</header>

<script src="jscodes.js"></script>
</body>
</html>