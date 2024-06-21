<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('document')->unique();
            $table->integer('balance');
            $table->string('type');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
}
