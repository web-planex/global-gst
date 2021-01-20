<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfZipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf_zips', function (Blueprint $table) {
            $table->integer('id',1);
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('zip_name', 255);
            $table->tinyInteger('zip_type')->comment("1=Expense, 2=Sales, 3=Credit Note, 4=Estimate, 5=Bill");
            $table->tinyInteger('status')->comment("0=Not Downloaded,1=Downloaded");
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
        Schema::dropIfExists('pdf_zips');
    }
}
