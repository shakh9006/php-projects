<?php
/**
 * Routes
 */

use \core\Route;

return [
    'routes' => [
        new Route('/news', [
            'action' => 'newsAction',
            'controller' => 'NewsController'
        ]),

        new Route('/', [
            'action' => 'indexAction',
            'controller' => 'MainController'
        ])
    ]
];