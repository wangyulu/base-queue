<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2019-05-08
 * Time: 15:03
 */

Route::group(['prefix' => '1.0', 'namespace' => 'V1_0'], function ($router) {
    Route::group(['prefix' => 'test', 'namespace' => 'Test'], function ($router) {
        $router->get('/queue/store/user', 'QueueController@storeUser');
    });
});