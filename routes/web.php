<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
});

Route::group(['prefix' => 'api', 'middleware' => 'onlyJson'], function() {
    Route::get('/categories', 'ProductCategoryController@getAll');
    Route::post('/category/create', 'ProductCategoryController@store');

    Route::get('/files/type/{type}', 'FileController@getByType');
    Route::post('/file/upload', 'FileController@store');
    Route::get('/files/id/{id}', 'FileController@getByID');

    Route::get('/tags', 'TagController@getAll');
    Route::post('/tag/create', 'TagController@store');

    Route::get('/products', 'ProductController@getAll');
    Route::post('/product/create', 'ProductController@store');
    Route::get('/product/id/{id}', 'ProductController@getById');
    Route::post('/product/update/{id}', 'ProductController@update');

    Route::resource('brands', 'BrandController');
    Route::get('/brands', 'BrandController@getAll');
    Route::post('/brands/store', 'BrandController@store');
    Route::put('/brands/update/{id}', 'BrandController@update');
    Route::post('/brands/update/{id}', 'BrandController@update');

//    Route::resource('article-categories', 'ArticleCategoryController');
    Route::get('/article-categories', 'ArticleCategoryController@getAll');
    Route::post('/article-categories/store', 'ArticleCategoryController@store');

//    Route::resource('articles', 'ArticleController');
    Route::get('/articles', 'ArticleController@getAll');
    Route::post('/articles/store', 'ArticleController@store');
    Route::post('/articles/update/{id}', 'ArticleController@update');
    Route::get('/articles/id/{id}', 'ArticleController@getById');
});

Auth::routes();
Route::get('/home', 'HomeController@index');
Route::get('/files/{id}/{fileName}', 'FileController@show')->name('getFileByIdAndName');
Route::get('/category/all', 'ProductCategoryController@getAll');
Route::get('/product/{slug}', 'ProductController@getBySlug')->name('get-product-by-slug');
Route::get('/product/id/{id}', 'ProductController@getById')->name('get-product-by-id');

Route::get('/brand/{slug}', 'BrandController@getBySlug')->name('get-brand-by-slug');
