<?php
    namespace App\Data;
    use Illuminate\Database\Eloquent\Model;
    
    class RespuestaUsuarios  extends Model{
        public $Codigo;
        public $Mensaje;
        public $Cliente;
        public $Categorias;
    }    

?>