<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('cus_name')->nullable();
            $table->string('cus_nic')->nullable();
            $table->string('cus_address')->nullable();
            $table->string('cus_phone')->nullable();
            $table->string('cus_email')->nullable();
            $table->string('cus_password')->nullable();
            $table->string('cus_image')->nullable();
            $table->string('cus_auth_token')->nullable();
            $table->string('cus_token')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('customer_roles');
            $table->tinyInteger('status')->default('0');


            // $table->foreignId('group_id')->nullable()->constrained('groups');
            // $table->foreignId('role_id')->nullable()->constrained('roles');
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
