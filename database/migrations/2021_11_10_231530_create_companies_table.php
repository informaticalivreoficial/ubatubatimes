<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();            
            $table->string('api_token', 64)->unique()->nullable();
            $table->boolean('client')->default(false);
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('cat_companies')
                ->nullOnDelete();

            $table->foreignId('sub_category_id')
                ->nullable()
                ->constrained('cat_companies')
                ->nullOnDelete();
                
            $table->boolean('guia')->default(false);
            $table->text('content')->nullable();
            $table->string('url')->nullable();
            $table->string('slug')->nullable();
            $table->string('first_year')->nullable();
            $table->text('metatags')->nullable();
            $table->string('maps')->nullable();
            $table->string('caption_img_cover')->nullable();
            $table->boolean('highlight')->default(false);

            $table->string('magic_token', 64)->nullable()->unique();
            $table->timestamp('magic_token_expires_at')->nullable();
            $table->string('responsable_name');
            $table->string('responsable_email');
            $table->string('responsable_cpf')->nullable();
            $table->string('social_name')->nullable();
            $table->string('alias_name')->nullable();
            $table->string('document_company')->nullable();
            $table->string('document_company_secondary')->nullable();
            $table->text('information')->nullable();
            $table->boolean('status')->default(false);

            /** images */
            $table->string('logo')->nullable();
            $table->string('metaimg')->nullable();

            /** social */
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();

            /** address */
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            /** contact */
            $table->string('phone')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('additional_email')->nullable();
            $table->string('email')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
