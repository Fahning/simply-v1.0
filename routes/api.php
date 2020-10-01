<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::group([

    'middleware' => 'apiJwt',
    'namespace' => 'Api',
    'prefix' => 'auth'

], function ($router) {

//    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('users', 'UserController@index');

});


Route::group([
    'middleware' => 'apiJwt',
    'namespace' => 'Api',
    'prefix' => 'product'
], function ($router) {
    Route::get('all', 'ProductController@index');
    Route::get('category/{id}', 'ProductController@seachByCategory');
    Route::get('{id}', 'ProductController@show');
    Route::post('new', 'ProductController@store');
    Route::put('edit/{id}', 'ProductController@update');
    Route::delete('delete/{id}', 'ProductController@destroy');
});

Route::group([
    'middleware' => 'apiJwt',
    'namespace' => 'Api',
    'prefix' => 'category'
], function ($router) {
    Route::get('all', 'CategoryController@index');
    Route::get('categorysWithProducts', 'CategoryController@categorysWithProducts');
    Route::get('{id}', 'CategoryController@show');
    Route::post('new', 'CategoryController@store');
    Route::put('edit/{id}', 'CategoryController@update');
    Route::delete('delete/{id}', 'CategoryController@destroy');
});

Route::group([
    'middleware' => 'apiJwt',
    'namespace' => 'Api',
    'prefix' => 'models'
], function ($router) {
    Route::get('all', 'ModelsController@index');
    Route::get('{id}', 'ModelsController@show');
    Route::post('new', 'ModelsController@store');
    Route::put('edit/{id}', 'ModelsController@update');
    Route::delete('delete/{id}', 'ModelsController@destroy');
});

Route::group([
    'middleware' => 'apiJwt',
    'namespace' => 'Api',
    'prefix' => 'brand'
], function ($router) {
    Route::get('all', 'BrandController@index');
    Route::get('{id}', 'BrandController@show');
    Route::post('new', 'BrandController@store');
    Route::put('edit/{id}', 'BrandController@update');
    Route::delete('delete/{id}', 'BrandController@destroy');
});


Route::group([

    'namespace' => 'Api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');

});

//GRUPO DE VENDAS E METODOS RELACIONADOS
Route::group([
    'middleware' => 'apiJwt',
    'namespace' => 'Api',
    'prefix' => 'operations'

], function ($router) {

    Route::post('newSell', 'SellsController@newSell');
    Route::get('showAll', 'SellsController@showAll');
    Route::get('sellsToday', 'SellsController@sellsToday');
    Route::get('tablesSells', 'SellsController@tablesSells');
    Route::get('selectOptions', 'OperationsController@selectOptions');

});

