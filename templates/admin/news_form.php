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
    <title><?= admin_escape($titleText) ?></title>
</head>
<body>
    <h1><?= admin_escape($titleText) ?></h1>

    <?php if (isset($errors['general'])): ?>
        <p><?= admin_escape($errors['general']) ?></p>
    <?php endif; ?>

    <form method="post" action="<?= admin_escape($actionUrl) ?>">
        <div>
            <label for="title">Titel</label><br>
            <input id="title" name="title" type="text" value="<?= admin_escape((string) $newsItem['title']) ?>">
            <?php if (isset($errors['title'])): ?>
                <p><?= admin_escape($errors['title']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label for="teaser">Teaser</label><br>
            <textarea id="teaser" name="teaser" rows="3" cols="60"><?= admin_escape((string) $newsItem['teaser']) ?></textarea>
            <?php if (isset($errors['teaser'])): ?>
                <p><?= admin_escape($errors['teaser']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label for="content">Inhalt</label><br>
            <textarea id="content" name="content" rows="8" cols="60"><?= admin_escape((string) $newsItem['content']) ?></textarea>
            <?php if (isset($errors['content'])): ?>
                <p><?= admin_escape($errors['content']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label for="published_at">Datum</label><br>
            <input id="published_at" name="published_at" type="date" value="<?= admin_escape((string) $newsItem['published_at']) ?>">
            <?php if (isset($errors['published_at'])): ?>
                <p><?= admin_escape($errors['published_at']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label>
                <input type="checkbox" name="is_published" value="1" <?= $newsItem['is_published'] ? 'checked' : '' ?>>
                Veröffentlicht
            </label>
        </div>
        <div>
            <button type="submit">Speichern</button>
            <a href="/?admin=news">Abbrechen</a>
        </div>
    </form>
</body>
</html>
