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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            border-bottom: 1px solid #ddd;
        }
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .table {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn {
            border-radius: 5px;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
        }
        .rounded-circle {
            border: 2px solid #007bff;
        }
        footer {
            background-color: #f1f1f1;
            padding: 10px 0;
            text-align: center;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand font-weight-bold">Company Inventory</span>
            <div class="ml-auto d-flex align-items-center">
                <img src="<?php echo htmlspecialchars($_SESSION['photo_url']); ?>" 
                     class="rounded-circle" 
                     style="width: 40px; height: 40px; object-fit: cover;">
                <span class="ml-2 font-weight-bold text-primary"> <?php echo htmlspecialchars($_SESSION['username']); ?> </span>
                <a href="logout.php" class="btn btn-outline-danger ml-3">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <h2 class="text-center mb-4">Computers List</h2>
        <a href="add_computer.php" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Add New Computer</a>

        <div class="card p-3">
            <table class="table table-hover">
                <thead class="thead-dark">
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
                               class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            <a href="delete_computer.php?id=<?php echo $computer['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Company Inventory. All Rights Reserved.</p>
    </footer>
</body>
</html>