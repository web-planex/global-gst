<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id',1);
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile')->nullable();
            $table->string('role')->comment("user, admin");
            $table->string('status')->default(1);
            $table->string('google_id')->nullable();
            $table->integer('plan_id')->nullable();
            $table->date('plan_start_at')->nullable();
            $table->date('plan_end_at')->nullable();
            $table->string('plan_allow_invoice_per_month',15)->nullable();
            $table->string('plan_invoice_count',15)->nullable();
            $table->string('plan_charge_amount',10)->nullable();
            $table->date('plan_trial_end_date')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => bcrypt('123456789'),
            'status' =>'1',
            'role' => 'admin'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
