<?php

namespace app\controllers;
use core\base\Controller;

/**
 * Class MainController
 * @package app\controllers
 */
class MainController extends Controller  {
    public function testAction() {
        $this->view('home', [
            'name' => 'Alex',
        ]);
    }

    public function indexAction() {
        echo 123;
    }
}