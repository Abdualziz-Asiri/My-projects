<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $nam = $_POST["nam"];
    $email = $_POST["email"];
    $addres = $_POST["addres"];
    $typ = $_POST["typ"];
    $bio = $_POST["bio"];

    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO users (username, pwd, nam, email, addres, typ, bio) VALUES (:username, :pwd, :nam, :email, :addres, :typ, :bio);";

        // Prepare and execute the SQL query 
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pwd", $pwd);
        $stmt->bindParam(":nam", $nam);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":addres", $addres);
        $stmt->bindParam(":typ", $typ);
        $stmt->bindParam(":bio", $bio);
        $stmt->execute();

        $pdo = null;
        $stmt = null;
        echo "Registration successful!";
        header("Location: login.php");
        die();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    die();
}
