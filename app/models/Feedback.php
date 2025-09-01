<?php
require_once __DIR__ . '/../../core/Model.php';
class Feedback extends Model {
    public function create($data) {
        $stmt = $this->db->prepare('INSERT INTO feedbacks (full_name, email, rating, message, status, created_at) VALUES (:full_name, :email, :rating, :message, :status, NOW())');
        $stmt->execute([
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':rating' => $data['rating'],
            ':message' => $data['message'],
            ':status' => 'pending',
        ]);
        return $this->db->lastInsertId();
    }
    public function findByEmail($email) {
        $stmt = $this->db->prepare('SELECT * FROM feedbacks WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }
    public function getApproved() {
        $stmt = $this->db->query('SELECT id, full_name, rating, message, created_at FROM feedbacks WHERE status = "approved" ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }
    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM feedbacks ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }
    public function setStatus($id, $status) {
        $stmt = $this->db->prepare('UPDATE feedbacks SET status = :status, reviewed_at = NOW() WHERE id = :id');
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }
}
