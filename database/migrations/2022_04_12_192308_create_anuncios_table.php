<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnunciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anuncios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empresa');
            $table->unsignedInteger('categoria');
            $table->unsignedBigInteger('plan_id'); // Plano ID

            /** imagens */
            $table->string('300x250')->nullable();
            $table->string('728x90')->nullable();
            $table->string('468x90')->nullable();
            $table->string('336x280')->nullable();

            $table->string('titulo');
            $table->string('slug')->nullable();
            $table->integer('posicao')->default('0');
            $table->integer('status')->default('0');

            /** subscription */
            $table->string('subscription_id')->nullable(); // gatway id
            $table->date('subscription')->nullable(); // Data de inicio 
            $table->date('expires_at')->nullable(); // Data de Expiração            
            $table->boolean('subscription_active')->default(false); // Assinatura Ativa 
            $table->boolean('subscription_suspended')->default(false); // Assinatura Cancelada 

            $table->timestamps();

            $table->foreign('empresa')->references('id')->on('empresas')->onDelete('CASCADE');
            $table->foreign('categoria')->references('id')->on('cat_post')->onDelete('CASCADE');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anuncios');
    }
}
