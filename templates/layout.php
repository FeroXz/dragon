<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        nav a { margin-right: 1rem; }
        .card { border: 1px solid #ddd; padding: 1rem; margin-bottom: 1rem; border-radius: 6px; }
    </style>
</head>
<body>
    <nav>
        <a href="/?page=home">Start</a>
        <a href="/?page=pages">Seiten</a>
        <a href="/?page=news">News</a>
        <a href="/?page=admin">Admin</a>
        <?php if ($isLoggedIn) : ?>
            <span>Angemeldet als <?= htmlspecialchars($currentUser['username'] ?? '') ?></span>
            <a href="/?page=logout">Logout</a>
        <?php else : ?>
            <a href="/?page=login">Login</a>
        <?php endif; ?>
    </nav>
    <main>
        <?= $content ?>
    </main>
</body>
</html>
