<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dogovors', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->default('1');
            $table->string('name');
            $table->string('lawyer_id');
            $table->datetime('date');
            $table->string('subject');
            $table->timestamps();
          });
    }

    public function down()
    {
        Schema::dropIfExists('dogovor');
    }
};
