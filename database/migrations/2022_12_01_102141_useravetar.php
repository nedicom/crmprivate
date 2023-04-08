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
        /*Schema::table('users', function (Blueprint $table) {
            $input = ["rabbit.png", "bear.png", "cat.png"];
            $rand_key =rand(0, 2);
            $table->string('avatar')->default('/public/avatars/'.$input[$rand_key]);
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
