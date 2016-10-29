<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::plugin(
    'Datatables',
    ['path' => '/datatables'],
    function ($routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);