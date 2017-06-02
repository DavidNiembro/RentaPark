<?php
/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Fichier des routes pour l'application web
 */

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
Route::get('confirmation/resend', 'Auth\RegisterController@resend');
Route::get('confirmation/{id}/{token}', 'Auth\RegisterController@confirm');

Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/MyPlaces', 'ParkController@index')->name('MyPlaces');
Route::get('/MyReservations', 'ReservationController@myReservationsIndex')->name('MyReservations');
Route::post('/search', 'ParkController@search')->name('search');
Route::get('/showOne/{i}', 'ParkController@showOne')->name('showOne');

Route::resource('park', 'ParkController');
Route::resource('reservation', 'ReservationController');

Route::put('/reservation/status/{id}/{idUser}/{status}/{start}/{end}', 'ReservationController@changeStatus')->name('changeStatus');
Route::put('/reservation/edit/{id}/{idUser}/{start}/{end}', 'ReservationController@reservationEditStore')->name('reservationEditStore');
Route::post('/reservation/reservationEdit', 'ReservationController@reservationEdit')->name('reservationEdit');
Route::post('/reservation/reservationDestroy/{id}/{idUser}/{start}/{end}', 'ReservationController@reservationDestroy')->name('reservationDestroy');