<?php
require_once 'config/db.php';

try {
    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    
    if ($userCount == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, photo_url) VALUES (?, ?, ?)");
        $stmt->execute([
            'admin',
            password_hash('password123', PASSWORD_DEFAULT),
            'https://via.placeholder.com/150'
        ]);
        echo "Created test user: admin (password: password123)<br>";
    }

    $computerCount = $pdo->query("SELECT COUNT(*) FROM computers")->fetchColumn();
    
    if ($computerCount == 0) {
        $computers = [
            [
                'Desktop PC 1',
                'Reception',
                'Intel i5, 16GB RAM, 512GB SSD',
                'active'
            ],
            [
                'Laptop 1',
                'HR Office',
                'MacBook Pro M1, 8GB RAM, 256GB SSD',
                'active'
            ],
            [
                'Workstation 1',
                'Design Department',
                'AMD Ryzen 9, 32GB RAM, 1TB SSD, RTX 3080',
                'maintenance'
            ],
            [
                'Server 1',
                'Server Room',
                'Dual Xeon, 128GB RAM, 4TB RAID',
                'active'
            ],
            [
                'Old PC',
                'Storage',
                'Intel Core 2 Duo, 4GB RAM, 500GB HDD',
                'retired'
            ]
        ];

        $stmt = $pdo->prepare("INSERT INTO computers (name, position, specs, status) VALUES (?, ?, ?, ?)");
        
        foreach ($computers as $computer) {
            $stmt->execute($computer);
        }
        
        echo "Created " . count($computers) . " sample computers<br>";
    }

    echo "<br>Database initialized successfully!<br>";
    echo "<a href='login.php'>Go to login page</a>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>