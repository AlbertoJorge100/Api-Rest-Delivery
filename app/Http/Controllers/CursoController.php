<?php

namespace App\Http\Controllers;

use App\Data\RespuestaExst;
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
        try{
            //LLenando las existencias del producto con las existencias en la tabla existencias...
            $existencias=DB::table('Existencias as e')
            ->select('e.Existencias')              
            ->where('e.IDProducto', $producto->IDProducto)->first();      
            //Existencias del producto, existencias de la tabla               
            //$producto->Existencias=$exst->Existencias;            
            
            return view('cursos.edit',['producto'=>$producto, 'existencias'=>$existencias]);        
        }catch(Exception $e){
            return  $e;
        }        
        //return $request->escribir;
    }
    public function update(Request $request, Productos $producto){  
        //Invocar funciones dentro de otra funcion...
        //$fde=$this->delete($producto);
        $request->validate([
            'producto'=>'required',
            'precio'=>'required',
            //'Existencias'=>'required',
            'imagen'=>'required',
            'descripcion'=>'required',            
        ]); 
        $contador=0;
        try{            
            if(strcmp($request->producto,$producto->Producto)!=0){ 
                $contador++;
            }
            if(strcmp($request->precio,$producto->Precio)!=0){ 
                $contador++;
            }
            if(strcmp($request->imagen,$producto->Imagen)!=0){ 
                $contador++;
            }
            if(strcmp($request->descripcion,$producto->Descripcion)!=0){ 
                $contador++;
            }
            if($request->activo!=$producto->Activo){
                $contador++;
            }            
            //Validar si el campo de existencias esta vacio
            if(!empty($_POST["add_existencias"])){
                //sumando las existencias
                $exst=0;
                switch($request->operacion){
                    case "suma":
                        $exst=($request->existencias+$request->add_existencias);
                        break;
                    case "resta":
                        $exst=($request->existencias-$request->add_existencias);
                        if($exst<0){
                            $exst=0;
                        }
                        break;
                }                
                DB::table('Existencias as e')
                ->where('e.IDProducto', $producto->IDProducto)
                ->update(['e.Existencias' => $exst]);             
            }
            if($contador>0){
                $producto->Producto=$request->producto;
                $producto->Precio=$request->precio;
                $producto->Imagen=$request->imagen;
                $producto->Descripcion=$request->descripcion;
                //$producto->IDCategoria=$request->IDCategoria;        
                $producto->Activo=$request->activo;
                $producto->save();
            }                    
        }catch(Exception $e){
            return $e;
        } 
        //return $request->existencias;        
        //return $producto;
        return redirect()->route('home.home');            
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

