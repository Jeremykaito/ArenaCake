<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::plugin(
    'ContactManager',
    ['path' => '/bx-slider'],
    function ($routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);