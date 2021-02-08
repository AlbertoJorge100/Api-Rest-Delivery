<?php
    namespace App\Http\Controllers;
    use App\Models\Usuarios;
    use App\Models\Productos;
    use App\Models\Categorias;    
    use App\Models\Existencias;    
    use App\Models\FacturaProductos;
    use App\Data\Respuesta;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Response;
    

    class ProductosController extends Controller{
        /**
         * Select* from Productos;
         */
        public function SelectProductos(Request $request){
            $respuesta=new Respuesta();
            try{
                /*$productos=DB::table('Productos')->where('IDCategoria',$request->id)
                                ->where('Existencias','>=',1)
                                ->where('Estado','=',true)
                                ->get();*/

                $productos = DB::table('Productos')
                    ->leftjoin('Existencias','Productos.IDProducto','=','Existencias.IDProducto')
                    ->select('Productos.*', 'Existencias.Existencias')    
                    ->where('Productos.IDCategoria',$request->id)
                    ->where('Existencias.Existencias','>=',1)
                    ->where ('Productos.Estado','=',true)                                                        
                    ->get();
                
                if(isset($productos)){
                    $respuesta->codigo="200";
                    $respuesta->mensaje="Consulta realizada con exito";
                    $respuesta->data=$productos;
                }else{
                    $respuesta->codigo="300";
                    $respuesta->mensaje="los productos no se encuentran";
                    $respuesta->data=$productos;
                }              
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Error al obtener el producto".$e;
            }
            return $productos;
        }


        /**
         * Login
         * Select* from Usuarios where Usuario='asdf';
         */
        public function Login(Request $request){
            $respuesta=new Respuesta();
            
            try{
                $usuario=DB::table('Usuarios')
                ->where('Usuario',$request->usuario)
                ->where('Estado',"=",true)
                ->first();
                if(isset($usuario)){
                    $respuesta->Codigo="200";
                    $respuesta->mensaje="Peticion procesada con exito";
                    $respuesta->data=$usuario;
                }else{
                    $respuesta->codigo="300";
                    $respuesta->mensaje="El usuario no existe en la base de datos";
                    $respuesta->data=null;
                }
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Error al obtener el usuario".$e;
            }
            return $respuesta;
        }
               


        /**
         * Insert into Usuarios...
         * Este metodo queda suspendido temporalmente, porque 
         * utilizare un procedimiento almacenado...
         */
        public function InsertUsuarios(Request $request){
            $respuesta=new Respuesta();
            $encontrado=false;
            try{
                /**
                 * Si el request trae actualizacion de usuario, necesitamos saber que el usuario no
                 * exista para que podamos modificarlo,
                 */
                $_usuario=DB::table('Usuarios')
                ->select('Usuario')
                ->where('Usuario',$request->Usuario)->first();
                if(isset($_usuario)){
                    $encontrado=true;
                    $respuesta->codigo = "300";
                    $respuesta->mensaje = "El usuario ya esta en uso";
                    $respuesta->data = null;                        
                }                                    
                if(!$encontrado){
                    $usuario=Usuarios::create([
                        "Nombres"=>$request->Nombres,
                        "Correo"=>$request->Correo,
                        "Telefono"=>$request->Telefono,
                        "Usuario"=>$request->Usuario,
                        "Password"=>$request->Password
                    ]);
                    if(isset($usuario)){
                        $respuesta->codigo="200";
                        $respuesta->mensaje="Usuario creado con exito";
                        $respuesta->data=$usuario;
                    }else{
                        $respuesta->codigo="300";
                        $respuesta->mensaje="El usuario no fue ingresado";
                        $respuesta->data=null;
                    }
                }                
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->data=null;
            }
            return $respuesta;
        }


        /**
         * Update Usuarios...
         */
        public function UpdateUsuarios(Request $request){
            $respuesta=new Respuesta();
            $encontrado=false;
            try{
                if($request->Usuario!=""){
                    /**
                     * Si el request trae actualizacion de usuario, necesitamos saber que el usuario no
                     * exista para que podamos modificarlo,
                     */
                    $usuario=DB::table('Usuarios')
                    ->select('Usuario')
                    ->where('Usuario',$request->Usuario)->first();
                    if(isset($usuario)){
                        $encontrado=true;
                        $respuesta->codigo = "300";
                        $respuesta->mensaje = "El usuario ya esta en uso";
                        $respuesta->data = null;                        
                    }                    
                }                

                if(!$encontrado){
                    $usuario=Usuarios::find($request->IDUsuario);
                    if(isset($usuario)){
                        if($request->Nombres!=""){
                            $usuario->Nombres=$request->Nombres;
                        }if($request->Usuario!=""){
                            $usuario->Usuario=$request->Usuario;
                        }if($request->Password!=""){
                            $usuario->Password=$request->Password;
                        }if($request->Correo!=""){
                            $usuario->Correo=$request->Correo;
                        }if($request->Telefono!=""){
                            $usuario->Telefono=$request->Telefono;
                        }
                        $usuario->save();
                        $respuesta->codigo = "200";
                        $respuesta->mensaje = "El usuario fue actualizado con éxito ";
                        $respuesta->data = $usuario;                    
                    }else{
                        $respuesta->codigo = "300";
                        $respuesta->mensaje = "No pudo actualizar el usuario";
                        $respuesta->data=null;
                    }            
                }                
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->data=null;
            }
            return $respuesta;
        }


        /**
         * Select * from Categorias;
         */
        public function SelectCategorias(){
            $respuesta=new Respuesta();
            try{
                $categorias=DB::table('Categorias')
                                ->where('Estado','=',true)
                                ->get();                
                if(isset($categorias)){
                    $respuesta->codigo="200";
                    $respuesta->mensaje="Peticion procesada con exito";
                    $respuesta->data=$categorias;
                }else{
                    $respuesta->codigo="300";
                    $respuesta->mensaje="La categoria no existe en la base de datos";
                    $respuesta->data=$categorias;
                }
                //sleep(5);
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Error al obtener las categorias".$e;
            }
            return $categorias;
        }


        /**
         * Insert into Categorias...
         */
        public function InsertCategorias(Request $request){
            $respuesta=new Respuesta();
            try{
                $categoria=Categorias::create([
                    "Categoria"=>$request->Categoria,
                    "Imagen"=>$request->Imagen
                ]);
                if(isset($categoria)){
                    $respuesta->codigo="200";
                    $respuesta->mensaje="Categoria creada con exito";
                    $respuesta->data=$categoria;
                }else{
                    $respuesta->codigo="300";
                    $respuesta->data=$categoria;
                    $respuesta->data=null;
                }
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="La categoria no fue ingresado";
            }
            return $respuesta;
        }

        /**
         * Insert into productos...
         */
        public function InsertProductos(Request $request){
            $respuesta=new Respuesta();
            try{
                $producto=Productos::create([
                    "Producto"=>$request->Producto,
                    "Precio"=>$request->Precio,
                    "Existencias"=>$request->Existencias,
                    "Imagen"=>$request->Imagen,
                    "Descripcion"=>$request->Descripcion,
                    "IDCategoria"=>$request->IDCategoria
                ]);
                if(isset($producto)){
                    $respuesta->codigo="200";
                    $respuesta->mensaje="Producto creado con exito";
                    $respuesta->data=$producto;
                }else{
                    $respuesta->codigo="300";
                    $respuesta->mensaje="El producto no fue ingresado";
                    $respuesta->data=null;
                }
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->data=$producto;
            }
            return $respuesta;
        }

        /**
         * Insert into FactP...
         */
        public function InsertFacturaProductos(Request $request){
            $respuesta=new Respuesta();            
            try{
                
                //$insert=FacturaProductos::insert($request);
                /*DB::table('FacturaProductos')->insert([
                    ['email' => 'picard@example.com', 'votes' => 0],
                    ['email' => 'janeway@example.com', 'votes' => 0],
                ]);*/

                $contador=0;
                $data=$request->ListaProductos;
                $idfactura=$data[0]['IDFactura'];
                if(count($data)>0){
                    foreach($data as $item){
                        $insert=DB::table('FacturaProductos')->insert([                            
                            "IDProducto"=>$item['IDProducto'],
                            "IDFactura"=>$item['IDFactura'],
                            "Cantidad"=>$item['Cantidad'],
                            "Descuento"=>$item['Descuento'],
                            "SubTotal"=>$item['SubTotal']
                        ]); 
                        if(isset($insert)){
                            $contador++;
                        }
                    }
                }

                
                if($contador==count($data)){
                    $id=DB::select('call CerrarFactura (?,?)',array($idfactura,$request->Direccion));
                    if(isset($id)){
                        $respuesta->codigo="200";
                        $respuesta->mensaje="Peticion procesada con exito";
                        $respuesta->data=true;
                    }else{
                        $respuesta->codigo="300";
                        $respuesta->mensaje="No se pudo cerrar la compra";
                        $respuesta->data=false;
                    }
                }else{
                    $respuesta->codigo="300";
                    $respuesta->mensaje="No se pudo enviar la lista de productos";
                    $respuesta->data=false;
                }
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Error al obtener las categorias".$e;
            }
            //return redirect()->back()->with('status','Data Berhasil Di Input ');
            //return $respuesta;
            return $respuesta;
        }

        public function getIdFactura(Request $request){
            $respuesta=new Respuesta();
            try{
                $id=DB::select('call GestionFactura (?)',array($request->IDUsuario));
                if(isset($id)){
                    $respuesta->codigo="200";
                    $respuesta->mensaje="Peticion procesada con exito";
                    $respuesta->data=$id;
                }
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Error al obtener las categorias".$e;
            }
            return $id;
        }

    }

?>