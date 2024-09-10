<?php
require_once 'dbh.inc.php';

session_start();
function deleteArtwork($pdo, $artworkId) {
    try {
        // Delete the artwork from the database
        $query = "DELETE FROM artwork WHERE artwork_id = :artwork_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":artwork_id", $artworkId);
        $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Database Error: " . $e->getMessage());
    }
}