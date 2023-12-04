<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "demande_appui";
    private $connection;

    public function __construct() {
        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->connection->connect_error) {
            throw new Exception("Échec de la connexion : " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>
