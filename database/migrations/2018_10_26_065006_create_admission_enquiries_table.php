<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_enquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id');
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('phone',30);
            $table->string('email',100)->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->date('date');
            $table->date('next_follow_up_date')->nullable();
            $table->string('reference',20)->nullable();
            $table->string('source',20);
            $table->integer('class_id')->nullable();
            $table->integer('number_of_child')->nullable();
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
        Schema::dropIfExists('admission_enquiries');
    }
}
