<?php

    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Usuarios extends Model{
        protected $primaryKey="IDUsuario";
        protected $table="Usuarios";
        public $timestamps=false;

        protected $fillable=["Nombres","Correo","Telefono","Usuario","Password","Estado"];
    }


?>