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
            $table->string('pan_no',45)->nullable();
            $table->string('gstin',45)->nullable();
            $table->string('company_email',45)->nullable();
            $table->string('company_phone',15)->nullable();;
            $table->string('website',45)->nullable();
            $table->string('street',45)->nullable();
            $table->string('city',45)->nullable();
            $table->string('state',45)->nullable();
            $table->string('pincode',45)->nullable();
            $table->string('country',45)->nullable();
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
