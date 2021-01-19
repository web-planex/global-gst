<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->integer('id',1);
            $table->integer('user_id');
            $table->string('company_name',50)->nullable();
            $table->text('company_logo')->nullable();
            $table->text('signature_image')->nullable();
            $table->string('pan_no',45)->nullable();
            $table->string('gstin',45)->nullable();
            $table->string('company_email',45)->nullable();
            $table->string('company_phone',15)->nullable();;
            $table->string('website',45)->nullable();
            $table->string('street',45)->nullable();
            $table->string('city',45)->nullable();
            $table->integer('state')->nullable();
            $table->string('pincode',45)->nullable();
            $table->string('country',45)->nullable();
            $table->string('iec_code',25)->nullable();
            $table->string('cin_number',25)->nullable();
            $table->string('fssai_lic_number',25)->nullable();
            $table->string('invoice_prefix',25)->nullable();
            $table->string('invoice_number',25)->nullable();
            $table->string('credit_note_prefix',15)->nullable();
            $table->string('credit_note_number',10)->nullable();
            $table->string('estimate_prefix',25)->nullable();
            $table->string('estimate_number',25)->nullable();
            $table->boolean('product_price_gst')->nullable();
            $table->boolean('shipping_price_gst')->nullable();
            $table->boolean('shipping_gst')->nullable();
            $table->boolean('igst_on_export_order')->nullable();
            $table->longText('terms_and_condition')->nullable();
            $table->boolean('email_notification')->nullable();
            $table->text('email_notification_for_site_admin')->nullable();
            $table->bigInteger('job_id')->nullable();
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
        Schema::dropIfExists('company_settings');
    }
}
