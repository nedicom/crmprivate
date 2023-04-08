<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @ret urn void
     */
    public function up()
    {
        Schema::table('clients_models', function (Blueprint $table) {
            $value = 0;
            $table->integer('tgid')->default($value)->unique();

            /*while (!count($test)) {
                $value = rand(0, 1000000);
                $table->integer('tgid')->default($value)->unique();
                $test = DB::table('clients_models')->where('tgid', $value) -> get();
            }  */
        });
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
