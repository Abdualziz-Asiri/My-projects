<!-- admin.php -->
<!DOCTYPE html>
<html>
<head>
<title>Virtual Art Gallery - Admin</title>
    <?php
    session_start();
    require_once 'dbh.inc.php';
    require_once 'shoppingcarth.inc.php';
    require_once 'deleteUser.inc.php'; // Include the file with deleteUser() function

    if (isset($_POST['delete_user'])) {
    if (isset($_SESSION['admin_username'])) {
        $userId = $_POST['user_id'];

        try {
            deleteUser($pdo, $userId); // Pass the $pdo variable
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid session or admin not logged in.";
    }
}
    ?>
</head>
<body>
<?php  require_once 'adminheade.php'; ?>
    
    <main>
        <div class="Home-content">
            <h1>- Admin monitor</h1>
            
        </div>

        <div class="User-list">
            <h2>Registered Users</h2>

            <?php
            try {
                // Fetch all registered users
                $query = "SELECT * FROM users";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($users)) {
                    echo "<table>";
                    echo "<tr><th>Name</th><th>Username</th><th>Email</th><th>Action</th></tr>";

                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . $user['nam'] . "</td>";
                        echo '<td><a href="adminview.php?username=' . $user['username'] . '">' . $user['username'] . '</td>';
                        echo "<td>" . $user['email'] . "</td>";
                        echo "<td>";
                        echo '<form class="dele" action="admin.php" method="post">';
                        echo '<input type="hidden" name="user_id" value="' . $user['user_id'] . '">';
                        echo '<button type="submit" name="delete_user">Delete</button>';
                        echo '</form>';
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No users found.";
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