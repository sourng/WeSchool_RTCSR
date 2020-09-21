<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->bigIncrements('id');
            
			$table->integer('user_id');
			$table->integer('month');
			$table->integer('year');
            $table->decimal('current_salary', 8,2);
            $table->decimal('expense_claim', 8,2);
            $table->decimal('absent_fine', 8,2);
            $table->decimal('net_salary', 8,2);
			$table->integer('status');

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
        Schema::dropIfExists('payslips');
    }
}
