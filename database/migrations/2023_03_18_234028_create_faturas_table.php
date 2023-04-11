<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faturas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('anuncio');
            $table->unsignedInteger('empresa');
            $table->string('transaction_id')->nullable();
            $table->timestamp('paid_date')->nullable();
            $table->date('vencimento')->nullable();
            $table->decimal('valor', 10, 2)->nullable(); 
            $table->string('status')->nullable();
            $table->text('url_slip')->nullable();
            $table->text('url_slip_pdf')->nullable();
            $table->text('digitable_line')->nullable();

            $table->timestamps();

            $table->foreign('anuncio')->references('id')->on('anuncios')->onDelete('CASCADE');
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
        Schema::dropIfExists('faturas');
    }
}
