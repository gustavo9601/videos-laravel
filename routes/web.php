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
Route::get('/obtener-archivo/{filename}/{type}', [
    'as' => 'imageVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@getFile'
]);


//Vista que muestra el video pasandole el id
Route::get('/video-detail/{video_id}', [
    'as' => 'video-detail',
    'middleware' => 'auth',
    'uses' => 'VideoController@getVideoDetail'
]);


//Ruta para guardar los comentarios
Route::post('/save-comentario', [
    'as' => 'saveComentario',
    'middleware' => 'auth',
    'uses' => 'CommentController@store'
]);


//Ruta para eliminar el comentario de un video
Route::get('delete-comment/{comment_id}', [
    'as' => 'deleteComment',
    'middleware' => 'auth',
    'uses' => 'CommentController@deleteComment'
]);

//Ruta par eliminar el video, comentario sy archivos que este lo compongan
Route::get('/delete-video/{video_id}', [
    'as' => 'deleteVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@deleteVideo'
]);


//Ruta de la vista para actualizar el video
Route::get('update-video/{video_id}', [
    'as' => 'updateVideoVista',
    'middleware' => 'auth',
    'uses' => 'VideoController@vistaEditVideo'
]);

//Ruta para actualizar el video
Route::post('update-video/{video_id}',
    [
        'as' => 'updateVideo',
        'middleware' => 'auth',
        'uses' => 'VideoController@updateVideo'
    ]);