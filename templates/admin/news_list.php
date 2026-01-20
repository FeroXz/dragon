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
    <title>News-Verwaltung</title>
</head>
<body>
    <h1>News-Verwaltung</h1>

    <p><a href="/?admin=news&action=new">Neue News anlegen</a></p>

    <?php if ($news === []): ?>
        <p>Keine News vorhanden.</p>
    <?php else: ?>
        <table border="1" cellpadding="6" cellspacing="0">
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
                        <td>
                            <a href="/?admin=news&action=edit&id=<?= (int) $item['id'] ?>">Bearbeiten</a>
                            |
                            <a href="/?admin=news&action=delete&id=<?= (int) $item['id'] ?>">Löschen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
