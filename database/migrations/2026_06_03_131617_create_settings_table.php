<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Kushal.dev');
            $table->string('hero_title')->default('Kushal Ghimire');
            $table->string('hero_subtitle')->default('Frontend Developer · Backend Specialist · Vibe Coder');
            $table->string('email')->default('kushal.upr@gmail.com');
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('resume')->nullable();
            $table->string('profile_photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
