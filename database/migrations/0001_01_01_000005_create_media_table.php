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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191)->nullable();
            $table->string('alt_text', 191)->nullable();
            $table->string('caption', 191)->nullable();
            $table->text('description')->nullable();
            $table->string('file_name', 191);
            $table->string('original_name', 191);
            $table->string('file_path', 255);
            $table->string('disk', 50)->default('public');
            $table->string('mime_type', 100);
            $table->string('extension', 20);
            $table->unsignedBigInteger('file_size');
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('folder', 100)->default('custom');
            $table->boolean('is_image')->default(false);
            $table->boolean('status')->default(true);
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
