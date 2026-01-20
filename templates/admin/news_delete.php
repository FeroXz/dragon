<?php

declare(strict_types=1);

function admin_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$errors = $errors ?? [];
$newsItem = $newsItem ?? null;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>News löschen</title>
</head>
<body>
    <h1>News löschen</h1>

    <?php if (isset($errors['general'])): ?>
        <p><?= admin_escape($errors['general']) ?></p>
    <?php endif; ?>

    <?php if ($newsItem !== null): ?>
        <p>Möchten Sie die News "<?= admin_escape($newsItem['title']) ?>" wirklich löschen?</p>
        <form method="post" action="/?admin=news&action=delete&id=<?= (int) $newsItem['id'] ?>">
            <button type="submit">Löschen</button>
            <a href="/?admin=news">Abbrechen</a>
        </form>
    <?php else: ?>
        <p><a href="/?admin=news">Zurück zur Übersicht</a></p>
    <?php endif; ?>
</body>
</html>
