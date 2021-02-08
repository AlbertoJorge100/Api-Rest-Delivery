<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Libros extends Model {

        protected $primaryKey = "IdLibro";
        protected $table = "libros";
        public $timestamps = false;

        protected $fillable = ["Titulo", "Autor", "Categoria", "Anio", "Editorial"];

    }
?>