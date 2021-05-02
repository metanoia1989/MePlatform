<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});


//*****************************************************
// micro_blog 应用
//*****************************************************
Router::get('/microblog', [App\Controller\MicroBlogController::class, 'index']);
Router::post('/microblog', [App\Controller\MicroBlogController::class, 'store']);
Router::put('/microblog/{id}', [App\Controller\MicroBlogController::class, 'update']);
Router::delete('/microblog/{id}', [App\Controller\MicroBlogController::class, 'destroy']);