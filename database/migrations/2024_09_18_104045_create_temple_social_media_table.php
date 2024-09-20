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
    public function up()
    {
        Schema::create('temple__social_media', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id')->unique();
            $table->json('temple_images')->nullable(); // Store image paths as JSON
            $table->json('temple_videos')->nullable(); // Store video paths as JSON
            $table->string('temple_yt_url')->nullable();
            $table->string('temple_ig_url')->nullable();
            $table->string('temple_fb_url')->nullable();
            $table->string('temple_x_url')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            
            // Add foreign key constraint if needed
            // $table->foreign('temple_id')->references('id')->on('temples')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temple_social_media');
    }
};
