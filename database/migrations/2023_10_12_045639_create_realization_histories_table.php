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
        Schema::create('realization_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IMEI');
            $table->boolean('sent')->default(false);
            $table->unsignedBigInteger('sender')->nullable();
            $table->unsignedBigInteger('recipient')->nullable();
            $table->enum('type', ['purchase', 'return', 'sale']);
            $table->unsignedBigInteger('status_id');
            $table->decimal('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realization_histories');
    }
};
