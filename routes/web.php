<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

/*Route::get('/', function () {
    return redirect('/welcome');
});*/

Route::get('/', 'PageController@index'); //pocetna stranica

/*Route::get('/register', function () {
    return view('register');
});
*/

/*Route::get('/login', function () {
    return view('login');
});*/

Route::get('/editProfil', 'UserController@checkCreds');
Route::get('/editProfil', [
    'uses' => 'UserController@editProfil'
  ]);
Route::post('/editProfil', [
    'uses' => 'UserController@editProfil'
  ]);

Route::get('/uvjetiKoristenja', function () {
    return view('uvjetiKoristenja');
});

Route::get('/oNama', function () {
    return view('oNama');
});

Route::get('/login', 'UserController@login');
Route::post('/login', 'UserController@login');
Route::post('/resetPassword', 'UserController@resetPassword');
Route::get('/resetPassword', 'UserController@resetPassword');
Route::post('/changePassword', 'UserController@changePassword');
Route::get('/changePassword', 'UserController@changePassword');
Route::post('/checkKod', 'UserController@checkKod');
Route::get('/register', 'UserController@register');
Route::post('/registerUser', 'UserController@register');
Route::get('/logout', 'UserController@logout');
Route::post('/addToWish/{id}', 'UserController@addToWish');
Route::post('/addToCart/{id}', 'UserController@addToCart');
Route::post('/removeFromCart/{id}', 'UserController@removeFromCart');
Route::get('/cart', 'UserController@cart');
Route::post('/updateKolicina/{id}', 'UserController@updateKolicina');
Route::post('/blagajna', 'UserController@blagajna');
Route::get('/blagajna', 'UserController@blagajna');
Route::post('/dodajKomentar/{id}', 'UserController@dodajKomentar');

Route::get('/products', 'ProductsController@index');
Route::get('/product/{id}', 'ProductsController@getProduct');
Route::post('/deleteWish/{id}', 'ProductsController@deleteWish');

Route::get('/adminPanel', 'AdminController@adminPanel');
Route::post('/deleteUser', 'AdminController@deleteUser');
Route::post('/updateUser', 'AdminController@updateUser');
Route::get('/adminPanel/addAdminUser', 'AdminController@addAdminUser');
Route::post('/adminPanel/addAdminUser', 'AdminController@addAdminUser');
Route::get('/adminPanel/addProduct', 'AdminController@addProduct');
Route::post('/adminPanel/addProduct', 'AdminController@addProduct');
Route::get('/adminPanel/editProducts', 'AdminController@editProducts');
Route::get('/adminPanel/editKategorije', 'AdminController@editKategorije');
Route::post('/adminPanel/editKategorije', 'AdminController@editKategorije');
Route::put('/adminPanel/editKategorije', 'AdminController@editKategorije');
Route::delete('/adminPanel/editKategorije', 'AdminController@editKategorije');
Route::post('/deleteProduct', 'AdminController@deleteProduct');
Route::post('/editProduct', 'AdminController@editProduct');

Route::get('/adminPanel/posebneAkcije', 'AdminController@posebneAkcije');
Route::post('/adminPanel/posebneAkcije', 'AdminController@posebneAkcije');
Route::put('/adminPanel/posebneAkcije', 'AdminController@posebneAkcije');
Route::delete('/adminPanel/posebneAkcije', 'AdminController@posebneAkcije');


Route::get('/getProductByString/{string}', 'ApiController@getProductByString');
Route::post('/checkKod', 'ApiController@checkKod');


?>