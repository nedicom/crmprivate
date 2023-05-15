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
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->string('hrftodcm', 1000)->nullable()->change();
            $table->unsignedBigInteger('lead_id')->nullable();

            $table->foreign('lead_id')->references('id')->on('leads')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['lead_id']);

            $table->string('description', 2000)->change();
            $table->string('hrftodcm', 1000)->change();
            $table->dropColumn('lead_id');
        });
    }
};
