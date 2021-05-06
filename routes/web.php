<?php

use App\Http\Controllers\CursoController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\HomeController;
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


/* ->name('cursos.index'): sirve para identificar las rutas
    y asi poder llamarlas facilmente en cualquier lugar con laravel
*/
Route::get('/', HomeController::class)->name('home.home');
Route::get('cursos/', [CursoController::class,'index'])->name('cursos.index');
Route::get('cursos/create/', [CursoController::class,'create'])->name('cursos.create');
Route::get('cursos/{curso}', [CursoController::class,'show'])->name('cursos.show');
Route::post('cursos/store',[CursoController::class, 'store'])->name('cursos.store');
Route::get('cursos/edit/{producto}',[CursoController::class, 'edit'])->name('cursos.edit');
Route::put('cursos/update/{producto}',[CursoController::class, 'update'])->name('cursos.update');
Route::get('cursos/delete/{producto}',[CursoController::class,'delete'])->name('cursos.delete');


//Route::get('cursos/{curso}','CursoController@show');
?>
