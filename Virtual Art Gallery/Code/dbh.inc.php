<?php

$host='localhost';
$dbname='virtual_art_gallery';
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname",$dbusername, $dbpassword); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// dbh.inc.php

// ... Your existing code ...

function getUserType($pdo, $username) {
    $query = "SELECT typ FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $userType = $stmt->fetch(PDO::FETCH_ASSOC)["typ"];

    return $userType;
}