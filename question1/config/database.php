<?php
// ============================================================
// Database Configuration and Connection Class
// ============================================================

class Database {
    private $host = "localhost";
    private $db_name = "hospital_db";
    private $username = "root";
    private $password = "";
    private $conn;

    /**
     * Establish and return a PDO database connection.
     * @return PDO|null
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            // Set PDO error mode to exception for proper error handling
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
