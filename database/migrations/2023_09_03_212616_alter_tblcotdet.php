<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Estado;

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

        Schema::table('cotizacion_details', function (Blueprint $table) {
            $table->decimal('importe', 12,2)->nullable()->default(0);
        });

        Schema::create('estados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Estado::create([
            'nombre' => 'Creado',
            'color' => 'warning',
        ]);

        Estado::create([
            'nombre' => 'Terminado',
            'color' => 'success',
        ]);
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
