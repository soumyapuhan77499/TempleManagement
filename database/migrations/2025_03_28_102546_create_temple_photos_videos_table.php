<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('temple__photos_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('temple_id')->nullable();
            $table->json('temple_images')->nullable();
            $table->json('temple_videos')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temple__photos_videos');
    }
};
