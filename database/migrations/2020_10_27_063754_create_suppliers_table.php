<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('company');
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('display_name');
            $table->string('website')->nullable();
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('country');
            $table->integer('billing_rate');
            $table->string('pan_no');
            $table->string('account_no');
            $table->integer('apply_tds_for_supplier');
            $table->string('gstin');
            $table->integer('gst_registration_type_id');
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
        Schema::dropIfExists('suppliers');
    }
}
