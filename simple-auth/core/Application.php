<?php

namespace core;
use core\db\DatabaseBuilder;

/**
 * Class Application
 * @package core
 */
class Application {
    /**
     * @throws
     */
    public static function init() {
        $actions = [
            'core\db\DatabaseBuilder' => 'build',
            'core\Router' => 'route',
        ];

        self::run($actions);
    }

    /**
     * @param $actions
     */
    private static function run($actions) {
        foreach ($actions as $class_name => $method_name) {
            call_user_func([$class_name, $method_name]);
        }
    }
}