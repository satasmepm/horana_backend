<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asign_homes', function (Blueprint $table) {
            $table->id();
            $table->string('ah_reserve_date')->nullable();
            $table->string('ah_agreement')->nullable();
            $table->string('ah_reserve_recipt')->nullable();
            $table->string('ah_remark')->nullable();
            $table->string('ah_type')->nullable();
            $table->double('ah_down_payment')->default('0');
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('asign_homes');
    }
}
