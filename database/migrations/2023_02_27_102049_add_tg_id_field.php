<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->unsignedBigInteger('tg_id')->nullable()->unique();
        });

        Schema::table('clients_models', static function (Blueprint $table) {
            if (Schema::hasColumn('clients_models', 'tgid')) {
                $table->unsignedBigInteger('tgid')->nullable()->unique()->change();
            } else {
                $table->unsignedBigInteger('tgid')->nullable()->unique();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->dropUnique(['tg_id']);
            $table->dropColumn('tg_id');
        });
        Schema::table('clients_models', static function (Blueprint $table) {
            $table->dropUnique(['tgid']);
            $table->dropColumn('tgid');
        });
    }
};
