<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->string('name');
            $table->integer('draw_id')->unsigned();
            $table->foreign('draw_id')->references('id')->on('draws');
            $table->string('number');
            $table->integer('number_draw')->nullable();
            $table->string('image');
            $table->uuid('contact_id');
            $table->uuid('service_id');
            $table->boolean('winner')->default(false);
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
        Schema::dropIfExists('customers');
    }
}
