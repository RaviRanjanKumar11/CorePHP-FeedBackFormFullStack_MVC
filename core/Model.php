<?php
class Model {
    protected $db;
    protected $config;
    public function __construct($config) {
        $this->config = $config;
        $this->db = Database::getInstance($config)->pdo();
    }
}
