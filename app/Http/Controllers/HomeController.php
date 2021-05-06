<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        /* $prod = DB::table('Productos as p')
        ->join('Existencias as e','p.IDProducto','=','e.IDProducto')
        ->select('p.IDProducto','p.Producto','p.Precio',
        'p.Imagen','p.Descripcion','p.IDCategoria','p.Estado','e.Existencias')
        ->where('p.Estado',true)->get();
         */
        //Inner join con modelos...
        $productos = Productos::select('Productos.IDProducto',
        'Productos.Producto','Productos.Precio','Productos.Imagen',
        'Productos.Descripcion','Productos.IDCategoria'
        , 'Existencias.Existencias')
        ->join('Existencias', 'Productos.IDProducto', '=', 'Existencias.IDProducto')
        ->where('Productos.Estado',true)
        ->get();
         
        return view('home',compact('productos'));
    }
}
