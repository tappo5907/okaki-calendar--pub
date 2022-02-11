<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_supplies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('care_id');
            $table->integer('amount');
            $table->timestamps();
            
            $table->foreign('care_id')->references('id')->on('cares');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_supplies');
    }
}
