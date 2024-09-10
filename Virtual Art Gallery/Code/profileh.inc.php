<?php
session_start();
require_once "dbh.inc.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['username'])) {
    $username = $_GET['username'];
} else {
    $username = $_SESSION['username'];
}

$sql = "SELECT * FROM users WHERE username = :username;";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM artwork AS a
        JOIN users AS u ON u.user_id = a.user_id
        WHERE u.username = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$artwork = $stmt->fetchAll(PDO::FETCH_ASSOC);
