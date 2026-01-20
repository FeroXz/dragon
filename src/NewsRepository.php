<?php

declare(strict_types=1);

class NewsRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->initializeSchema();
    }

    private function initializeSchema(): void
    {
        $sql = <<<'SQL'
            CREATE TABLE IF NOT EXISTS news (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                teaser TEXT NOT NULL,
                content TEXT NOT NULL,
                published_at TEXT NOT NULL,
                is_published INTEGER NOT NULL DEFAULT 0,
                created_at TEXT NOT NULL,
                updated_at TEXT NOT NULL
            )
        SQL;

        $this->pdo->exec($sql);
    }

    public function fetchAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM news ORDER BY published_at DESC, id DESC');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchPublished(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM news WHERE is_published = 1 ORDER BY published_at DESC, id DESC'
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM news WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $news = $stmt->fetch(PDO::FETCH_ASSOC);

        return $news ?: null;
    }

    public function findPublishedById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM news WHERE id = :id AND is_published = 1');
        $stmt->execute([':id' => $id]);
        $news = $stmt->fetch(PDO::FETCH_ASSOC);

        return $news ?: null;
    }

    public function create(
        string $title,
        string $teaser,
        string $content,
        string $publishedAt,
        bool $isPublished
    ): int {
        $stmt = $this->pdo->prepare(
            'INSERT INTO news (title, teaser, content, published_at, is_published, created_at, updated_at)
            VALUES (:title, :teaser, :content, :published_at, :is_published, :created_at, :updated_at)'
        );

        $now = (new DateTimeImmutable())->format(DateTimeInterface::ATOM);
        $stmt->execute([
            ':title' => $title,
            ':teaser' => $teaser,
            ':content' => $content,
            ':published_at' => $publishedAt,
            ':is_published' => $isPublished ? 1 : 0,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(
        int $id,
        string $title,
        string $teaser,
        string $content,
        string $publishedAt,
        bool $isPublished
    ): void {
        $stmt = $this->pdo->prepare(
            'UPDATE news
            SET title = :title,
                teaser = :teaser,
                content = :content,
                published_at = :published_at,
                is_published = :is_published,
                updated_at = :updated_at
            WHERE id = :id'
        );

        $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':teaser' => $teaser,
            ':content' => $content,
            ':published_at' => $publishedAt,
            ':is_published' => $isPublished ? 1 : 0,
            ':updated_at' => (new DateTimeImmutable())->format(DateTimeInterface::ATOM),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM news WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
