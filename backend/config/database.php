<?php

class Database {
    private $host = 'db.tyfdfolkikmrsdxraqgt.supabase.co';
    private $db_name = 'postgres';
    private $username = 'postgres';
    private $password = '02Chlef57@'; // ici tu mets uniquement le password généré sur Supabase
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $dsn = "pgsql:host={$this->host};port=5432;dbname={$this->db_name};sslmode=require";
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
