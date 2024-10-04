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
        Schema::create('temple__inventory_category', function (Blueprint $table) {
            $table->id();
            $table->string('temple_id');
            $table->string('inventory_categoy');
            $table->enum('status', ['active', 'deactive'])->default('active');
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
        Schema::dropIfExists('temple_inventory_category');
    }
};
