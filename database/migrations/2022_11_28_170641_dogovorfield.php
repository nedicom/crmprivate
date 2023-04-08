<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('dogovors', function (Blueprint $table) {
            $table->string('allstoimost')->default('');
            $table->string('preduslugi')->default('');
            $table->string('predoplata')->default('');
        });
    }

    public function down()
    {
        //
    }
};
