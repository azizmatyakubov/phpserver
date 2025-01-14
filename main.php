<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM computers ORDER BY datetime(created_at) DESC");
$computers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <span class="navbar-brand">Company Inventory</span>
            <div class="ml-auto">
                <img src="<?php echo htmlspecialchars($_SESSION['photo_url']); ?>" 
                     class="rounded-circle" 
                     style="width: 40px; height: 40px; object-fit: cover;">
                <span class="ml-2"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" class="btn btn-outline-danger ml-3">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Computers List</h2>
        <a href="add_computer.php" class="btn btn-success mb-3">Add New Computer</a>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Specs</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($computers as $computer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($computer['name']); ?></td>
                    <td><?php echo htmlspecialchars($computer['position']); ?></td>
                    <td><?php echo htmlspecialchars($computer['specs']); ?></td>
                    <td><?php echo htmlspecialchars($computer['status']); ?></td>
                    <td>
                        <a href="edit_computer.php?id=<?php echo $computer['id']; ?>" 
                           class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete_computer.php?id=<?php echo $computer['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>