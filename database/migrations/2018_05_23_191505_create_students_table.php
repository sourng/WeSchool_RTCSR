<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('parent_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday');
            $table->string('gender',10);
            $table->string('blood_group',4)->nullable();
            $table->string('religion',20)->nullable();
            $table->string('phone',20);
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('country',100);
            $table->string('register_no',50);
            $table->string('group')->nullable();
            $table->string('activities')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('students');
    }
}
