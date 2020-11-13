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
            $table->integer('id',1);
            $table->integer('user_id');
            $table->string('first_name',25);
            $table->string('last_name',25);
            $table->string('email',50);
            $table->string('company',50)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('mobile',15);
            $table->string('display_name',45);
            $table->string('website',45)->nullable();
            $table->string('street',255);
            $table->string('city',45);
            $table->string('state',45);
            $table->string('pincode',10);
            $table->string('country',45);
            $table->integer('billing_rate')->nullable();
            $table->string('pan_no',15)->nullable();
            $table->string('account_no',25)->nullable();
            $table->integer('apply_tds_for_supplier')->nullable();
            $table->string('gstin',25)->nullable();
            $table->integer('gst_registration_type_id')->nullable();
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
