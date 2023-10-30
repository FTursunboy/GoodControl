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
        Schema::create('store_goods', function (Blueprint $table) {
            $table->id();
            $table->string('IMEI')->unique();
            $table->unsignedBigInteger('store_id');
            $table->integer('amount');
            $table->unsignedBigInteger('type_id');
            $table->softDeletes();
            $table->foreign('store_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_goods');
    }
};
