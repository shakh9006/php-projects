<?php

namespace application\controllers;

use core\base\Controller;

/**
 * Class AuthController
 * @package application\controllers
 */
class AccountController extends Controller {
    public function loginAction() {
        $this->view('auth/login');
    }

    public function registerAction() {
        $this->view('auth/register');
    }
}