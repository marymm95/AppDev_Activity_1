<?php
include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $barcode = $_POST['barcode'];

    $sql = "UPDATE products SET name = :name, description = :description, price = :price, quantity = :quantity, barcode = :barcode, updatedAt = NOW() WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':quantity' => $quantity,
            ':barcode' => $barcode,
            ':id' => $id,
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
        <h2>Update Product</h2>
        <form action="update.php?id=<?php echo htmlspecialchars($product['id']); ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>
            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo htmlspecialchars($product['description']); ?>"><br>
            <label for="price">Price:</label>
            <input type="number" step="5" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required><br>
            <label for="barcode">Barcode:</label>
            <input type="text" name="barcode" value="<?php echo htmlspecialchars($product['barcode']); ?>"><br><br>

            <input type="submit" value="Update">

        </form>
    </div>
</body>
</html>