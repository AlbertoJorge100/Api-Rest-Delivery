<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    class Categorias extends Model{
        protected $primarykey="IDCategoria";
        protected $table="Categorias";
        public $timestamps=false;
        protected $fillable=["Categoria","Imagen","Estado"];
    }
?>