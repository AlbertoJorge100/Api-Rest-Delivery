<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Categorias;
use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Existencias;
class CursoController extends Controller
{    
    public function index(){
    //cursos.indes: el punto indica que esta dentro de la carpeta cursos    
        return view('cursos.index');
    }
    //Enviando un modelo como parametro para poder utilizarlo alla....
    public function create(){
        $categorias=Categorias::all();
        return view('cursos.create',compact('categorias'));
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
    

    public function store(Request $request){

        //Validacion de formularios...
        $request->validate([
            'Producto'=>'required|max:20|min:5',
            'Precio'=>'required',
            'Existencias'=>'required',
            'Imagen'=>'required',
            'Descripcion'=>'required',
            'IDCategoria'=>'required'
        ]);
        
        $producto =new Productos();
        $producto->Producto=$request->Producto;
        $producto->Precio=$request->Precio;
        $producto->Existencias=$request->Existencias;
        $producto->Imagen=$request->Imagen;
        $producto->Descripcion=$request->Descripcion;
        $producto->IDCategoria=$request->IDCategoria;
        //$producto->Estado=$request->Estado;        
        $producto->save(); //save o create    
        
        if(isset($producto)){
            return redirect()->route('home.home');    
        }
        //return $request->all();
    }

    public function edit(Productos $producto){
        //Haremos una excepcion de la busqueda por id...
        /* $existencias=DB::table('Existencias as e')
            ->select('e.Existencias')
            ->join('Productos as p','e.IDProducto','=','p.IDProducto')
            ->where('e.IDProducto',$producto->IDProducto)->get();        
        $id=$existencias->first(); */
        
        return view('cursos.edit',compact('producto'));        
        //return $producto;
    }
    public function update(Request $request, Productos $producto){        
        $request->validate([
            'Producto'=>'required',
            'Precio'=>'required',
            'Existencias'=>'required',
            'Imagen'=>'required',
            'Descripcion'=>'required',            
        ]);
        
        try{
            $exst=DB::table('Existencias')            
            ->select('Existencias')
            ->where('IDProducto',$producto->IDProducto)
            ->get();            
        }catch(Exception $e){
            echo $e;
        }        
        /* Existencias::where('IDProducto',$request->IDProducto)
            ->update(['Existencias'=>$request->Existencias]); 

        $producto->Producto=$request->Producto;
        $producto->Precio=$request->Precio;
        $producto->Existencias=$request->Existencias;
        $producto->Imagen=$request->Imagen;
        $producto->Descripcion=$request->Descripcion;
        //$producto->IDCategoria=$request->IDCategoria;        
        $producto->Estado=$request->Estado;
        $producto->save();
        
        return redirect()->route('home.home');
        */
        return $exst;
    }

    /*
    Delete si se eliminara en realidad...
    public function delete($id){
        $productos=Productos::find($id);
        $productos->delete();
        return redirect()->route('home.home');
    }*/
    public function delete(Productos $producto){        
        $producto->Estado=false;
        $producto->save();
        return redirect()->route('home.home');
    }
}

