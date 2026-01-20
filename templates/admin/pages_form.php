<?php

declare(strict_types=1);

function admin_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$errors = $errors ?? [];
$page = $page ?? ['title' => '', 'slug' => '', 'content' => ''];
$mode = $mode ?? 'new';
$id = $id ?? null;
$titleText = $mode === 'edit' ? 'Seite bearbeiten' : 'Neue Seite';
$actionUrl = $mode === 'edit' && $id !== null
    ? '/?admin=pages&action=edit&id=' . (int) $id
    : '/?admin=pages&action=new';
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
            <input id="title" name="title" type="text" value="<?= admin_escape((string) $page['title']) ?>">
            <?php if (isset($errors['title'])): ?>
                <p><?= admin_escape($errors['title']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label for="slug">Slug</label><br>
            <input id="slug" name="slug" type="text" value="<?= admin_escape((string) $page['slug']) ?>">
            <?php if (isset($errors['slug'])): ?>
                <p><?= admin_escape($errors['slug']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label for="content">Inhalt</label><br>
            <textarea id="content" name="content" rows="8" cols="60"><?= admin_escape((string) $page['content']) ?></textarea>
            <?php if (isset($errors['content'])): ?>
                <p><?= admin_escape($errors['content']) ?></p>
            <?php endif; ?>
        </div>
        <div>
            <button type="submit">Speichern</button>
            <a href="/?admin=pages">Abbrechen</a>
        </div>
    </form>
</body>
</html>
