<?php
$dbPath = __DIR__ . '/../database/company_inventory.sqlite';
$dbDir = dirname($dbPath);

if (!is_dir($dbDir)) {
    mkdir($dbDir, 0777, true);
}

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND (name='users' OR name='computers')")->fetchAll();
    
    if (count($tables) < 2) {

        $pdo->exec(file_get_contents(__DIR__ . '/../database.sql'));
        
        $stmt = $pdo->prepare("INSERT INTO users (username, password, photo_url) VALUES (?, ?, ?)");
        $stmt->execute([
            'admin',
            password_hash('password123', PASSWORD_DEFAULT),
            'https://via.placeholder.com/150'
        ]);
        
        $computers = [
            ['Desktop PC 1', 'Reception', 'Intel i5, 16GB RAM, 512GB SSD', 'active'],
            ['Laptop 1', 'HR Office', 'MacBook Pro M1, 8GB RAM, 256GB SSD', 'active'],
            ['Workstation 1', 'Design Department', 'AMD Ryzen 9, 32GB RAM, 1TB SSD', 'maintenance'],
            ['Server 1', 'Server Room', 'Dual Xeon, 128GB RAM, 4TB RAID', 'active'],
            ['Old PC', 'Storage', 'Intel Core 2 Duo, 4GB RAM, 500GB HDD', 'retired']
        ];

        $stmt = $pdo->prepare("INSERT INTO computers (name, position, specs, status) VALUES (?, ?, ?, ?)");
        foreach ($computers as $computer) {
            $stmt->execute($computer);
        }
    }
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>