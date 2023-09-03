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
        Schema::create('cotizacion_details', function (Blueprint $table) {
            $table->id();
            $table->integer('cotizacion_id')->unsigned()->index();
            $table->integer('producto_id')->unsigned()->index();
            $table->decimal('cantidad', 12,2)->nullable()->default(0);
            $table->decimal('precio',12, 2)->nullable()->default(0);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizacion_details');
    }
};
