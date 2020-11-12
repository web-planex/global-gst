<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->integer('id',1);
            $table->integer('user_id');
            $table->text('logo_image')->nullable();
            $table->text('signature_image')->nullable();
            $table->string('store_name',20)->nullable();
            $table->string('brand_name',20)->nullable();
            $table->string('store_address',60)->nullable();
            $table->string('contact_person',20)->nullable();
            $table->string('store_phone',15)->nullable();
            $table->string('store_email',45)->nullable();
            $table->string('gst_number',25)->nullable();
            $table->string('iec_code',25)->nullable();
            $table->string('cin_number',25)->nullable();
            $table->string('pan_number',25)->nullable();
            $table->string('fssai_lic_number',25)->nullable();
            $table->string('invoice_prefix',25)->nullable();
            $table->string('invoice_number',25)->nullable();
            $table->string('credit_note_prefix',15)->nullable();
            $table->string('credit_note_number',10)->nullable();
            $table->boolean('product_price_gst')->nullable();
            $table->boolean('shipping_price_gst')->nullable();
            $table->boolean('shipping_gst')->nullable();
            $table->boolean('igst_on_export_order')->nullable();
            $table->longText('terms_and_condition')->nullable();
            $table->boolean('email_notification')->nullable();
            $table->text('email_notification_for_site_admin')->nullable();
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
        Schema::dropIfExists('invoice_settings');
    }
}
