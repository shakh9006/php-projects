<?php

namespace core\db;

abstract class DatabaseBuilder {

    /**
     * @var \PDO
     */
    private static $conn;

    public static function build() {
        self::$conn = Connection::connect();
        $query      = 'CREATE TABLE IF NOT EXISTS `accounts` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `username` varchar(50) NOT NULL,
                    `password` varchar(255) NOT NULL,
                    `email` varchar(100) NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
        ';

        self::$conn->exec($query);
    }

    /**
     * Register user
     * @param $user_name
     * @param $password
     * @param $email
     * @return array
     */
    public static function create_user($user_name, $password, $email) {
        $sql  = 'INSERT INTO accounts (username, password, email) VALUES (?,?,?)';
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([$user_name, password_hash($password, PASSWORD_DEFAULT), $email]);

        $handler = self::select_by_email($email);
        return $handler->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Check user email already exist
     * @return boolean
     * @param $email
     */
    public static function email_exist($email) {
        $handler = self::select_by_email($email);
        return $handler->rowCount() !== 0;
    }

    /**
     * @param $email
     * @return mixed
     */
    private static function select_by_email($email) {
        $handler = self::$conn->prepare("SELECT * FROM accounts WHERE email = :email");
        $handler->bindParam(':email', $email);
        $handler->execute();
        return $handler;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function select_by_id($id) {
        $handler = self::$conn->prepare("SELECT * FROM accounts WHERE id = :id");
        $handler->bindParam(':id', $id);
        $handler->execute();
        return $handler->fetch(\PDO::FETCH_ASSOC);
    }

    public static function user_can_login($email, $pass) {
        $data    = [];
        $handler = self::select_by_email($email);
        if ($handler->rowCount() > 0) {
            $result = $handler->fetch(\PDO::FETCH_ASSOC);
            if (password_verify($pass, $result['password'])) {
                $data = $result;
            }
        }

        return $data;
    }

    public static function logout() {

    }
}