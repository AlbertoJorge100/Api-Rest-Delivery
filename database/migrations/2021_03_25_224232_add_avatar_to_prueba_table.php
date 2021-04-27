<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarToPruebaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Aqui agrega una columna
        Schema::table('prueba', function (Blueprint $table) {
            //agregar columna avatar
            $table->string('avatar')->nullable()->after('descripcion');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Aqui elimina la columna...
        Schema::table('prueba', function (Blueprint $table) {
            //Eliinar la columna avatar
            $table->dropColumn('avatar');
        });
    }
}
