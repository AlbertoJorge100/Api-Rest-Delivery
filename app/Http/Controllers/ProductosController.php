<?php
    namespace App\Http\Controllers;
    use App\Models\Usuarios;
    use App\Models\Productos;
    use App\Models\Categorias;    
    use App\Models\Existencias;    
    use App\Models\FacturaProductos;
    use App\Data\Respuesta;
    use App\Data\RespuestaUsuarios;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Http\Response;
use mysqli;

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

                /*$productos = DB::table('Productos')
                    ->join('Existencias','Productos.IDProducto','=','Existencias.IDProducto')
                    ->select('Productos.*', 'Existencias.Existencias')    
                    ->where('Productos.IDCategoria',$request->id)
                    ->where('Existencias.Existencias','>=',1)
                    ->where ('Productos.Estado','=',true)                                                        
                    ->get();

                if(isset($productos)){*/
                $productos=DB::select('call GetProductos (?)',array($request->id));
                if(count($productos)>=1){
                    $respuesta->codigo="200";
                    $respuesta->mensaje="Consulta realizada con exito";
                    $respuesta->data=$productos;
                }else{
                    $respuesta->codigo="300";
                    $respuesta->mensaje="No hay productos en esta categoria";
                    $respuesta->data=null;
                }              
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Error al obtener el producto".$e;
                $respuesta->data=null;
            }
            return $productos;
        }

        /**
         * Select * from facturas 
         */
        public function SelectFacturas(Request $request){
            $respuesta=new Respuesta();
            try{
                /*$productos=DB::table('Productos')->where('IDCategoria',$request->id)
                                ->where('Existencias','>=',1)
                                ->where('Estado','=',true)
                                ->get();*/

                $productos = DB::table('Productos')
                    ->join('Existencias','Productos.IDProducto','=','Existencias.IDProducto')
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
         * Uso de procedimientos almacenados, para optimizar, la gestion de datos...
         */
        public function Login(Request $request){
            $respuesta=new RespuestaUsuarios();                        
            try{
                /*$usuario=DB::table('Usuarios')
                ->where('Usuario',$request->usuario)
                ->where('Estado',"=",true)
                ->first();*/
                $datos_usuario=DB::select('call IniciarSesion (?)',array($request->usuario));
                if(count($datos_usuario)==1){
                //if(isset($usuario)){                
                    $datos_categorias=DB::select('call GetCategorias()');        
                    if(isset($datos_categorias)){
                        $respuesta->codigo="200";
                        $respuesta->mensaje="Peticion procesada con exito";
                        /*El procedimiento nos devuelve una lista, por eso especificamos
                          solamente la posicion 0...
                        */
                        $respuesta->usuario=$datos_usuario[0];
                        $respuesta->categorias=$datos_categorias;
                    }                    
                }else{
                    $respuesta->codigo="300";
                    $respuesta->mensaje="El usuario no existe en la base de datos !";
                    $respuesta->usuario=null;
                    $respuesta->categorias=null;
                }
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Excepcion: ".$e;
                $respuesta->usuario=null;
            }
            return $respuesta;
        }
               


        /**
         * Insert into Usuarios...
         * 
         */
        public function InsertUsuarios(Request $request){
            $respuesta=new RespuestaUsuarios();
            $respuesta->codigo = "300";
            $respuesta->usuario = null;
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
                    $respuesta->mensaje = "El usuario elegido ya esta en uso !";
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
                        $respuesta->mensaje="Usuario creado con exito !";
                        $respuesta->usuario=$usuario;
                    }else{
                        $respuesta->mensaje="El usuario no pudo ser ingresado";                        
                    }
                }                
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Excepcion: ".$e;                
            }
            return $respuesta;
        }


        /**
         * Update Usuarios...
         */
        public function UpdateUsuarios(Request $request){
            $respuesta=new RespuestaUsuarios();
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
                        $respuesta->mensaje = "El usuario elegido ya esta en uso !";
                        $respuesta->usuario = null;                        
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
                        $respuesta->usuario = $usuario;                    
                    }else{
                        $respuesta->codigo = "300";
                        $respuesta->mensaje = "No se pudo actualizar el usuario";
                        $respuesta->usuario=null;
                    }            
                }                
            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Excepcion: ".$e;
                $respuesta->usuario=null;
            }
            return $respuesta;
        }


        /**
         * Select * from Categorias;
         * Suspendido, ya que al iniciar la sesion se manda a traer de una sola vez
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
         * Este metodo queda suspendido temporalmente, porque 
         * utilizare un procedimiento almacenado...
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
         * Pagar e ingresar los productos a la factura
         * Insert into FactP...
         */
        public function InsertFacturaProductos(Request $request){
            $respuesta=new Respuesta();            
            try{
                $codigo="200";
                $mensaje="";
                //lista
                $data=$request->ListaProductos;                
                //Contador para, el conteo de las inserciones
                $contador=0;                
                $contador_existencias=0;
                $idfactura=$data[0]['IDFactura'];                
                $resultado_operaciones=false;
                //Define la validez del pago
                $resultado_pago=true;

                /**
                 * Validar si las existencias seleccionadas son menores, a las que estan en stock
                 * para que el usuario seleccione una cantidad valida.
                 * Si la cantidad es mayor a la del stock; retornara una lista de los productos los 
                 * cuales deberan ser modificados, en la aplicacion
                 * 
                 */
                $pila = array();                
                foreach($data as $item){
                    $resp=DB::select('call ValidarExistencias (?,?)',array($item['IDProducto'], $item['Cantidad']));    
                    if(!$resp[0]->resultado){//$resp[0]['resultado']){                        
                        array_push($pila, array("id"=>$item['IDProducto'],//Llenando el array, a retornar
                        "existencias"=>$resp[0]->existencias));
                        $contador_existencias++;                        
                        //"id"-> $item['IDProducto'], json_decode($resp[0]->existencias, true));
                    }
                }

                if(count($data)>0 && $contador_existencias==0){
                    //No existen cantidades de productos erroneas.

                    //Pagar 
                    //Pago aceptado xdddd
                    //$resultado_pago=false;


                    if($resultado_pago){
                        //El pago fue aceptado                        
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
                        if($contador==count($data)){
                            //Paso todos los filtros, procedemos a cerrar la factura
                            $id=DB::select('call CerrarFactura (?,?)',array($idfactura,$request->Direccion));
                            if(isset($id)){                        
                                $codigo="200";
                                $mensaje="Tu orden se proceso exitosamente, puedes ver el detalle de esta en Historial de compras";                                
                            }
                        }
                    }else{
                        $codigo="500";
                        $mensaje="El pago no fue aceptado, verifica tus datos !";
                    }                    
                }else if($contador_existencias>0){
                    $codigo="300";
                    $mensaje="Algunos productos, que has seleccionado, han disminuido sus existencias:";
                }
                
                $respuesta->codigo=$codigo;
                $respuesta->mensaje=$mensaje;
                $respuesta->data=[];

                //if($codigo.equals("300"))
                if(strcmp($codigo,"300")==0){                    
                    $respuesta->data=$pila;
                }

            }catch(Exception $e){
                $respuesta->codigo="400";
                $respuesta->mensaje="Error al obtener las categorias".$e;
                $respuesta->data=[];
            }                        
            return $respuesta;
        }

        /**
         * Procedimiento almacenado
         */
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

        /*
         * Acceder a las ordenes que ha realizado el usuario 
         * 
         * select o.Fecha, (select sum(fp.cantidad) from facturaproductos fp where fp.idfactura=f.idfactura) 'Productos',
            f.Total, o.EstadoEnvio from Ordenes o inner join facturas f on o.idorden=f.idorden where o.idusuario=3 and o.Cancelado=true;
         */
        public function getFacturas(Request $request){
            $respuesta=new Respuesta();
            try{
                $facturas= DB::table('Ordenes as o')
                    ->join('Facturas as f','o.IDOrden','=','f.IDOrden')
                    ->select('f.IDFactura',
                        DB::raw("(SELECT sum(fp.Cantidad) FROM FacturaProductos as fp
                         WHERE fp.IDFactura=f.IDFactura) as Productos")
                        ,'o.Fecha','o.Direccion','o.NumeroOrden', 'f.Total', 'o.EstadoEnvio')    
                    ->where('o.IDUsuario',$request->id)
                    ->where('o.Cancelado',true)                    
                    ->get();
                if(isset($facturas)){
                    return $facturas;
                }else{
                    return null;
                }
            }catch(Exception $e){
                return null;
            }            
        }

        /*-- Obtenemos la lista de productos por factura 
            select p.imagen, p.producto, p.precio, fp.cantidad, fp.subtotal  
            from facturaproductos fp inner join productos p on fp.idproducto=p.idproducto where fp.idfactura=89;
         * 
         */
        public function getFacturaProductos(Request $request){
            $respuesta=new Respuesta();
            try{
                $facturas= DB::table('FacturaProductos as fp')
                    ->join('Productos as p','fp.IDProducto','=','p.IDProducto')
                    ->select(['p.Imagen','p.Producto','p.Precio','fp.Cantidad','fp.SubTotal'])    
                    ->where('fp.IDFactura',$request->id)
                    ->get();
                if(isset($facturas)){
                    return $facturas;
                }else{
                    return null;
                }
            }catch(Exception $e){
                return null;
            }            
        }

        public function getExstCategoria(Request $request){
            try{
                $existencias=DB::select('call ValidarExstCategoria (?)',array($request->idcategoria));
                if(isset($existencias)){
                    return $existencias;
                }else{
                    return null;
                }
            }catch(Exception $e){
                return null;
            }
        }

        //Mantenimiento, pruebas en servidor
        public function getUsuarios(){            
            try{
                $usuarios=DB::table('Usuarios as u')
                            ->orderBy('u.IDUsuario','desc')
                            ->get();
                if(isset($usuarios)){
                    return $usuarios;
                }else{
                    return null;
                }
            }catch(Exception $e){
                return null;
            }            
        }
        public function getCompras(){            
            try{
                //$compras=DB::select('call GetCompras ()');
                $compras=DB::table('Ordenes as o')
                            ->orderBy('o.NumeroOrden','desc')
                            ->get();
                if(isset($compras)){
                    return $compras;
                }else{
                    return null;
                }
            }catch(Exception $e){
                return null;
            }            
        }                

    }

?>