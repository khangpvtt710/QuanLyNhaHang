<?php
require_once __DIR__ . '/config.php';

class Database {
    private $link;
    public $error;

    public function __construct() {
        $this->connectDB();
    }

    private function connectDB() {
        $this->link = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME,
            DB_PORT // ⭐ LUÔN DÙNG 3308
        );

        if ($this->link->connect_error) {
            die("❌ Kết nối database thất bại: " . $this->link->connect_error);
        }

        $this->link->set_charset("utf8");
    }

    public function select($query) {
        $result = $this->link->query($query);
        if ($result === false) {
            die("SQL SELECT Error: " . $this->link->error . "<br>Query: " . $query);
        }
        return ($result->num_rows > 0) ? $result : false;
    }

    public function insert($query) {
        if (!$this->link->query($query)) {
            die("SQL INSERT Error: " . $this->link->error);
        }
        return true;
    }

    public function update($query) {
        if (!$this->link->query($query)) {
            die("SQL UPDATE Error: " . $this->link->error);
        }
        return true;
    }

    public function delete($query) {
        if (!$this->link->query($query)) {
            die("SQL DELETE Error: " . $this->link->error);
        }
        return true;
    }

    public function __destruct() {
        if ($this->link) {
            $this->link->close();
        }
    }
}