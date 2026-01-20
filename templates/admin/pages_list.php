<?php

declare(strict_types=1);

function admin_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seitenverwaltung</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <script src="/assets/app.js" defer></script>
</head>
<body>
    <header class="topbar">
        <div class="nav-inner">
            <a class="brand" href="/?page=home">Dragon CMS</a>
            <nav class="nav-links">
                <a href="/?page=admin">Dashboard</a>
                <a class="is-active" href="/?admin=pages">Seiten</a>
                <a href="/?admin=news">News</a>
            </nav>
            <div class="nav-actions">
                <a class="button button-secondary" href="/?page=home">Frontend</a>
            </div>
        </div>
    </header>

    <main class="content">
        <div class="page-header">
            <h1>Seitenverwaltung</h1>
            <a class="button" href="/?admin=pages&action=new">Neue Seite anlegen</a>
        </div>

        <?php if ($pages === []): ?>
            <div class="card muted">Keine Seiten vorhanden.</div>
        <?php else: ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Titel</th>
                            <th>Slug</th>
                            <th>Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page): ?>
                            <tr>
                                <td><?= admin_escape($page['title']) ?></td>
                                <td><?= admin_escape($page['slug']) ?></td>
                                <td class="table-actions">
                                    <a href="/?admin=pages&action=edit&id=<?= (int) $page['id'] ?>">Bearbeiten</a>
                                    <a href="/?admin=pages&action=delete&id=<?= (int) $page['id'] ?>">Löschen</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
