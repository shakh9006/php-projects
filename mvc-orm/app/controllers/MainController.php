<?php

namespace app\controllers;

use core\base\Controller;

/**
 * Class MainController
 * @package app\controllers
 */
class MainController extends Controller {
    /**
     * Home Page
     */
    public function indexAction() {
        $this->view('home', [
            'name' => '123'
        ]);
    }
}