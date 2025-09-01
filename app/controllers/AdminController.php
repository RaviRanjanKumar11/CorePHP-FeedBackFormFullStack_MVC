<?php

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Feedback.php';
class AdminController extends Controller {
    private function requireLogin() {
        if (empty($_SESSION['admin_id'])) {
            $this->redirect('/admin/login');
        }
    }
    public function login() {
        if ($this->isPost()) {
            
            if (!$this->verifyCsrf($_POST['csrf_token'] ?? '')) {
                http_response_code(400);
                echo 'Invalid CSRF token.';
                exit;
            }
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $adminModel = new Admin($this->config);
            $admin = $adminModel->findByUsername($username);
            // var_dump(password_verify($password, $admin['password']));
            // exit;
            
            if ($admin && password_verify($password, $admin['password'])) {
             

                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $this->redirect('/admin/dashboard');
            } else {
                $this->view('admin/login', [
                    'error' => 'Invalid credentials.',
                    'csrf_token' => $this->csrfToken(),
                    'title' => 'Admin Login'
                ]);
            }
        } else {
            $this->view('admin/login', ['csrf_token' => $this->csrfToken(), 'title' => 'Admin Login']);
        }
    }
    public function logout() {
        session_destroy();
        $this->redirect('/admin/login');
    }
    public function dashboard() {
        $this->requireLogin();
        $fb = new Feedback($this->config);
        $items = $fb->getAll();
        $this->view('admin/dashboard', [
            'items' => $items,
            'title' => 'Admin Dashboard',
            'csrf_token' => $this->csrfToken()
        ]);
    }
    public function approve() {
        $this->requireLogin();
        if (!$this->verifyCsrf($_GET['csrf_token'] ?? '')) {
            http_response_code(400);
            echo 'Invalid CSRF token.';
            exit;
        }
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $fb = new Feedback($this->config);
            $fb->setStatus($id, 'approved');
        }
        $this->redirect('/admin/dashboard');
    }
    public function reject() {
        $this->requireLogin();
        if (!$this->verifyCsrf($_GET['csrf_token'] ?? '')) {
            http_response_code(400);
            echo 'Invalid CSRF token.';
            exit;
        }
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $fb = new Feedback($this->config);
            $fb->setStatus($id, 'rejected');
        }
        $this->redirect('/admin/dashboard');
    }
}
