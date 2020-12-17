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
            $table->integer('tax_type')->comment('(1 => Exclusive, 2 => Inclusive, 3 => Out of scope)');
            $table->integer('customer_id');
            $table->string('customer_email',50);
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('place_of_supply',15);
            $table->string('amount_before_tax',20);
            $table->string('tax_amount',20);
            $table->string('total',20);
            $table->text('files')->nullable();
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
