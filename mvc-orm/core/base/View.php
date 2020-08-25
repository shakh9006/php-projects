<?php

namespace core\base;

/**
 * Class View
 * @package core\base
 */
class View {
    /**
     * @param $name
     * @param array $data
     * @return mixed
     */
    public static function render($name, $data = []) {
        $path = VIEW_DIR . $name . '.php';
        if ( file_exists( $path ) ) {
            extract($data);
            require_once $path;
            return ob_get_clean();
        }
    }
}