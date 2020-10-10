<?php

namespace core\db;

use core\Configurator;

/**
 * Class DBQueries
 * @package core\db
 */
class DBQueries {
    private $db;
    /**
     * SQL fields
     * @var array
     */
    private $query_params = [
        "fields" => [],
        "from" => '',
        "where" => [],
        "limit" => null,
        "having" => null,
        "groupby" => null,
        "order" => '',
        "table" => null,
        "join" => [],
    ];

    private static $instances = [];

    /**
     * @param string $name
     * DBQueries constructor
     */
    private function __construct($name = "default")
    {
        $db_config = Configurator::config('database');
        $db_config = $db_config->$name;
        $dsn = "mysql:host={$db_config['host']};dbname={$db_config['database']};charset={$db_config['charset']};port={$db_config['port']}";
        $this->db = new \PDO($dsn, $db_config['username'], $db_config['password']);
    }

    /**
     * @param string $name
     * @return DBQueries|mixed
     */
    public static function instance($name = 'default') {
        if (! empty(self::$instances[$name]) )
            return self::$instances[$name];
        return self::$instances[$name] = new self($name);
    }

    /**
     * field helper function
     * @param $field
     * @return string
     */
    private static function _field($field) {
        return '`'. str_replace('.', '`.`', $field) . '`';
    }

    /**
     * helper where function
     * @param $type
     * @param $field_name
     * @param $sign
     * @param $value
     * @param bool $native
     */
    private function _where($type, $field_name, $sign, $value, $native = false){
        if ( is_null($value) ) {
            $value = $sign;
            $sign = '=';
        }

        if ( !$native )
            $field_name = self::_field($field_name);

        if ( !$native && isset($value[0]) && $value[0] !== '?' && $value[0] !== ':' && !is_integer($value[0]))
            $value = $this->db->quote($value);

        $this->query_params['where'][] = [$type, $field_name, $sign, $value];
    }

    /**
     * @param callable $where
     * @param null $type
     * @return $this
     */
    private function _groupWhere(callable $where, $type = null) {
        if ( ! is_null($type) )
            $this->query_params['where'][] = [$type];

        $this->query_params['where'][] = [")"];
        $where($this);
        $this->query_params['where'][] = ["("];
        return $this;
    }

    /**
     * @param $fields
     * @return $this
     */
    public function select($fields = []) {
        $this->query_params['fields'] = array_map(function ($f){
            return self::_field($f);
        }, $fields);

        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function from($table) {
        $this->query_params['table'] = self::_field($table);
        return $this;
    }

    /**
     * @param $field_name
     * @param $sign
     * @param null $value
     * @param bool $native
     * @return $this
     */
    public function where($field_name, $sign, $value = null, $native = false) {
        $this->_where("", $field_name, $sign, $value, $native);
        return $this;
    }

    /**
     * @param $field_name
     * @param $sign
     * @param null $value
     * @param bool $native
     * @return $this
     */
    public function orWhere($field_name, $sign, $value = null, $native = false) {
        $this->_where("OR", $field_name, $sign, $value, $native);
        return $this;
    }

    /**
     * @param $field_name
     * @param $sign
     * @param null $value
     * @param bool $native
     * @return $this
     */
    public function andWhere($field_name, $sign, $value = null, $native = false) {
        $this->_where("AND", $field_name, $sign, $value, $native);
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function whereGroup($field) {
        $this->_groupWhere($field);
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function orWhereGroup($field) {
       return $this->_groupWhere($field, "OR");
    }

    /**
     * @param $field
     * @return $this
     */
    public function andWhereGroup($field) {
        return $this->_groupWhere($field, "AND");
    }

    /**
     * Inner function for building where
     * @return string
     */
    private function buildWhere() {
        $q = "";
        if ( ! empty($this->query_params['where']) ) {
            $q .= " WHERE";
            foreach ($this->query_params['where'] as $where) {
                $q .= " $where[0] ";
                if ( count($where) > 1 )
                    $q .= "({$where[1]} {$where[2]} {$where[3]})";
            }
        }

        return $q;
    }

    /**
     * @return string
     */
    private function queryBuilder() {
        if ( ! empty($this->query_params['table']) ) {
            $fields = !empty($this->query_params['fields']) ? $this->query_params['fields'] : '*';
            $q = "SELECT {$fields} FROM {$this->query_params["table"]} ";
            $q .= $this->buildWhere();
            return $q;
        }
        return '';
    }


    /**
     * Get all in ASSOC format
     * @param array $data
     * @return array
     */
    public function all($data = []) {
        $q = $this->queryBuilder();
        $stmt = $this->db->prepare($q);
        $stmt->execute($data);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get all in STD format
     * @param string $class
     * @param array $data
     * @return array
     */
    public function get($class, $data = []) {
        $q = $this->queryBuilder();
        $stmt = $this->db->prepare($q);
        $stmt->execute($data);

        return array_map(function ($x) use ($class) {
            return new $class($x);
        }, $stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * insert into db
     * @param $table
     * @param array $data
     * @return mixed
     */
    public function insert($table, array $data) {
        $fields = implode("`,`", array_keys($data));
        $values = implode(", :", array_keys($data));
        $stmt = $this->db->prepare("INSERT INTO `{$table}` (`{$fields}`) VALUES (:{$values})");

        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    /**
     * update table function
     * @param $table
     * @param array $data
     * @param array $params
     */
    public function update($table, array $data, array $params = []) {
        $where = $this->buildWhere();
        $list = implode(",", array_map(function ($x) {
            return "`{$x}`=:_param_$x";
        }, array_keys($data)));

        $insert_data = [];
        $q = "UPDATE {$table} SET {$list} {$where}";
        $stmt = $this->db->prepare($q);
        $stmt->execute(array_merge($insert_data, $params));
    }
}