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
            $table->integer('id',1);
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('first_name',45);
            $table->string('last_name',45);
            $table->string('email',45);
            $table->string('company',45)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('mobile',15);
            $table->string('display_name',45);
            $table->string('website',45)->nullable();
            $table->string('gstin',25)->nullable();
            $table->integer('gst_registration_type_id');
            $table->string('billing_name',45);
            $table->string('billing_phone',15);
            $table->string('billing_street',255);
            $table->string('billing_city',45);
            $table->string('billing_state',45);
            $table->string('billing_pincode',45);
            $table->string('billing_country',45);
            $table->string('shipping_name',45);
            $table->string('shipping_phone',15);
            $table->string('shipping_street',255);
            $table->string('shipping_city',45);
            $table->string('shipping_state',45);
            $table->string('shipping_pincode',45);
            $table->string('shipping_country',45);
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
