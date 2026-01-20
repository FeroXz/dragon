<?php

declare(strict_types=1);

$basePath = dirname(__DIR__);

require_once $basePath . '/src/Database.php';
require_once $basePath . '/src/PageRepository.php';
require_once $basePath . '/src/NewsRepository.php';
require_once $basePath . '/src/controllers/AdminPagesController.php';
require_once $basePath . '/src/controllers/AdminNewsController.php';

$databaseDir = $basePath . '/data';
if (!is_dir($databaseDir)) {
    mkdir($databaseDir, 0775, true);
}

$dbPath = $databaseDir . '/app.sqlite';
$database = new Database($dbPath);
$database->migrate();

$pdo = $database->pdo();
$pageRepository = new PageRepository($pdo);
$newsRepository = new NewsRepository($pdo);

$adminRoute = $_GET['admin'] ?? '';
if ($adminRoute === 'pages') {
    $controller = new AdminPagesController($pageRepository, $basePath . '/templates/admin');
    echo $controller->handle($_GET, $_POST);
    exit;
}

if ($adminRoute === 'news') {
    $controller = new AdminNewsController($newsRepository, $basePath . '/templates/admin');
    echo $controller->handle($_GET, $_POST);
    exit;
}

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

function pagesController(PageRepository $pages): void
{
    render('pages', [
        'title' => 'Seitenliste',
        'pages' => $pages->fetchAll(),
    ]);
}

function newsController(NewsRepository $newsRepository): void
{
    $newsId = isset($_GET['id']) ? (int) $_GET['id'] : null;

    if ($newsId) {
        $newsItem = $newsRepository->findPublishedById($newsId);
        render('news/detail', [
            'title' => $newsItem ? $newsItem['title'] : 'News',
            'newsItem' => $newsItem,
        ]);
        return;
    }

    render('news/list', [
        'title' => 'News',
        'news' => $newsRepository->fetchPublished(),
    ]);
}

function loginController(): void
{
    render('login', ['title' => 'Login']);
}

function adminController(): void
{
    render('admin', ['title' => 'Admin']);
}

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'pages':
        pagesController($pageRepository);
        break;
    case 'news':
        newsController($newsRepository);
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
