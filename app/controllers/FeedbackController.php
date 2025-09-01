<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Feedback.php';
class FeedbackController extends Controller {
    public function form() {
        $this->view('feedback/form', ['csrf_token' => $this->csrfToken(), 'title' => 'Submit Feedback']);
    }
    private function validate($input) {
        $errors = [];
        $full_name = trim($input['full_name'] ?? '');
        if ($full_name === '' || mb_strlen($full_name) < 3 || !preg_match('/^[A-Za-z ]+$/u', $full_name)) {
            $errors['full_name'] = 'Full name must be at least 3 characters and contain only letters and spaces.';
        }
        $email = trim($input['email'] ?? '');
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        } else {
            $fb = new Feedback($this->config);
            $existing = $fb->findByEmail($email);
            if ($existing) {
                $errors['email'] = 'This email has already submitted feedback.';
            }
        }
        $rating = $input['rating'] ?? '';
        if (!in_array($rating, ['1','2','3','4','5'], true)) {
            $errors['rating'] = 'Please select a rating between 1 and 5.';
        }
        $message = trim($input['message'] ?? '');
        if ($message === '' || mb_strlen($message) > 250 || !preg_match('/^[A-Za-z0-9 .,!?;:\'\"()\-\n\r]+$/u', $message)) {
            $errors['message'] = 'Message must be up to 250 chars; allowed letters, numbers, spaces, and punctuation.';
        }
        return [$errors, [
            'full_name' => $full_name,
            'email' => $email,
            'rating' => (int)$rating,
            'message' => $message
        ]];
    }
    public function submit() {
        if (!$this->isPost()) {
            $this->redirect('/feedback/form');
        }
        if (!$this->verifyCsrf($_POST['csrf_token'] ?? '')) {
            http_response_code(400);
            echo 'Invalid CSRF token.';
            exit;
        }
        [$errors, $clean] = $this->validate($_POST);
        if ($errors) {
            $this->view('feedback/form', [
                'errors' => $errors,
                'old' => $_POST,
                'csrf_token' => $this->csrfToken(),
                'title' => 'Submit Feedback'
            ]);
            return;
        }
        $fb = new Feedback($this->config);
        try {
            $fb->create($clean);
            $this->view('feedback/success', ['title' => 'Feedback Submitted']);
        } catch (Exception $e) {
            $this->view('feedback/error', ['message' => 'Failed to submit feedback. Please try again later.', 'title' => 'Error']);
        }
    }
    public function approved() {
        $fb = new Feedback($this->config);
        $items = $fb->getApproved();
        $this->view('feedback/approved', ['items' => $items, 'title' => 'Approved Feedback']);
    }
}
