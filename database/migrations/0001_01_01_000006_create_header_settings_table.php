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
        Schema::create('header_settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_style')->default('default');
            $table->boolean('sticky_header')->default(false);
            $table->boolean('transparent_header')->default(false);
            $table->boolean('topbar_enabled')->default(false);
            $table->boolean('navbar_enabled')->default(true);
            $table->boolean('search_enabled')->default(false);
            $table->boolean('cta_button_enabled')->default(false);
            $table->string('cta_button_text')->nullable();
            $table->string('cta_button_url')->nullable();
            $table->string('cta_button_target')->default('_self');
            $table->boolean('mobile_menu_enabled')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('header_topbars', function (Blueprint $table) {
            $table->id();
            $table->string('left_text')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('opening_hours')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('twitter')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('header_logos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desktop_logo')->nullable();
            $table->unsignedBigInteger('mobile_logo')->nullable();
            $table->unsignedBigInteger('sticky_logo')->nullable();
            $table->unsignedBigInteger('dark_logo')->nullable();
            $table->unsignedBigInteger('light_logo')->nullable();
            $table->unsignedBigInteger('favicon')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('desktop_logo')->references('id')->on('media')->nullOnDelete();
            $table->foreign('mobile_logo')->references('id')->on('media')->nullOnDelete();
            $table->foreign('sticky_logo')->references('id')->on('media')->nullOnDelete();
            $table->foreign('dark_logo')->references('id')->on('media')->nullOnDelete();
            $table->foreign('light_logo')->references('id')->on('media')->nullOnDelete();
            $table->foreign('favicon')->references('id')->on('media')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_logos');
        Schema::dropIfExists('header_topbars');
        Schema::dropIfExists('header_settings');
    }
};
