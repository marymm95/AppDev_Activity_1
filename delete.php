<?php
include 'database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id']; // Cast to integer to ensure it's a valid number

    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['id' => $id]);

        // Redirect back to the index page after deletion
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        // Log the error message to a file for debugging purposes
        error_log("Error: " . $e->getMessage(), 3, 'errors.log');
        
        // Provide a user-friendly error message
        echo "An error occurred while trying to delete the product. Please try again later.";
    }
} else {
    // Redirect back to the index page if no valid ID is provided
    header("Location: index.php");
    exit();
}
