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
        Schema::create('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('idArticle')->autoIncrement()->primary();
            $table->string('nomArticle', 100);
            $table->text('description')->nullable(false);
            $table->string('photoArticle')->nullable();
            $table->decimal('prixArticle', 8, 2, true);
            $table->integer('reference', 30);
            $table->string('taille', 30);
            $table->string('couleur', 30);
            $table->string('categorie', 30);
            $table->unsignedBigInteger('idCreateur')->nullable(false);
            $table->foreign('idCreateur')->references('id')->on('createurs')->onDelete('cascade');
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
        Schema::dropIfExists('articles');
    }
};
