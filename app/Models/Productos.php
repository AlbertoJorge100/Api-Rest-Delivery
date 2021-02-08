<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    class Productos extends Model{
        protected $primaryKey="IDProducto";
        protected $table="Productos";
        public $timestamps=false;
        protected $fillable=["Producto","Precio","Existencias","Imagen","Descripcion","IDCategoria","Estado"];
    }

?>