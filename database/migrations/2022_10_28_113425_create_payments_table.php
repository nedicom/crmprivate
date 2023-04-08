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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('summ');
            $table->string('client');
            $table->string('calculation');
            $table->string('service');
            $table->string('nameOfAttractioner');
            $table->string('excessAttraction');
            $table->string('decreaseAttraction');
            $table->string('nameOfSeller');
            $table->string('excessSeller');
            $table->string('decreaseSeller');
            $table->string('directionDevelopment');
            $table->string('recruiting');
            $table->string('companyAdmission');

            $table->string('modifySeller');
            $table->string('modifyAttraction');
            $table->string('DeveloperSalary');

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
        Schema::dropIfExists('payments');
    }
};
