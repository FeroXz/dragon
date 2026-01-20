<?php

declare(strict_types=1);

final class Database
{
    private PDO $pdo;

    public function __construct(string $path)
    {
        $this->pdo = new PDO('sqlite:' . $path);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }

    public function migrate(): void
    {
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                created_at TEXT NOT NULL
            )"
        );

        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS pages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                content TEXT NOT NULL,
                created_at TEXT NOT NULL
            )"
        );

        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS news (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                body TEXT NOT NULL,
                published_at TEXT NOT NULL
            )"
        );
    }
}
