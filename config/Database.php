<?php
class Database {
    private $host = "localhost";
    private $db_name = "ticktick_db";
    private $username = "tickuser";
    private $password = "tickticktick";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Koneksi Gagal: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>