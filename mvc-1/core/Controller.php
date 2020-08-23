<?php

namespace core;

abstract class Controller {

    public $model = 'Home';
    /**
     * Call needle action of Class and pass data
     * @param $action
     * @param array $data
     */
    public function execAction ($action, $data = []) {
        call_user_func_array( [ $this, $action ], $data );
    }

    public function view($path, $data = []) {
        $template_path =  ROOT_VIEW .  $path . '.php';

        if ( file_exists($template_path) ) {
            extract($data);
            ob_start();
            require_once  $template_path;
            echo ob_get_clean();
        }

        exit;
    }

    public function model($model) {
        $model = '\app\models\\' . $model;
        if ( class_exists( $model ) ) {
            $this->model = new $model;
        }
    }
}