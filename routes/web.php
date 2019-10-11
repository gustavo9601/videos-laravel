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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/*===========================
Rutas controlador videos
=============================
*/

//Vista
Route::get('/create-video', [
    'as' => 'createVideo',  //alias a la ruta
    'middleware' => 'auth',  // especificando que middleaware usara
    'uses' => 'VideoController@createVideo'  //El controlador y funcion que usara
]);

//Guardar video por post
Route::post('/save-video', [
    'as' => 'saveVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@saveVideo'
]);

//Ruta para obtener las imagenes
//por get le pasaremos el nombre del archivo y el tipo
Route::get('/obtener-imagen/{filename}/{type}', [
    'as' => 'imageVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@getFile'
]);