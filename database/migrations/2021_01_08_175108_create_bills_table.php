<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->integer('tax_type')->comment('1 => Exclusive, 2 => Inclusive, 3 => Out of scope');
            $table->integer('payee_id');
            $table->date('bill_date');
            $table->string('payment_method',50);
            $table->string('bill_no',50)->nullable();
            $table->date('due_date');
            $table->integer('payment_term_id')->nullable();
            $table->integer('discount_level')->comment('0 => Transaction Level, 1 => Item Level');
            $table->string('amount_before_tax',20);
            $table->string('tax_amount',20);
            $table->string('total',20);
            $table->string('discount',20)->nullable();
            $table->integer('discount_type')->nullable();
            $table->text('memo')->nullable();
            $table->text('files')->nullable();
            $table->integer('status')->comment('1 => Open, 2 => Paid, 3 => Void, 4 => Overdue');
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
        Schema::dropIfExists('bills');
    }
}
