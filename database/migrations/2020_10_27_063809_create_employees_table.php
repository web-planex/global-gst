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
            $table->integer('id',1);
            $table->integer('user_id');
            $table->string('first_name',45);
            $table->string('last_name',45);
            $table->string('email',45);
            $table->string('display_name',45);
            $table->string('phone',15)->nullable();
            $table->string('mobile',15);
            $table->string('street',255);
            $table->string('city',45);
            $table->string('state',45);
            $table->string('pincode',10);
            $table->string('country',45);
            $table->integer('gender');
            $table->date('hire_date');
            $table->date('released')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->longText('notes')->nullable();
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
