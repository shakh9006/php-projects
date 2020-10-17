<?php
namespace application\controllers;

use core\base\Controller;

/**
 * Class HomeController
 * @package application\controllers
 */
class HomeController extends Controller {
    public function indexAction() {
        $id = $this->get_param('id');
        $this->view('home/index', [
            'id' => $id,
        ]);
    }
}