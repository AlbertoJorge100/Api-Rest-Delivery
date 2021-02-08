<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    class IDFactura extends Model {
        protected $primaryKey="IDFactura";
        protected $table = "IDFactura";
        public $timestamps=false;
        protected $fillable=["IDFactura","NumeroOrden"];
    }



?>