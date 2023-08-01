<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('boms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->string('project')->nullable();
            $table->string('uom')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_default')->default(1);
            $table->boolean('allow_alternative')->default(1);
            $table->boolean('rate_set')->default(0);
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('items_count')->default(0);
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boms');
    }
};
