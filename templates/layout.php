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
    <header class="topbar">
        <div class="nav-inner">
            <a class="brand" href="/?page=home">Dragon CMS</a>
            <nav class="nav-links">
                <a href="/?page=home">Start</a>
                <?php foreach ($navigationPages as $navigationPage): ?>
                    <a href="/?page=page&slug=<?= htmlspecialchars($navigationPage['slug']) ?>">
                        <?= htmlspecialchars($navigationPage['title']) ?>
                    </a>
                <?php endforeach; ?>
                <a href="/?page=pages">Seitenübersicht</a>
                <a href="/?page=news">News</a>
                <a href="/?page=admin">Admin</a>
            </nav>
            <div class="nav-actions">
                <?php if ($isLoggedIn) : ?>
                    <span class="badge">Angemeldet als <?= htmlspecialchars($currentUser['username'] ?? '') ?></span>
                    <a class="button button-secondary" href="/?page=logout">Logout</a>
                <?php else : ?>
                    <a class="button button-secondary" href="/?page=login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main class="content">
        <?= $content ?>
    </main>
    <footer class="footer">
        Version <?= htmlspecialchars($appVersion) ?>
    </footer>
</body>
</html>
