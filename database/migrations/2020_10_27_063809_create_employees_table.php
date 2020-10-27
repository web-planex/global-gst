<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('display_name');
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('country');
            $table->integer('gender');
            $table->date('hire_date');
            $table->date('released');
            $table->date('date_of_birth');
            $table->longText('notes');
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
        Schema::dropIfExists('employees');
    }
}
