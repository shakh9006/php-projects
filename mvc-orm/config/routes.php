<?php

use core\router\Route;

return [
    'routes' => [
        new Route('contact', [
           'action' => 'test',
           'controller' => 'MainController',
        ]),

        new Route('', [
            'action' => 'index',
            'controller' => 'MainController',
        ]),
    ]
];