<?php
namespace application\controllers;

use core\base\Controller;

/**
 * Class HomeController
 * @package application\controllers
 */
class HomeController extends Controller {
    public function indexAction() {
        if ( !empty($_SESSION['id']) ) {
            $this->view('home/index', []);
        } else {
            header('Location: '. SITE_URL . '/register');
        }
    }
}