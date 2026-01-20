<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/styles.css">
    <script src="/assets/app.js" defer></script>
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
    <footer class="footer">
        Version <?= htmlspecialchars($appVersion) ?>
    </footer>
</body>
</html>
