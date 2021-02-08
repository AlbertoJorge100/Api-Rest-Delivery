
<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;
    class Existencias extends Model{
        protected $primarykey="IDExistencia";
        protected $table="Existencias";
        public $timestamps=false;
        protected $fillable=["IDProducto","Existencias"];
    }
?>