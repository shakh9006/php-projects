<?php

namespace app\controllers;

use core\Controller;

class HomeController extends Controller {
    public function indexAction($name = '') {
        $this->model('Home');
        $this->model->name = $name;

        $this->view('home/index', [
            'name' => $this->model->name ? $this->model->name : 'Alex'
        ]);
    }
}