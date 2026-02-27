<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resource_links', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Cohort 3 Pitch Decks"
            $table->string('url'); // The Google Drive / Doc link
            $table->string('category')->default('Google Drive Folder'); // Folder, Template, Document
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resource_links');
    }
};