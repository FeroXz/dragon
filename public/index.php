<?php

declare(strict_types=1);

$basePath = dirname(__DIR__);

require_once $basePath . '/src/PageRepository.php';
require_once $basePath . '/src/controllers/AdminPagesController.php';

$databaseDir = $basePath . '/data';
if (!is_dir($databaseDir)) {
    mkdir($databaseDir, 0775, true);
}

$pdo = new PDO('sqlite:' . $databaseDir . '/app.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pageRepository = new PageRepository($pdo);
$controller = new AdminPagesController($pageRepository, $basePath . '/templates/admin');

$adminRoute = $_GET['admin'] ?? '';
if ($adminRoute === 'pages') {
    echo $controller->handle($_GET, $_POST);
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Startseite</title>
</head>
<body>
    <h1>Willkommen</h1>
    <p>Gehe zur <a href="/?admin=pages">Seitenverwaltung</a>.</p>
</body>
</html>
