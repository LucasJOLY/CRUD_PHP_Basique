<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private const DB_HOST = '127.0.0.1';
    private const DB_NAME = 'demo_db';
    private const DB_USER = 'root';
    private const DB_PASS = 'rootpassword';
    private static ?Database $instance = null;
    private ?PDO $connection = null;

    public function __construct()
    {
        $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME;
        try {
            $this->connection = new PDO($dsn, self::DB_USER, self::DB_PASS);
        } catch (PDOException $e) {
            throw new PDOException("Erreur de connexion à la bdd : " . $e->getMessage());
        }
    }


    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }


    public function deco(): void
    {
        $this->connection = null;
    }
}
