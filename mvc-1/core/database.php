<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql', // your driver
    'host' => '', // your host,
    'username' => '', // your username
    'password' => '', // your password
    'database' => '', // your database
    'charset' => 'utf8',
    'collaction' => 'utf_8_unicode_ci',
    'prefix' => '', // your prefix
]);

$capsule->bootEloquent();