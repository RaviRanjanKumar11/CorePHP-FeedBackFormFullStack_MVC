<?php
require_once __DIR__ . '/../../core/Model.php';
class Admin extends Model {
    public function findByUsername($username) {
        $stmt = $this->db->prepare('SELECT * FROM admins WHERE username = :username LIMIT 1');
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }
}
