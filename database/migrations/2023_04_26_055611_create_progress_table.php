<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->string('pr_date')->nullable();
            $table->string('pr_image')->nullable();
            $table->string('pr_remark')->nullable();
            $table->tinyInteger('status')->default('0');
            $table->foreignId('tower_id')->nullable()->constrained('towers');
            $table->foreignId('floor_id')->nullable()->constrained('floors');
            $table->foreignId('home_id')->nullable()->constrained('homes');
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
        Schema::dropIfExists('progress');
    }
}
