<?php
class Database {
    private $host = 'localhost';
    private $username = 'u761334274_SantiagoV';
    private $password = 'k05$ZbO8&Po';
    private $database = 'u761334274_int_ext_hawks';
    private $conn;

    // public function __construct() {
    //     $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

    //     if ($this->conn->connect_error) {
    //         die("Error de conexión a la base de datos: " . $this->conn->connect_error);
    //     }
    // }
    
    public function __construct() {
        date_default_timezone_set('America/Bogota');
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Error de conexión a la base de datos: " . $this->conn->connect_error);
        }
        $this->conn->query("SET time_zone = '-05:00'");
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
