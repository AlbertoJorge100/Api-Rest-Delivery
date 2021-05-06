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

/**
 * En laravel 8 las rutas se declaran asi:
 * Route::get('cursos/create', [CursoController::class,'index']);
 * pero como este proyecto lo retome de clases, en el cual usaban laravel 7,
 * entonces estan las rutas de esta manera:
 * Route::Get("/Libros", "LibrosController@index");
 * En la ruta: app/Providers/RouteServiceProvider, laravel 8
 * ya no incluye la variable $namespace='App\Http\Controllers';, y por eso no permite por defecto trabajar las rutas
 * como en laravel 7, pero al querer trabajar como en laravel 7, debe crearse esa
 * variable y enlazarla en la funcion boot:
 * Route::prefix('api')
 * ->namespace($this->namespace)
 */

//Definición de la ruta para obtener todos los libros
Route::Get("/Libros", "LibrosController@index");
Route::Get("/Libros/{id}","LibrosController@show");
Route::Post("/AddLibros", "LibrosController@store");
Route::Put("/UpdateLibros", "LibrosController@update");
Route::Delete("/DelLibros", "LibrosController@destroy");
//Route::Get("/Orden/{titulo}","LibrosController@prueba"); temporal
Route::Get("/Login/{usuario}","ProductosController@Login");
Route::Get("/getExstCategoria/{idcategoria}","ProductosController@getExstCategoria");
//Route::Get("/getValidarExistencias","ProductosController@getExstCategoria");
Route::Get("/GetUsuario/{usuario}","ProductosController@SelectUsuario");
Route::Get("/GetIdFactura/{IDUsuario}","ProductosController@getIdFactura");
Route::Post("/AddCliente","ProductosController@InsertCliente");
Route::Put("/UpdateCliente","ProductosController@UpdateCliente");
Route::Get("/Categorias","ProductosController@SelectCategorias");
Route::Get("/Productos/{id}","ProductosController@SelectProductos");
Route::Get("/GetFacturas/{id}","ProductosController@getFacturas");
Route::Get("/GetFacturaProductos/{id}","ProductosController@getFacturaProductos");
//Route::Get("/GetExstCa")
Route::Post("/AddCategorias","ProductosController@InsertCategorias");
Route::Post("/AddProductos","ProductosController@InsertProductos");
Route::Post("/AddFacturaProductos","ProductosController@Pagar");
Route::Post("/getValidarExistencias","ProductosController@ValidarExistencias");

//Pruebas del servidor
Route::Get("/GetUsuarios","ProductosController@getUsuarios");
Route::Get("/GetCompras","ProductosController@getCompras");