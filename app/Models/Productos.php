<?php
    namespace App\Models;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Database\Eloquent\Model;
    class Productos extends Model{
        protected $primaryKey="IDProducto";
        protected $table="Productos";
        public $timestamps=false;
        protected $fillable=["Producto","Precio","Existencias","Imagen","Descripcion","IDCategoria","Estado"];

        /*select o.Fecha, (select sum(fp.cantidad) from facturaproductos fp where fp.idfactura=f.idfactura) 'Productos',
f.Total, o.EstadoEnvio from Ordenes o inner join facturas f on o.idorden=f.idorden where o.idusuario=3 and o.Cancelado=true;*/

        
    }

?>