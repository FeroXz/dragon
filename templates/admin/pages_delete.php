<?php

declare(strict_types=1);

function admin_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$errors = $errors ?? [];
$page = $page ?? null;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Seite löschen</title>
</head>
<body>
    <h1>Seite löschen</h1>

    <?php if (isset($errors['general'])): ?>
        <p><?= admin_escape($errors['general']) ?></p>
    <?php endif; ?>

    <?php if ($page !== null): ?>
        <p>Möchten Sie die Seite "<?= admin_escape($page['title']) ?>" wirklich löschen?</p>
        <form method="post" action="/?admin=pages&action=delete&id=<?= (int) $page['id'] ?>">
            <button type="submit">Löschen</button>
            <a href="/?admin=pages">Abbrechen</a>
        </form>
    <?php else: ?>
        <p><a href="/?admin=pages">Zurück zur Übersicht</a></p>
    <?php endif; ?>
</body>
</html>
