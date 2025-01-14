<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $specs = $_POST['specs'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("INSERT INTO computers (name, position, specs, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $position, $specs, $status]);
    
    header("Location: main.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Computer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Computer</h2>
        <form method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Specs</label>
                <textarea name="specs" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="retired">Retired</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Computer</button>
            <a href="main.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>