<?php

declare(strict_types=1);

function admin_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$errors = $errors ?? [];
$newsItem = $newsItem ?? [
    'title' => '',
    'teaser' => '',
    'content' => '',
    'published_at' => '',
    'is_published' => false,
];
$mode = $mode ?? 'new';
$id = $id ?? null;
$titleText = $mode === 'edit' ? 'News bearbeiten' : 'Neue News';
$actionUrl = $mode === 'edit' && $id !== null
    ? '/?admin=news&action=edit&id=' . (int) $id
    : '/?admin=news&action=new';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= admin_escape($titleText) ?></title>
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
            <h1><?= admin_escape($titleText) ?></h1>
        </div>

        <div class="card">
            <?php if (isset($errors['general'])): ?>
                <p class="alert"><?= admin_escape($errors['general']) ?></p>
            <?php endif; ?>

            <form method="post" action="<?= admin_escape($actionUrl) ?>">
                <div class="stack">
                    <label for="title">Titel</label>
                    <input id="title" name="title" type="text" value="<?= admin_escape((string) $newsItem['title']) ?>">
                    <?php if (isset($errors['title'])): ?>
                        <p class="alert"><?= admin_escape($errors['title']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="stack">
                    <label for="teaser">Teaser</label>
                    <textarea id="teaser" name="teaser" rows="3"><?= admin_escape((string) $newsItem['teaser']) ?></textarea>
                    <?php if (isset($errors['teaser'])): ?>
                        <p class="alert"><?= admin_escape($errors['teaser']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="stack">
                    <label for="content">Inhalt</label>
                    <textarea id="content" name="content" rows="8"><?= admin_escape((string) $newsItem['content']) ?></textarea>
                    <?php if (isset($errors['content'])): ?>
                        <p class="alert"><?= admin_escape($errors['content']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="stack">
                    <label for="published_at">Datum</label>
                    <input id="published_at" name="published_at" type="date" value="<?= admin_escape((string) $newsItem['published_at']) ?>">
                    <?php if (isset($errors['published_at'])): ?>
                        <p class="alert"><?= admin_escape($errors['published_at']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="stack">
                    <label>
                        <input type="checkbox" name="is_published" value="1" <?= $newsItem['is_published'] ? 'checked' : '' ?>>
                        Veröffentlicht
                    </label>
                </div>
                <div class="form-actions">
                    <button type="submit">Speichern</button>
                    <a class="button button-secondary" href="/?admin=news">Abbrechen</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
