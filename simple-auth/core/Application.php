<?php

namespace core;

/**
 * Class Application
 * @package core
 */
class Application {
    public static function run() {
        Router::route();
    }
}