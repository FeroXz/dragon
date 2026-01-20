<?php

declare(strict_types=1);

$basePath = dirname(__DIR__);

require_once $basePath . '/src/Database.php';
require_once $basePath . '/src/Auth.php';
require_once $basePath . '/src/Seeder.php';
require_once $basePath . '/src/PageRepository.php';
require_once $basePath . '/src/NewsRepository.php';
require_once $basePath . '/src/controllers/AdminPagesController.php';
require_once $basePath . '/src/controllers/AdminNewsController.php';

session_start();

$databaseDir = $basePath . '/data';
if (!is_dir($databaseDir)) {
    mkdir($databaseDir, 0775, true);
}

$dbPath = $databaseDir . '/app.sqlite';
$database = new Database($dbPath);
$database->migrate();

$pdo = $database->pdo();
$seeder = new Seeder($pdo);
$seeder->seedAdminUser();
$pageRepository = new PageRepository($pdo);
$newsRepository = new NewsRepository($pdo);
$auth = new Auth($pdo);

$adminRoute = $_GET['admin'] ?? '';
if ($adminRoute === 'pages') {
    $auth->requireLogin();
    $controller = new AdminPagesController($pageRepository, $basePath . '/templates/admin');
    echo $controller->handle($_GET, $_POST);
    exit;
}

if ($adminRoute === 'news') {
    $auth->requireLogin();
    $controller = new AdminNewsController($newsRepository, $basePath . '/templates/admin');
    echo $controller->handle($_GET, $_POST);
    exit;
}

function render(string $template, array $data = []): void
{
    global $auth;

    $isLoggedIn = $auth->isLoggedIn();
    $currentUser = $auth->currentUser();
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

function loginController(Auth $auth): void
{
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($auth->login($username, $password)) {
            header('Location: /?page=admin');
            exit;
        }

        $error = 'Ungültige Zugangsdaten.';
    }

    render('login', [
        'title' => 'Login',
        'error' => $error,
    ]);
}

function logoutController(Auth $auth): void
{
    $auth->logout();
    header('Location: /?page=home');
    exit;
}

function adminController(Auth $auth): void
{
    $auth->requireLogin();
    render('admin/dashboard', ['title' => 'Admin-Dashboard']);
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
        loginController($auth);
        break;
    case 'logout':
        logoutController($auth);
        break;
    case 'admin':
        adminController($auth);
        break;
    case 'home':
    default:
        homeController();
        break;
}
