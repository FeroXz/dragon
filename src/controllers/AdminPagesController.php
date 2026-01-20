<?php

declare(strict_types=1);

class AdminPagesController
{
    private PageRepository $pages;
    private string $templateBase;

    public function __construct(PageRepository $pages, string $templateBase)
    {
        $this->pages = $pages;
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
                return $this->render('pages_list.php', [
                    'pages' => $this->pages->fetchAll(),
                ]);
        }
    }

    private function handleCreate(array $post): string
    {
        $data = [
            'title' => trim((string) ($post['title'] ?? '')),
            'slug' => trim((string) ($post['slug'] ?? '')),
            'content' => trim((string) ($post['content'] ?? '')),
        ];

        $errors = [];
        if ($post) {
            $errors = $this->validate($data);
            if (!isset($errors['slug']) && $this->pages->slugExists($data['slug'])) {
                $errors['slug'] = 'Der Slug ist bereits vergeben.';
            }

            if ($errors === []) {
                $this->pages->create($data['title'], $data['slug'], $data['content']);
                header('Location: /?admin=pages');
                exit;
            }
        }

        return $this->render('pages_form.php', [
            'page' => $data,
            'errors' => $errors,
            'mode' => 'new',
        ]);
    }

    private function handleEdit(array $get, array $post): string
    {
        $id = isset($get['id']) ? (int) $get['id'] : 0;
        $page = $this->pages->findById($id);

        if ($page === null) {
            return $this->render('pages_form.php', [
                'page' => ['title' => '', 'slug' => '', 'content' => ''],
                'errors' => ['general' => 'Seite nicht gefunden.'],
                'mode' => 'edit',
            ]);
        }

        $data = [
            'title' => trim((string) ($post['title'] ?? $page['title'])),
            'slug' => trim((string) ($post['slug'] ?? $page['slug'])),
            'content' => trim((string) ($post['content'] ?? $page['content'])),
        ];

        $errors = [];
        if ($post) {
            $errors = $this->validate($data);
            if (!isset($errors['slug']) && $this->pages->slugExists($data['slug'], $id)) {
                $errors['slug'] = 'Der Slug ist bereits vergeben.';
            }

            if ($errors === []) {
                $this->pages->update($id, $data['title'], $data['slug'], $data['content']);
                header('Location: /?admin=pages');
                exit;
            }
        }

        return $this->render('pages_form.php', [
            'page' => $data,
            'errors' => $errors,
            'mode' => 'edit',
            'id' => $id,
        ]);
    }

    private function handleDelete(array $get, array $post): string
    {
        $id = isset($get['id']) ? (int) $get['id'] : 0;
        $page = $this->pages->findById($id);

        if ($page === null) {
            return $this->render('pages_delete.php', [
                'page' => null,
                'errors' => ['general' => 'Seite nicht gefunden.'],
            ]);
        }

        if ($post) {
            $this->pages->delete($id);
            header('Location: /?admin=pages');
            exit;
        }

        return $this->render('pages_delete.php', [
            'page' => $page,
            'errors' => [],
        ]);
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['title'] === '') {
            $errors['title'] = 'Bitte einen Titel angeben.';
        }

        if ($data['slug'] === '') {
            $errors['slug'] = 'Bitte einen Slug angeben.';
        } elseif (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $data['slug'])) {
            $errors['slug'] = 'Der Slug darf nur Kleinbuchstaben, Zahlen und Bindestriche enthalten.';
        }

        if ($data['content'] === '') {
            $errors['content'] = 'Bitte einen Inhalt angeben.';
        }

        return $errors;
    }

    private function render(string $template, array $data): string
    {
        extract($data, EXTR_SKIP);

        ob_start();
        include $this->templateBase . '/' . $template;

        return (string) ob_get_clean();
    }
}
