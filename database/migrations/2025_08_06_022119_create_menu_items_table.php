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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->enum('menu_location', ['header', 'footer', 'sidebar'])->index();
            $table->enum('type', ['page', 'external', 'custom'])->default('page');
            $table->foreignId('page_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('url')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('target', 10)->nullable()->default('_self');
            $table->string('css_class')->nullable();
            $table->timestamps();

            $table->index(['menu_location', 'is_active']);
            $table->index(['parent_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};