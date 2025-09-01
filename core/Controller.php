<?php
class Controller {
    protected $config;
    public function __construct($config) {
        $this->config = $config;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    protected function view($path, $data = []) {
        extract($data);
        require __DIR__ . '/../app/views/' . $path . '.php';
    }
    protected function redirect($path) {
        $base = rtrim($this->config['app']['base_url'], '/');
        header('Location: ' . $base . $path);
        exit;
    }
    protected function isPost() {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }
    protected function csrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    protected function verifyCsrf($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
