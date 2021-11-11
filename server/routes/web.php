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

$router->group(['middleware' => 'tp_auth'], function () use ($router) {
    $router->group(['prefix' => 'parcels'], function () use ($router) {
        $router->post('/', 'ParcelController@create');
        $router->put('/{id}', 'ParcelController@update');
        $router->get('/{id}', 'ParcelController@show');
        $router->delete('/{id}', 'ParcelController@delete');
    });

    $router->get('/prices', 'ParcelController@getDeliveryPrice');
});
