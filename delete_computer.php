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

$stmt = $pdo->prepare("DELETE FROM computers WHERE id = ?");
$stmt->execute([$id]);

header("Location: main.php");
exit;
?>