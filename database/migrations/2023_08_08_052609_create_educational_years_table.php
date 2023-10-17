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
        Schema::create('educational_years', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->unsignedBigInteger('educational_stage_id');
            $table->string('name');
            $table->boolean('isPublished')->default(1);
            $table->string('order')->nullable();
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('educational_stage_id')
            ->references('id')
            ->on('educational_stages')
            ->cascadeOnUpdate()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_years');
    }
};
