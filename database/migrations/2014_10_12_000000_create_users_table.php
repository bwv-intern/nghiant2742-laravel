<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('name', 50);
            $table->tinyInteger('user_flg')->default(1);
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();

            $table->tinyInteger('del_flg')->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->date('created_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->date('updated_at')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->date('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
