<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('estimate_number',15);
            $table->integer('tax_type')->comment('(1 => Exclusive, 2 => Inclusive, 3 => Out of scope)');
            $table->integer('customer_id');
            $table->date('estimate_date');
            $table->date('expiry_date');
            $table->string('amount_before_tax',20);
            $table->string('tax_amount',20);
            $table->integer('discount_level')->comment('0 => Transaction Level, 1 => Item Level');
            $table->string('discount',20);
            $table->integer('discount_type');
            $table->string('total',20);
            $table->text('files')->nullable();
            $table->integer('shipping_charge')->default(0);
            $table->string('shipping_charge_amount',20)->nullable();
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
        Schema::dropIfExists('estimates');
    }
}
