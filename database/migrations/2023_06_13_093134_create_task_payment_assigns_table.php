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
        Schema::create('task_payment_assigns', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('payment_id');
        });

        Schema::table('task_payment_assigns', function (Blueprint $table) {
            $table->primary(['payment_id', 'task_id'], 'pk-task_payment_assigns');
            $table->index('payment_id');
            $table->index('task_id');
            $table->foreign('payment_id')->references('id')->on('payments')->cascadeOnDelete();
            $table->foreign('task_id')->references('id')->on('tasks')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_payment_assigns', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropForeign(['task_id']);
        });

        Schema::dropIfExists('task_payment_assigns');
    }
};
