<?php

declare(strict_types=1);

class PageRepository
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
            CREATE TABLE IF NOT EXISTS pages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                content TEXT NOT NULL,
                created_at TEXT NOT NULL,
                updated_at TEXT NOT NULL
            )
        SQL;

        $this->pdo->exec($sql);
    }

    public function fetchAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM pages ORDER BY created_at DESC');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchForNavigation(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM pages WHERE slug != :slug ORDER BY title ASC');
        $stmt->execute([':slug' => 'home']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM pages WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        return $page ?: null;
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM pages WHERE slug = :slug');
        $stmt->execute([':slug' => $slug]);
        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        return $page ?: null;
    }

    public function create(string $title, string $slug, string $content): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO pages (title, slug, content, created_at, updated_at)
            VALUES (:title, :slug, :content, :created_at, :updated_at)'
        );

        $now = (new DateTimeImmutable())->format(DateTimeInterface::ATOM);
        $stmt->execute([
            ':title' => $title,
            ':slug' => $slug,
            ':content' => $content,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function ensureHomePageExists(): void
    {
        $existing = $this->findBySlug('home');

        if ($existing !== null) {
            return;
        }

        $this->create(
            'Startseite',
            'home',
            'Dies ist die Startseite der Beispielanwendung.' . PHP_EOL
            . 'Das CMS läuft komplett im Darkmode und bietet klare, moderne Oberflächen.'
        );
    }

    public function update(int $id, string $title, string $slug, string $content): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE pages
            SET title = :title,
                slug = :slug,
                content = :content,
                updated_at = :updated_at
            WHERE id = :id'
        );

        $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':slug' => $slug,
            ':content' => $content,
            ':updated_at' => (new DateTimeImmutable())->format(DateTimeInterface::ATOM),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM pages WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        if ($ignoreId !== null) {
            $stmt = $this->pdo->prepare('SELECT 1 FROM pages WHERE slug = :slug AND id != :id');
            $stmt->execute([':slug' => $slug, ':id' => $ignoreId]);
        } else {
            $stmt = $this->pdo->prepare('SELECT 1 FROM pages WHERE slug = :slug');
            $stmt->execute([':slug' => $slug]);
        }

        return (bool) $stmt->fetchColumn();
    }
}
