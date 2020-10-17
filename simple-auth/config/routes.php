<?php
use core\Route;

/**
 * Register routes
 */
Route::add_route('/', 'HomeController@indexAction');
Route::add_route('/test', 'HomeController@indexAction');
Route::add_route('/test/{id}', 'HomeController@indexAction');