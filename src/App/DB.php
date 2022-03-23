<?php

namespace App;

use PDO;
use PDOException;

class DB
{
    /**
     * Will be the PDO object
     **/
    private $dbh;
    private $stmt;

    public function __construct()
    {
        /**
         * Set DSN
         */
        $dsn = Config::DRIVER .
            ':host=' . Config::HOST .
            ';dbname=' . Config::DBNAME .
            ';charset=' . Config::CHARSET;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        /**
         * Create PDO instance
         */
        try {
            $this->dbh = new PDO($dsn, Config::USER, Config::PASSWORD, $options);
        } catch (PDOException $e) {
            $dieMessage = "Не удается подключиться к базе данных";
            flash("error", $dieMessage, "danger");
            dieWithErrorMessage($dieMessage);
        }
    }

    /**
     * Prepare statement with query
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Bind values, to prepared statement using named parameters
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute the prepared statement
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Return multiple records
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Return a single record
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get row count
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}