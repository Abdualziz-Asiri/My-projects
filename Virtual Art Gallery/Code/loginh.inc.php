<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        require_once "dbh.inc.php";

        // Check if the user is an admin
        $adminQuery = "SELECT * FROM admin WHERE username = :username AND pwd = :pwd;";
        $adminStmt = $pdo->prepare($adminQuery);
        $adminStmt->bindParam(":username", $username);
        $adminStmt->bindParam(":pwd", $pwd);
        $adminStmt->execute();

        if ($adminStmt->rowCount() == 1) {
            // Admin authentication successful
            session_start();
            $_SESSION["admin_username"] = $username;
            header("Location:admin.php");
            exit();
        }

        // User authentication
        $query = "SELECT * FROM users WHERE username = :username AND pwd = :pwd;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $pwd);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            // User authentication successful
            session_start();
            $_SESSION["username"] = $username;

            // Fetch the user type from the database
            $userTypeQuery = "SELECT typ FROM users WHERE username = :username;";
            $userTypeStmt = $pdo->prepare($userTypeQuery);
            $userTypeStmt->bindParam(":username", $username);
            $userTypeStmt->execute();
            $userType = $userTypeStmt->fetch(PDO::FETCH_ASSOC)["typ"];

            // Redirect based on user type
            if ($userType === "Artist") {
                header("Location: profile.php?login=success");
            } elseif ($userType === "Art_enthusiast") {
                header("Location: profile.ent.php?login=success");
            } else {
                // User type not recognized
                header("Location: login.php?error=invalid");
            }
            exit();
        } else {
            // User authentication failed
            header("Location: login.php?error=invalid");
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}