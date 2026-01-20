<?php

declare(strict_types=1);

class AdminNewsController
{
    private NewsRepository $news;
    private string $templateBase;

    public function __construct(NewsRepository $news, string $templateBase)
    {
        $this->news = $news;
        $this->templateBase = rtrim($templateBase, '/');
    }

    public function handle(array $get, array $post): string
    {
        $action = $get['action'] ?? 'index';

        switch ($action) {
            case 'new':
                return $this->handleCreate($post);
            case 'edit':
                return $this->handleEdit($get, $post);
            case 'delete':
                return $this->handleDelete($get, $post);
            case 'index':
            default:
                return $this->render('news_list.php', [
                    'news' => $this->news->fetchAll(),
                ]);
        }
    }

    private function handleCreate(array $post): string
    {
        $data = [
            'title' => trim((string) ($post['title'] ?? '')),
            'teaser' => trim((string) ($post['teaser'] ?? '')),
            'content' => trim((string) ($post['content'] ?? '')),
            'published_at' => trim((string) ($post['published_at'] ?? '')),
            'is_published' => isset($post['is_published']),
        ];

        $errors = [];
        if ($post) {
            $errors = $this->validate($data);
            if ($errors === []) {
                $this->news->create(
                    $data['title'],
                    $data['teaser'],
                    $data['content'],
                    $data['published_at'],
                    $data['is_published']
                );
                header('Location: /?admin=news');
                exit;
            }
        }

        return $this->render('news_form.php', [
            'newsItem' => $data,
            'errors' => $errors,
            'mode' => 'new',
        ]);
    }

    private function handleEdit(array $get, array $post): string
    {
        $id = isset($get['id']) ? (int) $get['id'] : 0;
        $newsItem = $this->news->findById($id);

        if ($newsItem === null) {
            return $this->render('news_form.php', [
                'newsItem' => [
                    'title' => '',
                    'teaser' => '',
                    'content' => '',
                    'published_at' => '',
                    'is_published' => false,
                ],
                'errors' => ['general' => 'News-Eintrag nicht gefunden.'],
                'mode' => 'edit',
            ]);
        }

        $data = [
            'title' => trim((string) ($post['title'] ?? $newsItem['title'])),
            'teaser' => trim((string) ($post['teaser'] ?? $newsItem['teaser'])),
            'content' => trim((string) ($post['content'] ?? $newsItem['content'])),
            'published_at' => trim((string) ($post['published_at'] ?? $newsItem['published_at'])),
            'is_published' => $post ? isset($post['is_published']) : (bool) $newsItem['is_published'],
        ];

        $errors = [];
        if ($post) {
            $errors = $this->validate($data);
            if ($errors === []) {
                $this->news->update(
                    $id,
                    $data['title'],
                    $data['teaser'],
                    $data['content'],
                    $data['published_at'],
                    $data['is_published']
                );
                header('Location: /?admin=news');
                exit;
            }
        }

        return $this->render('news_form.php', [
            'newsItem' => $data,
            'errors' => $errors,
            'mode' => 'edit',
            'id' => $id,
        ]);
    }

    private function handleDelete(array $get, array $post): string
    {
        $id = isset($get['id']) ? (int) $get['id'] : 0;
        $newsItem = $this->news->findById($id);

        if ($newsItem === null) {
            return $this->render('news_delete.php', [
                'newsItem' => null,
                'errors' => ['general' => 'News-Eintrag nicht gefunden.'],
            ]);
        }

        if ($post) {
            $this->news->delete($id);
            header('Location: /?admin=news');
            exit;
        }

        return $this->render('news_delete.php', [
            'newsItem' => $newsItem,
            'errors' => [],
        ]);
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['title'] === '') {
            $errors['title'] = 'Bitte einen Titel angeben.';
        }

        if ($data['teaser'] === '') {
            $errors['teaser'] = 'Bitte einen Teaser angeben.';
        }

        if ($data['content'] === '') {
            $errors['content'] = 'Bitte einen Inhalt angeben.';
        }

        if ($data['published_at'] === '') {
            $errors['published_at'] = 'Bitte ein Datum angeben.';
        } elseif (!$this->isValidDate($data['published_at'])) {
            $errors['published_at'] = 'Bitte ein gültiges Datum (YYYY-MM-DD) angeben.';
        }

        return $errors;
    }

    private function isValidDate(string $value): bool
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $value);
        if ($date === false) {
            return false;
        }

        return $date->format('Y-m-d') === $value;
    }

    private function render(string $template, array $data): string
    {
        extract($data, EXTR_SKIP);

        ob_start();
        include $this->templateBase . '/' . $template;

        return (string) ob_get_clean();
    }
}
