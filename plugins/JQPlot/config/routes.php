<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::plugin(
    'JQPlot',
    ['path' => '/jq-plot'],
    function ($routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);