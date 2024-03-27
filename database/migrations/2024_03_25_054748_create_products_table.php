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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->decimal('price', 15, 4)->default(0);
            $table->text('content');
            $table->string('image_path', 50)->nullable();
            $table->tinyInteger('featured_flg')->default(0);
            $table->integer('viewed')->default(0)->nullable();
            $table->integer('ordered')->default(0)->nullable();

            $table->tinyInteger('del_flg')->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
