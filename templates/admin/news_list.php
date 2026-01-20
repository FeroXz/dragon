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
    <title>News-Verwaltung</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <script src="/assets/app.js" defer></script>
</head>
<body>
    <header class="topbar">
        <div class="nav-inner">
            <a class="brand" href="/?page=home">Dragon CMS</a>
            <nav class="nav-links">
                <a href="/?page=admin">Dashboard</a>
                <a href="/?admin=pages">Seiten</a>
                <a class="is-active" href="/?admin=news">News</a>
            </nav>
            <div class="nav-actions">
                <a class="button button-secondary" href="/?page=home">Frontend</a>
            </div>
        </div>
    </header>

    <main class="content">
        <div class="page-header">
            <h1>News-Verwaltung</h1>
            <a class="button" href="/?admin=news&action=new">Neue News anlegen</a>
        </div>

        <?php if ($news === []): ?>
            <div class="card muted">Keine News vorhanden.</div>
        <?php else: ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Titel</th>
                            <th>Datum</th>
                            <th>Status</th>
                            <th>Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($news as $item): ?>
                            <tr>
                                <td><?= admin_escape($item['title']) ?></td>
                                <td><?= admin_escape($item['published_at']) ?></td>
                                <td><?= $item['is_published'] ? 'Veröffentlicht' : 'Entwurf' ?></td>
                                <td class="table-actions">
                                    <a href="/?admin=news&action=edit&id=<?= (int) $item['id'] ?>">Bearbeiten</a>
                                    <a href="/?admin=news&action=delete&id=<?= (int) $item['id'] ?>">Löschen</a>
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
