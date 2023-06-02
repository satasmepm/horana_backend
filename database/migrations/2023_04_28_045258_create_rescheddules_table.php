<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRescheddulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rescheddules', function (Blueprint $table) {
            $table->id();
            $table->string('rs_date')->nullable();
            $table->string('rs_installment_number')->nullable();
            $table->double('rs_installment_amount')->default('0');
            $table->double('rs_current_amount')->default('0');
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
        Schema::dropIfExists('rescheddules');
    }
}
