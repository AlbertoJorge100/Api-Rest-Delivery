<?php

    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Clientes extends Model{
        protected $primaryKey="IDCliente";
        protected $table="Clientes";
        public $timestamps=false;

        protected $fillable=["Nombres","Correo","Telefono","Usuario","Password","Activo"];
    }


?>