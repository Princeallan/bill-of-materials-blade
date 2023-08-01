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
        Schema::create('bom_raw_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_id');
            $table->foreignId('raw_material_id');
            $table->unsignedInteger('quantity')->nullable();
            $table->float('unit_price')->nullable();
            $table->float('amount')->nullable();
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_raw_materials');
    }
};
