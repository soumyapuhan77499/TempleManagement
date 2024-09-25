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
        Schema::create('temple__banner', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id');
            $table->string('banner_image');
            $table->string('banner_type'); // Web or App
            $table->text('banner_descp')->nullable();
            $table->string('status')->default('active'); // Active by default
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
        Schema::dropIfExists('temple_banner');
    }
};
