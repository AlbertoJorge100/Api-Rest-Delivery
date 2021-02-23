<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Definición de la ruta para obtener todos los libros
Route::Get("/Libros", "LibrosController@index");
Route::Get("/Libros/{id}","LibrosController@show");
Route::Post("/AddLibros", "LibrosController@store");
Route::Put("/UpdateLibros", "LibrosController@update");
Route::Delete("/DelLibros", "LibrosController@destroy");
//Route::Get("/Orden/{titulo}","LibrosController@prueba"); temporal
Route::Get("/Login/{usuario}","ProductosController@Login");
Route::Get("/GetUsuario/{usuario}","ProductosController@SelectUsuario");
Route::Get("/GetIdFactura/{IDUsuario}","ProductosController@getIdFactura");
Route::Post("/AddUsuarios","ProductosController@InsertUsuarios");
Route::Put("/UpdateUsuarios","ProductosController@UpdateUsuarios");
Route::Get("/Categorias","ProductosController@SelectCategorias");
Route::Get("/Productos/{id}","ProductosController@SelectProductos");
Route::Get("/GetFacturas/{id}","ProductosController@getFacturas");
Route::Get("/GetFacturaProductos/{id}","ProductosController@getFacturaProductos");
Route::Post("/AddCategorias","ProductosController@InsertCategorias");
Route::Post("/AddProductos","ProductosController@InsertProductos");
Route::Post("/AddFacturaProductos","ProductosController@InsertFacturaProductos");

//Pruebas del servidor
Route::Get("/GetUsuarios","ProductosController@getUsuarios");
Route::Get("/GetCompras","ProductosController@getCompras");