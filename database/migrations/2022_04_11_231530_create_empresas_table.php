<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('categoria');
            $table->integer('cat_pai')->nullable();
            $table->string('responsavel');
            $table->string('responsavel_email');
            $table->string('responsavel_cpf')->nullable();
            $table->string('social_name')->nullable();
            $table->string('alias_name');
            $table->string('slug')->nullable();
            $table->string('document_company')->nullable();
            $table->string('document_company_secondary')->nullable();
            $table->integer('status')->default('0');
            $table->boolean('cliente')->nullable(); 
            $table->integer('exibirnoguia')->default('0');
            $table->integer('email_send_count')->default('0');
            $table->bigInteger('views')->default(0);
            $table->string('logomarca')->nullable();
            $table->integer('ano_de_inicio')->nullable();
            $table->text('content')->nullable();
            $table->text('notasadicionais')->nullable();

            $table->string('dominio')->nullable();
            $table->string('metaimg')->nullable();
            $table->text('mapa_google')->nullable();
            $table->text('metatags')->nullable();

            /** address */
            $table->string('cep')->nullable();
            $table->string('rua')->nullable();
            $table->string('num')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('uf')->nullable();
            $table->string('cidade')->nullable();
            
            /** contact */
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('skype')->nullable();

            /** Redes Sociais */
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('vimeo')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('fliccr')->nullable();

            $table->timestamps();

            $table->foreign('categoria')->references('id')->on('cat_empresas')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
