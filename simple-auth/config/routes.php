<?php
use core\Route;

/**
 * Register routes
 */
Route::add_route('/', 'HomeController@indexAction');
Route::add_route('/sign-in', 'AccountController@sign_in');
Route::add_route('/sign-up', 'AccountController@sign_up');

Route::add_route('/login', ['controller' => 'AccountController', 'action' => 'loginAction']);
Route::add_route('/register', ['controller' => 'AccountController', 'action' => 'registerAction']);

