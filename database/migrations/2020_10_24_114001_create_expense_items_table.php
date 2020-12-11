<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_items', function (Blueprint $table) {
            $table->integer('id',1);
            $table->integer('expense_id');
            $table->integer('tax_id');
            $table->integer('product_id');
            $table->text('description');
            $table->string('hsn_code',8);
            $table->string('quantity', 10);
            $table->string('rate', 15);
            $table->string('amount', 15);
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
        Schema::dropIfExists('expense_items');
    }
}
