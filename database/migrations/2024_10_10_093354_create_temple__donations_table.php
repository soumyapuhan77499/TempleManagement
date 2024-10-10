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
        Schema::create('temple__donations', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id'); // assuming temple_id is a foreign key
            $table->string('donation_type');
            $table->string('item_name');
            $table->string('photo')->nullable();
            $table->text('item_desc');
            $table->integer('quantity');
            $table->enum('status', ['active', 'deleted'])->default('active');
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
        Schema::dropIfExists('temple__donations');
    }
};
