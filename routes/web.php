<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


//crea tutte le rotte per l autenticazione e gestione degli utenti
Auth::routes();

//crea una rotto per la home-page pubblica
Route::get('/', 'HomeController@index')->name('home');

Route::middleware("auth")
->namespace("Admin") // indica la cartella dove si trovano i controller
->name("admin.") // aggiunge prima del nome di ogni rotta questo prefisso
->prefix("admin") // aggiunge prima di ogni URI questo prefisso
->group(function(){

    //crea una rotta per la home-page amministrativa
    Route::get('/', 'HomeController@index')->name('index');

    //rotta per la index degli utenti, mi mostra la lista degli utente
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::put('/users/{user}', 'UserController@update')->name('users.update');
    Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
    

    //mi crea tutte le rotte crud per i post
    Route::resource("posts", "PostController");
});

