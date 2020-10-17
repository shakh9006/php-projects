<?php

namespace core;
/**
 * Class Application
 * @package core
 */
class Application {
    /**
     * @throws
     */
    public static function run() {
        Router::route();
    }
}