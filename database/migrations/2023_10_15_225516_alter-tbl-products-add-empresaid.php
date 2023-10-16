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

        if (Schema::hasTable('productos')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->integer('company_id')->unsigned()->nullable()->after('deleted_by');
            });
        }

        if (Schema::hasTable('clientes')) {
           Schema::table('clientes', function (Blueprint $table) {
               $table->integer('company_id')->unsigned()->nullable()->after('deleted_by');
           });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('company_id')->unsigned()->nullable();
            });

        }
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
