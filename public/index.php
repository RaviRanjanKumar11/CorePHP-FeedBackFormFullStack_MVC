<?php
$config = require __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Controller.php';

// Get URI and strip query string
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove /index.php if present in URI
$uri = preg_replace('#^/index\.php#', '', $uri);

// Remove base path (e.g. /php_feedback_system/public if not in vhost)
$basePath = rtrim($config['app']['base_url'], '/');
$path = trim(str_replace($basePath, '', $uri), '/');

// Special case: root
if ($path === '') {
    $path = '/';
}

function route($path, $config) {
    require_once __DIR__ . '/../app/controllers/FeedbackController.php';
    require_once __DIR__ . '/../app/controllers/AdminController.php';

    switch ($path) {
        case '':
        case '/':
        case 'feedback/form':
            (new FeedbackController($config))->form();
            break;
        case 'feedback/submit':
            (new FeedbackController($config))->submit();
            break;
        case 'feedback/approved':
            (new FeedbackController($config))->approved();
            break;
        case 'admin/login':
            (new AdminController($config))->login();
            break;
        case 'admin/logout':
            (new AdminController($config))->logout();
            break;
        case 'admin/dashboard':
            (new AdminController($config))->dashboard();
            break;
        case 'admin/approve':
            (new AdminController($config))->approve();
            break;
        case 'admin/reject':
            (new AdminController($config))->reject();
            break;
        default:
            http_response_code(404);
            echo "404 Not Found<br>PATH: " . htmlspecialchars($path);
    }
}

route($path, $config);
