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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// POSTS
$router->get('/posts', 'PostController@index');
$router->get('/posts/{id}', 'PostController@show');
$router->post('/posts', 'PostController@store');
$router->put('posts', 'PostController@store');
$router->delete('/posts/{id}', 'PostController@destroy');

// CATEGORIES
$router->get('/categories', 'CategoryController@index');
$router->get('/categories/{id}', 'CategoryController@show');
$router->post('/categories', 'CategoryController@store');
$router->put('categories', 'CategoryController@store');
$router->delete('/categories/{id}', 'CategoryController@destroy');

// TAGS
$router->get('/tags', 'TagsController@index');
$router->get('/tags/{id}', 'TagsController@show');
$router->post('/tags', 'TagsController@store');
$router->put('tags', 'TagsController@store');
$router->delete('/tags/{id}', 'TagsController@destroy');
