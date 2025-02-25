<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/**
 * Redirect to original url.
 */

$router->get('/{hash}', 'UrlManagement\RedirectController');


/**
 * Group `/short`.
 *
 * Contains resource routes to manage URL's.
 */

$router->group(['prefix' => 'short'], function () use ($router) {
    $router->post('/', 'UrlManagement\CreateUrlController');
    $router->get('/{hash}', 'UrlManagement\GetUrlInfoController');
    $router->put('/{hash}', 'UrlManagement\UpdateUrlController');
    $router->delete('/{hash}', 'UrlManagement\DeleteUrlController');
});
