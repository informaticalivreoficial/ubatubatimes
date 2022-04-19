<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('stripe_id')->unique();
            $table->text('content')->nullable();
            $table->string('slug')->nullable();
            $table->integer('status')->nullable();
            $table->integer('avaliacao')->nullable();

            /** pricing and values */
            $table->boolean('exibivalores')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->decimal('valor_mensal', 10, 2)->nullable();            
            $table->decimal('valor_trimestral', 10, 2)->nullable();            
            $table->decimal('valor_semestral', 10, 2)->nullable();            
            $table->decimal('valor_anual', 10, 2)->nullable();            
            $table->decimal('valor_bianual', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
