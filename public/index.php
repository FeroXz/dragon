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
=======
require_once __DIR__ . '/../src/Database.php';

$dbPath = __DIR__ . '/../data/app.sqlite';
$database = new Database($dbPath);
$database->migrate();

$page = $_GET['page'] ?? 'home';

function render(string $template, array $data = []): void
{
    extract($data, EXTR_SKIP);
    ob_start();
    require __DIR__ . '/../templates/' . $template . '.php';
    $content = ob_get_clean();
    $title = $data['title'] ?? 'Demo';
    require __DIR__ . '/../templates/layout.php';
}

function homeController(): void
{
    render('home', ['title' => 'Startseite']);
}

function pagesController(PDO $pdo): void
{
    $stmt = $pdo->query('SELECT title, content FROM pages ORDER BY id DESC');
    $pages = $stmt->fetchAll();
    render('pages', ['title' => 'Seitenliste', 'pages' => $pages]);
}

function newsController(PDO $pdo): void
{
    $stmt = $pdo->query('SELECT title, body, published_at FROM news ORDER BY id DESC');
    $news = $stmt->fetchAll();
    render('news', ['title' => 'News', 'news' => $news]);
}

function loginController(): void
{
    render('login', ['title' => 'Login']);
}

function adminController(): void
{
    render('admin', ['title' => 'Admin']);
}

switch ($page) {
    case 'pages':
        pagesController($database->pdo());
        break;
    case 'news':
        newsController($database->pdo());
        break;
    case 'login':
        loginController();
        break;
    case 'admin':
        adminController();
        break;
    case 'home':
    default:
        homeController();
        break;
}

