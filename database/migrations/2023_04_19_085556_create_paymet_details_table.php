<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymet_details', function (Blueprint $table) {
            $table->id();
            $table->integer('pd_inst_number')->default('0');
            $table->string('pd_collection_date')->nullable();
            $table->string('pd_amount')->nullable();
            $table->string('pd_recipt')->nullable();
            $table->tinyInteger('status')->default('0');
            $table->foreignId('ah_id')->nullable()->constrained('asign_homes');
            $table->foreignId('tower_id')->nullable()->constrained('towers');
            $table->foreignId('floor_id')->nullable()->constrained('floors');
            $table->foreignId('home_id')->nullable()->constrained('homes');
            $table->foreignId('cus_id')->nullable()->constrained('customers');
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
        Schema::dropIfExists('paymet_details');
    }
}
