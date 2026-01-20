<?php

declare(strict_types=1);

final class Seeder
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function seedAdminUser(): void
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS count FROM users');
        $count = (int) $stmt->fetchColumn();

        if ($count > 0) {
            return;
        }

        $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);

        $insert = $this->pdo->prepare(
            'INSERT INTO users (username, password_hash, created_at) VALUES (:username, :password_hash, :created_at)'
        );
        $insert->execute([
            'username' => 'admin',
            'password_hash' => $passwordHash,
            'created_at' => date('c'),
        ]);
    }
}
