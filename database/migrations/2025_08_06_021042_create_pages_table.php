<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('menu_title')->nullable();
            $table->enum('page_type', ['standard', 'blog', 'piano_listing', 'contact', 'landing'])->default('standard');
            $table->longText('content')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->boolean('show_in_menu')->default(true);
            $table->integer('menu_order')->default(0);
            $table->timestamps();
            
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('cascade');
            $table->index(['is_published', 'page_type']);
            $table->index(['parent_id', 'menu_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};