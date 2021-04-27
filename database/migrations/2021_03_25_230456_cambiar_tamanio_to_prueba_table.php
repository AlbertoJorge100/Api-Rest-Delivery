<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CambiarTamanioToPruebaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prueba', function (Blueprint $table) {
            //
            $table->string('avatar', 150)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prueba', function (Blueprint $table) {
            //->nullable(false): not null
            $table->string('avatar', 255)->nullable(false)->change();
        });
    }
}
