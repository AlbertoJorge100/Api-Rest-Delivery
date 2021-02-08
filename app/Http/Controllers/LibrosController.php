<?php 

namespace App\Http\Controllers;

use App\Models\Libros;
use App\Data\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

/**
 * Clase que maneja la información de los libros
 */
class LibrosController extends Controller{

    /**
     * Select * From Libros
     * 
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $respuesta = new Respuesta();
        try {
            $Libros = Libros::all();
            $respuesta->codigo = "200";
            $respuesta->mensaje = "Consulta realizada con exito";
            $respuesta->data = $Libros;
        } catch (Exception $e) {
            $respuesta->codigo = "400";
            $respuesta->mensaje = "Error al consultar los libros de la base de datos";
        }

        return $respuesta;
    } 

    /**
     * Permite el almacenamiento de un libro dentro de la base de datos
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $respuesta = new Respuesta();
        try{
            $libro = Libros::create([
                "Titulo" => $request->Titulo,
                "Autor" => $request->Autor,
                "Categoria" => $request->Categoria, 
                "Anio" => $request->Year, 
                "Editorial" => $request->Editorial
            ]);

            //Validamos que el libro se encuentre inicializado
            if(isset($libro)){
                $respuesta->codigo = "200";
                $respuesta->mensaje = "Libro creado con exito";
                $respuesta->data = $libro;
            }else{
                $respuesta->codigo = "300";
                $respuesta->mensaje = "El Libro no fue creado";
            }

        }catch(Exception $e){
            $respuesta->codigo = "400";
            $respuesta->mensaje = "Error al insertar el libro";
        }

        return $respuesta;

    }

    /**
     * Actualizar la información del libro en la base de datos
     * 
     * @param \Illuminate\Htpp\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $respuesta = new Respuesta();
        try {
            $Libro = Libros::find($request->id);            
            //Validamos que exista el libro
            if(isset($Libro)){
                $Libro->Titulo = $request->Titulo; 
                $Libro->Autor = $request->Autor;  
                $Libro->Categoria = $request->Categoria; 
                $Libro->Anio = $request->Year;
                $Libro->Editorial = $request->Editorial;
                $Libro->save();

                $respuesta->codigo = "200";
                $respuesta->mensaje = "El libro fue actualizado con éxito";
                $respuesta->data = $Libro;
            }else{
                $respuesta->codigo = "300";
                $respuesta->mensaje = "No se encontro el libro que se deseaba actualizar";
            }
        } catch (Exception $e) {
            $respuesta->codigo = "400";
            $respuesta->mensaje = "Error al actualizar el libro";
        }
        return $respuesta;
    }

    /**
     * Elimina un libro de la base de datos
     * 
     * @param \Illuminate\Http\Request $request 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        $respuesta = new Respuesta();
        try {
            //Validamos que existe un id de libro
            if(isset($request->id)){    
                $libro = Libros::destroy($request->id);

                //Verificamos que el libro a sido eliminado
                if(isset($libro)){
                    $respuesta->codigo = "200";
                    $respuesta->mensaje = "Libro eliminado con éxito";
                    $respuesta->data = $libro;
                }else{
                    $respuesta->codigo = "300";
                    $respuesta->mensaje = "No fue posible eliminar el libro";
                }
            }else{
                $respuesta->codigo = "100";
                $respuesta->mensaje = "Es necesario enviar Id de Libro";
            }
        } catch (Exception $e) {
            $respuesta->codigo = "400";
            $respuesta->mensaje = "Error al eliminar el Libro";
        }
        return $respuesta;
    }

    /**
     * Permite buscar un libro en especifico
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function show(Request $request){
        $respuesta = new Respuesta();
        //Seteamos valores por defecto
        $respuesta->codigo="300";
        $respuesta->mensaje="El libro buscado no se encuentra";
        $respuesta->data=null;
        try {            
            $libroBuscado = Libros::find($request->id);
            //Validamos que se encontro un libro que libroBuscado traiga datos 
            if(isset($libroBuscado)){
                $respuesta->codigo = "200";
                $respuesta->mensaje = "Petición procesada con éxito";
                $respuesta->data = $libroBuscado;
            }
        } catch (Exception $e) {
            $respuesta->codigo = "400";
            $respuesta->mensaje = "Error al obtener el libro";
        }
        return $respuesta;
    }

    /**
     * Busca el usuario dentro de la base de datos
     * - Login
     */
    public function prueba(Request $request){
        $respuesta=new Respuesta();
        try{
            $libroBuscado=DB::table('libros')->where('Titulo', $request->titulo)->first();
            //$libroBuscado=Libros::where('IdLibro', '>', 1)->firstOrFail();
            if(isset($libroBuscado)){
                $respuesta->codigo="200";
                $respuesta->mensaje="Peticion procesada con exito";
                $respuesta->data=$libroBuscado;
            }else{
                $respuesta->codigo="300";
                $respuesta->mensaje="El libro buscado no se encuentra";
                $respuesta->data=$libroBuscado;
            }
        }catch(Exception $e){
            $respuesta->codigo="400";
            $respuesta->mensaje="Error al obtener los libros";
        }
        return $respuesta;
    }

}