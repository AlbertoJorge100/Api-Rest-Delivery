<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CursoController extends Controller
{    
    public function index(){
    //cursos.indes: el punto indica que esta dentro de la carpeta cursos    
        return view('cursos.index');
    }
    public function create(){
        return view('cursos.create');
    }
    public function show($curso){
        /*
        compact('curso');
        se traduce a: ['curso'=>$curso]
        el parametro entre comillas lo recibimos en la variable
        $curso, podemos usar compact o no, es opcional
        */

        //Envio del parametro $curso para rescatarlo en la vista
        return view('cursos.show',['curso'=>$curso]);
        /*if($categoria){
            return "Bienvenido al curso: $curso, Categoria: $categoria";
          }else{
            return "Bienvenido al curso: $curso";
          }*/
    }
}

