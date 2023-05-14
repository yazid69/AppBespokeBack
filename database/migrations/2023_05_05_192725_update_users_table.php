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
        Schema::table('users', function (Blueprint $table) {
            // $table->string('genre', 10)->default('unknown')->change();
            $table->string('numRue')->default('')->change();
            // $table->string('rue', 255)->after('numRue');
            // $table->string('ville', 255)->after('rue');
            // $table->string('codePostal', 10)->after('ville');
            // $table->string('pays', 100)->after('codePostal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
