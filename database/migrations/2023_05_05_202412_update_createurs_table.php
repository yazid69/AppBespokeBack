<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('createurs', function (Blueprint $table) {
            // Changer la colonne "idCreateur" en auto-incrémentée
            $table->increments('idCreateur')->change();
        });
    }

    public function down()
    {
        Schema::table('createurs', function (Blueprint $table) {
            // Changer la colonne "idCreateur" en unsigned integer
            $table->unsignedInteger('idCreateur')->change();
        });
    }
};
