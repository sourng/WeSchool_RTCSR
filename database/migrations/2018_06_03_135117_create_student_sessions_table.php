<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id');
            $table->integer('student_id');
            $table->integer('class_id');
            $table->integer('section_id');
            $table->string('roll',50);
			$table->integer('optional_subject')->nullable();
            $table->timestamps();
			//$table->unique('student_id', 'class_id','section_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_sessions');
    }
}
