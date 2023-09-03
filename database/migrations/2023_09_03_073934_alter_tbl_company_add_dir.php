<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('companies', function (Blueprint $table) {
            $table->string('direccion', 300)->nulllable();
            $table->string('codigo_postal', 25)->nullable();
            $table->string('telefono', 50)->nullable();
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->string('telefono', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
