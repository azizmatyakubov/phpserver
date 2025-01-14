<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: main.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $specs = $_POST['specs'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE computers SET name = ?, position = ?, specs = ?, status = ? WHERE id = ?");
    $stmt->execute([$name, $position, $specs, $status, $id]);
    
    header("Location: main.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM computers WHERE id = ?");
$stmt->execute([$id]);
$computer = $stmt->fetch();

if (!$computer) {
    header("Location: main.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Computer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Computer</h2>
        <form method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" 
                       value="<?php echo htmlspecialchars($computer['name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position" class="form-control" 
                       value="<?php echo htmlspecialchars($computer['position']); ?>" required>
            </div>
            <div class="form-group">
                <label>Specs</label>
                <textarea name="specs" class="form-control"><?php echo htmlspecialchars($computer['specs']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active" <?php echo $computer['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="maintenance" <?php echo $computer['status'] == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                    <option value="retired" <?php echo $computer['status'] == 'retired' ? 'selected' : ''; ?>>Retired</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Computer</button>
            <a href="main.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>