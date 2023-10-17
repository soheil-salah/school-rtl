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
        Schema::create('educational_stages', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->string('name');
            $table->string('thumbnail')->nullable();
            $table->text('content')->nullable();
            $table->boolean('isPublished')->default(0);
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_stages');
    }
};
