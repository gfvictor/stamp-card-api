<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    public function up(): void
    {
        Schema::create('store_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stores_id')->constrained('stores');
//            $table->integer('max_points');
            $table->unsignedInteger('discount_amount');
            $table->enum('discount_type', ['percentage', 'cash'])->nullable();
            $table->integer('expiration_in_months')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_rules');
    }
};
