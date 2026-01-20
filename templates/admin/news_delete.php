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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News löschen</title>
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
                <a class="button button-secondary" href="/?admin=news">Zur Übersicht</a>
            </div>
        </div>
    </header>

    <main class="content">
        <div class="page-header">
            <h1>News löschen</h1>
        </div>

        <div class="card stack">
            <?php if (isset($errors['general'])): ?>
                <p class="alert"><?= admin_escape($errors['general']) ?></p>
            <?php endif; ?>

            <?php if ($newsItem !== null): ?>
                <p>Möchten Sie die News "<?= admin_escape($newsItem['title']) ?>" wirklich löschen?</p>
                <form method="post" action="/?admin=news&action=delete&id=<?= (int) $newsItem['id'] ?>">
                    <div class="form-actions">
                        <button class="button-danger" type="submit">Löschen</button>
                        <a class="button button-secondary" href="/?admin=news">Abbrechen</a>
                    </div>
                </form>
            <?php else: ?>
                <p>Keine News gefunden.</p>
                <a class="button button-secondary" href="/?admin=news">Zurück zur Übersicht</a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
