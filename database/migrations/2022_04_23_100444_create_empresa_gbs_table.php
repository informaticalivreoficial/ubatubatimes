<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaGbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_gbs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empresa');
            $table->string('path');
            $table->boolean('cover')->nullable();

            $table->timestamps();

            $table->foreign('empresa')->references('id')->on('empresas')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa_gbs');
    }
}
