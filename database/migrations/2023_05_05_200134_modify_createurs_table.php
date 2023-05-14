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
        Schema::table('createurs', function (Blueprint $table) {
            $table->unsignedInteger('idCreateur')->autoIncrement()->primary();
            $table->string('mdpCreateur', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('createurs', function (Blueprint $table) {
            $table->unsignedInteger('idCreateur')->primary();
            $table->string('mdpCreateur', 30)->change();
        });
    }
};
