<?php

namespace core\db;

abstract class Connection {
    /**
     * Connection db
     * @return mixed|null
     */
    public static function connect() {
        try {
            $conn = new \PDO(DB_TYPE .':host='. DB_HOST .';dbname='. DB_NAME, DB_USER_NAME, DB_PASSWORD);
            // set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return null;
    }
}