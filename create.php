<?php
 
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $barcode = $_POST['barcode'];

    $sql = "INSERT INTO products (name, description, price, quantity, barcode) VALUES (:name, :description, :price, :quantity, :barcode)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':quantity' => $quantity,
            ':barcode' => $barcode,
        ]);

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Create New Product</h2>
        <form action="create.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required><br>
            <label for="description">Description:</label>
            <input type="text" name="description"><br>
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" required><br>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required><br>
            <label for="barcode">Barcode:</label>
            <input type="text" name="barcode"><br><br>
            <input type="submit" value="Create">
        </form>
    </div>
</body>
</html>