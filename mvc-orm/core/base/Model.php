<?php

namespace core\base;

use core\db\DBQueries;

/**
 * Class Model
 * @package core\base
 */
abstract class Model {
    /**
     * @var string
     * database table name
     */
    protected static $table;

    /**f
     * Model constructor.
     * @param $data
     */
    public function __construct($data = []) {
        foreach ($data as $field => $value)
            $this->$field = $value;
    }

    /**
     * Get all from table
     * @return array
     */
    public static function get() {
        $class = get_called_class();
        return DBQueries::instance()->from($class::$table)->get($class);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function parseFields() {
        $class = new \ReflectionClass(get_class($this));
        $fields = $class->getProperties();

        $result = [];
        foreach ($fields as $field)
            if ( !$field->isStatic() && $field->isPublic() )
                $result[] = $field->getName();
        return $result;
    }

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    public function save() {
        $data = [];
        $fields = $this->parseFields();
        foreach ($fields as $field)
            if (!is_null($this->$field))
                $data[$field] = $this->$field;

        $class = get_class($this);
        return DBQueries::instance()->insert($class::$table, $data);
    }


    public static function __callStatic($name, $arguments)
    {
        $class = get_called_class();
        $dbo = DBQueries::instance()->from($class::$table);
        return call_user_func_array([$dbo, $name], $arguments);
    }
}