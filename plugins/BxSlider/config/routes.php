<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::plugin(
    'BxSlider',
    ['path' => '/bx-slider'],
    function ($routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);