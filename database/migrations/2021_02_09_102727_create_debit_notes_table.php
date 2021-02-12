<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_notes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('debit_note_number',15)->nullable();
            $table->integer('ref_invoice_id');
            $table->date('ref_invoice_date');
            $table->integer('tax_type')->comment('(1 => Exclusive, 2 => Inclusive, 3 => Out of scope)');
            $table->integer('customer_id');
            $table->string('payment_method',50);
            $table->date('debit_note_date');
            $table->date('due_date');
            $table->integer('payment_term_id')->nullable();;
            $table->string('amount_before_tax',20);
            $table->string('tax_amount',20);
            $table->integer('discount_level')->comment('0 => Transaction Level, 1 => Item Level');
            $table->string('discount',20)->nullable();
            $table->tinyInteger('discount_type')->nullable()->comment('1 => Percentage (%), 2 => Rs.');
            $table->string('total',20);
            $table->text('files')->nullable();
            $table->integer('status')->nullable();
            $table->integer('shipping_charge')->default(0);
            $table->string('shipping_charge_amount',20)->nullable();
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
        Schema::dropIfExists('debit_notes');
    }
}
