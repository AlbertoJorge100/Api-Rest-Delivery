<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaProductos extends Model {

    protected $primaryKey = "IDFacturaProducto";
    protected $table = "FacturaProductos";
    public $timestamps = false;

    protected $fillable = ["IDProducto", "IDFactura", "Cantidad", "Descuento", "SubTotal"];

    

}