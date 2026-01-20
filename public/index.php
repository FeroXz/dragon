<?php

declare(strict_types=1);

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
