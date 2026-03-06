  <?php
session_start();
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food_name = trim($_POST["food_name"]);
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    if (!empty($food_name) && $quantity >= 0 && $price >= 0) {
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, food_name, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION["user_id"], $food_name, $quantity, $price]);
        $success = "Transaction added successfully!";
    } else {
        $error = "Please fill all fields correctly.";
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="mb-4 text-center">Add New Food Transaction</h3>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Food Name</label>
                <input type="text" name="food_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" min="0" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" step="0.01" class="form-control" min="0" required>
            </div>
            <button type="submit" class="btn btn-success w-100 mb-3">Add Transaction</button>
        </form>

        <div class="d-flex justify-content-between">
            <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
            <a href="read.php" class="btn btn-primary">View Transactions →</a>
        </div>
    </div>
</div>

</body>
</html>
