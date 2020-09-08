<?php

namespace app\controllers;

use core\base\Controller;

/**
 * Class NewsController
 * @package app\controllers
 */
class NewsController extends Controller {

    public function newsAction() {
        $this->view('news', [

        ]);
    }
}