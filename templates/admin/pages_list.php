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
    <title>Seitenverwaltung</title>
</head>
<body>
    <h1>Seitenverwaltung</h1>

    <p><a href="/?admin=pages&action=new">Neue Seite anlegen</a></p>

    <?php if ($pages === []): ?>
        <p>Keine Seiten vorhanden.</p>
    <?php else: ?>
        <table border="1" cellpadding="6" cellspacing="0">
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
                        <td>
                            <a href="/?admin=pages&action=edit&id=<?= (int) $page['id'] ?>">Bearbeiten</a>
                            |
                            <a href="/?admin=pages&action=delete&id=<?= (int) $page['id'] ?>">Löschen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
