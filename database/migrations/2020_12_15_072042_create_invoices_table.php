<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('invoice_number',15);
            $table->string('credit_note_number',15)->nullable();
            $table->string('order_number',15)->nullable();
            $table->string('reference_number',15)->nullable();
            $table->integer('tax_type')->comment('(1 => Exclusive, 2 => Inclusive, 3 => Out of scope)');
            $table->integer('customer_id');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('place_of_supply',15);
            $table->string('amount_before_tax',20);
            $table->string('tax_amount',20);
            $table->string('discount',20);
            $table->integer('discount_type',20);
            $table->string('total',20);
            $table->text('files')->nullable();
            $table->string('payment_method',50);
            $table->string('payment_terms',50);
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
